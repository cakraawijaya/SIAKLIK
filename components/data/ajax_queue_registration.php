<?php

    // ======================== CONFIG & AUTH ========================
    $require_login = true; // harus login
    include __DIR__ . '/../features/auth/authorization/patient.php';

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../config/config.php';



    // ===================== PENGATURAN LAINNYA ======================

    // Ambil variabel session
    $username = $_SESSION['username'] ?? null;
    $level    = $_SESSION['level'] ?? null;

    // Ambil POST
    $kategori = strtoupper(trim($_POST['kategori'] ?? ''));
    $layanan  = trim($_POST['layanan'] ?? '');
    $request_token = trim($_POST['request_token'] ?? '');

    // Validasi basic
    if (!$kategori || !$layanan) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']);
        exit;
    }
    if (!$request_token) {
        echo json_encode(['status' => 'error', 'message' => 'Missing request token.']);
        exit;
    }

    // Idempotent check
    if (isset($_SESSION['processed_requests'][$request_token])) {
        $existing_code = $_SESSION['processed_requests'][$request_token];
        echo json_encode(['status' => 'duplicate', 'kode_antrean' => $existing_code, 'message' => 'Request sudah diproses sebelumnya.']);
        exit;
    }

    // Hak akses role
    $allowed = false;
    if (in_array($level, ['admin', 'pekerja'])) {
        $allowed = in_array($kategori, ['INTERNAL', 'BPJS', 'UMUM']);
    } elseif ($level === 'pasien') {
        $allowed = in_array($kategori, ['BPJS', 'UMUM']);
    }
    if (!$allowed) {
        echo json_encode(['status' => 'error', 'message' => 'Anda tidak dapat mendaftar di kategori ini! Silakan pilih BPJS atau UMUM.']);
        exit;
    }

    // Ambil nama user
    $nama = null;
    $stmt = $koneksi->prepare("
        SELECT nama FROM akun_pekerja WHERE username = ?
        UNION
        SELECT nama FROM akun_pasien WHERE username = ?
        LIMIT 1
    ");
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $stmt->bind_result($nama);
    $stmt->fetch();
    $stmt->close();
    if (empty($nama)) {
        echo json_encode(['status' => 'error', 'message' => 'Nama user tidak ditemukan.']);
        exit;
    }

    // Cek antrean aktif
    $stmt = $koneksi->prepare("SELECT kode_antrean FROM antrean WHERE username = ? AND kategori = ? AND status_antrean != 'Selesai' ORDER BY waktu_daftar DESC LIMIT 1");
    $stmt->bind_param('ss', $username, $kategori);
    $stmt->execute();
    $stmt->bind_result($existing_kode);
    $has_existing = $stmt->fetch();
    $stmt->close();

    if ($has_existing) {
        echo json_encode(['status' => 'error_duplicate', 'message' => 'Anda masih memiliki antrean aktif saat ini! Antrean baru tidak bisa dibuat.', 'kode_antrean' => $existing_kode]);
        exit;
    }

    // Prefix map
    $prefix_map = ['INTERNAL' => 'A', 'BPJS' => 'B', 'UMUM' => 'C'];
    if (!isset($prefix_map[$kategori])) {
        echo json_encode(['status' => 'error', 'message' => 'Kategori tidak valid.']);
        exit;
    }
    $prefix = $prefix_map[$kategori];

    // Transaksi
    try {
        $koneksi->begin_transaction();

        // Ambil last_number dan last_reset (lock) jika ada
        $stmt = $koneksi->prepare("SELECT last_number, last_reset FROM hitung_antrean WHERE kategori = ? FOR UPDATE");
        $stmt->bind_param('s', $kategori);
        $stmt->execute();
        $stmt->bind_result($last_number, $last_reset);
        $fetched = $stmt->fetch();
        $stmt->close();

        // Ambil nilai maksimal nomor dari tabel antrean (untuk menjaga konsistensi bila last_number diubah manual)
        $stmt = $koneksi->prepare("SELECT MAX(CAST(SUBSTRING(kode_antrean,2) AS UNSIGNED)) AS max_no FROM antrean WHERE kategori = ?");
        $stmt->bind_param('s', $kategori);
        $stmt->execute();
        $stmt->bind_result($max_in_antrean);
        $stmt->fetch();
        $stmt->close();

        // Normalisasi nilai
        $last_number = is_null($last_number) ? 0 : intval($last_number);
        $max_in_antrean = is_null($max_in_antrean) ? 0 : intval($max_in_antrean);

        $today = date('Y-m-d');

        if (!$fetched) {
            // Jika belum ada row hitung_antrean, siapin row baru berdasarkan max_in_antrean
            $next_number = $max_in_antrean + 1;
            if ($next_number > 9999) {
                $koneksi->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Nomor antrean telah mencapai batas maksimal.']);
                exit;
            }

            $stmt = $koneksi->prepare("INSERT INTO hitung_antrean (kategori, last_number, last_reset) VALUES (?, ?, ?)");
            $stmt->bind_param('sis', $kategori, $next_number, $today);
            if (!$stmt->execute()) {
                $err = $stmt->error;
                $stmt->close();
                $koneksi->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Gagal inisialisasi counter: '.$err]);
                exit;
            }
            $stmt->close();

            // Set last_number sesuai insert
            $last_number = $next_number;
        } else {
            // Jika row ada, cek reset harian
            if ($last_reset != $today) {
                // Pada reset harian kita set last_reset ke hari ini.
                // Namun agar tetap konsisten dengan data di tabel antrean (jika admin manipulasi),
                // kita set last_number minimal ke max_in_antrean agar tidak terjadi duplikasi/penurunan nomor.
                $base = max(0, $max_in_antrean);
                $last_number = $base;
                $stmt = $koneksi->prepare("UPDATE hitung_antrean SET last_number = ?, last_reset = ? WHERE kategori = ?");
                $stmt->bind_param('iss', $last_number, $today, $kategori);
                if (!$stmt->execute()) {
                    $err = $stmt->error;
                    $stmt->close();
                    $koneksi->rollback();
                    echo json_encode(['status' => 'error', 'message' => 'Gagal reset counter: '.$err]);
                    exit;
                }
                $stmt->close();
            }

            // Tentukan next_number berdasarkan nilai terbesar antara last_number dan max di antrean
            $next_number = max(intval($last_number), intval($max_in_antrean)) + 1;
            if ($next_number > 9999) {
                $koneksi->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Nomor antrean telah mencapai batas maksimal.']);
                exit;
            }

            // Update last_number ke next_number agar tercatat
            $stmt = $koneksi->prepare("UPDATE hitung_antrean SET last_number = ? WHERE kategori = ?");
            $stmt->bind_param('is', $next_number, $kategori);
            if (!$stmt->execute()) {
                $err = $stmt->error;
                $stmt->close();
                $koneksi->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Gagal update counter: '.$err]);
                exit;
            }
            $stmt->close();
        }

        // Jika sebelumnya kita belum menentukan $next_number (pada cabang insert), hitung sekarang
        if (!isset($next_number)) {
            $next_number = intval($last_number) + 1;
            if ($next_number > 9999) {
                $koneksi->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Nomor antrean telah mencapai batas maksimal.']);
                exit;
            }
            // Pastikan last_number disimpan (untuk safety)
            $stmt = $koneksi->prepare("UPDATE hitung_antrean SET last_number = ? WHERE kategori = ?");
            $stmt->bind_param('is', $next_number, $kategori);
            $stmt->execute();
            $stmt->close();
        }

        // Generate kode antrean (prefix + 4 digit)
        $kode_antrean = $prefix . str_pad($next_number, 4, '0', STR_PAD_LEFT);

        // Insert ke tabel antrean
        $stmt = $koneksi->prepare("
            INSERT INTO antrean (kode_antrean, username, nama, layanan, kategori, status_antrean, waktu_daftar)
            VALUES (?, ?, ?, ?, ?, 'Menunggu', NOW())
        ");
        $stmt->bind_param('sssss', $kode_antrean, $username, $nama, $layanan, $kategori);
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            $koneksi->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Gagal insert antrean: '.$err]);
            exit;
        }
        $stmt->close();

        // Commit transaksi
        $koneksi->commit();

        // Tandai request token sudah diproses (idempotent)
        $_SESSION['processed_requests'][$request_token] = $kode_antrean;
        if (count($_SESSION['processed_requests']) > 200) {
            $_SESSION['processed_requests'] = array_slice($_SESSION['processed_requests'], -100, 100, true);
        }

        echo json_encode(['status' => 'success', 'kode_antrean' => $kode_antrean, 'message' => 'Antrean berhasil dibuat']);
        exit;

    } catch (Exception $e) {
        if ($koneksi->in_transaction) $koneksi->rollback();
        error_log('Queue error: '.$e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan server.']);
        exit;
    }

    // Return JSON
    header('Content-Type: application/json; charset=utf-8');

?>