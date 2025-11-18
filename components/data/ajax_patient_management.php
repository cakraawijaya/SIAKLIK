<?php
$require_login = true;
include __DIR__ . '/../features/auth/authorization/worker.php';
include __DIR__ . '/../../config/config.php';

$per_page = 3; // jumlah data per halaman

// ======================== FUNGSI PEMBANTU ========================
function get_patients_history($per_page, $page_param, $search = '') {
    global $koneksi;
    $page = isset($_GET[$page_param]) && $_GET[$page_param] > 1 ? (int)$_GET[$page_param] : 1;
    $offset = ($page - 1) * $per_page;

    $s = mysqli_real_escape_string($koneksi, $search);

    // Tambahkan semua kolom yang ingin dicari
    $where = '';
    if ($search !== '') {
        $where = "WHERE 
            nama LIKE '%$s%' OR
            alamat LIKE '%$s%' OR
            nim_nip LIKE '%$s%'";
    }

    $query = "SELECT * FROM riwayat_pasien $where 
          ORDER BY CAST(SUBSTRING_INDEX(id,'-',-1) AS UNSIGNED) ASC
          LIMIT $per_page OFFSET $offset";

    $result = mysqli_query($koneksi, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    $count_query = "SELECT COUNT(*) AS cnt FROM riwayat_pasien $where";
    $count_res = mysqli_query($koneksi, $count_query);
    $count_row = mysqli_fetch_assoc($count_res);
    $total_data = (int)$count_row['cnt'];
    $total_page = ceil($total_data / $per_page);

    return [
        'data' => $rows,
        'totalPage' => $total_page,
        'currentPage' => $page,
        'total' => $total_data
    ];
}

// ======================== GENERATE ID PASIEN ========================
function generate_id($koneksi) {
    $tahun = date('Y');
    $id_key = "PS-$tahun"; // key unik per tahun

    // Ambil last_number dari hitung_pasien
    $res = mysqli_query($koneksi, "SELECT last_number FROM hitung_pasien WHERE id_pasien='$id_key' LIMIT 1");
    $lastNumberHP = 0;
    if ($row = mysqli_fetch_assoc($res)) {
        $lastNumberHP = (int)$row['last_number'];
    }

    // Ambil last_number dari riwayat_pasien (bagian [5 digit] terakhir)
    $res2 = mysqli_query($koneksi, "SELECT id FROM riwayat_pasien WHERE id LIKE '$id_key-%' ORDER BY id DESC LIMIT 1");
    $lastNumberDB = 0;
    if ($row2 = mysqli_fetch_assoc($res2)) {
        $parts = explode('-', $row2['id']);
        $lastNumberDB = (int)end($parts);
    }

    // Tentukan nomor berikutnya
    $nextNumber = max($lastNumberHP, $lastNumberDB) + 1;

    // Update atau insert hitung_pasien agar sinkron
    if ($row) {
        $update = mysqli_query($koneksi, "UPDATE hitung_pasien SET last_number=$nextNumber WHERE id_pasien='$id_key'");
        if (!$update) {
            throw new Exception("Gagal update hitung_pasien: " . mysqli_error($koneksi));
        }
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO hitung_pasien (id_pasien, last_number) VALUES ('$id_key', $nextNumber)");
        if (!$insert) {
            throw new Exception("Gagal insert hitung_pasien: " . mysqli_error($koneksi));
        }
    }

    // Format 4 digit
    $id_pasien = $id_key . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    return $id_pasien;
}

// ======================== HANDLE REQUEST ========================
$action = $_GET['action'] ?? $_POST['action'] ?? '';
$id = $_REQUEST['id'] ?? '';

header('Content-Type: application/json; charset=utf-8');

try {
    // === LIST DATA ===
    if ($action === 'list') {
        $search = $_GET['search'] ?? '';
        $res = get_patients_history($per_page, 'page', $search);
        echo json_encode($res);
        exit;
    }

    // === GET DATA BY ID ===
    elseif ($action === 'get') {
        if (!$id) throw new Exception('ID pasien tidak valid');
        $query = "SELECT * FROM riwayat_pasien WHERE id='$id'";
        $result = mysqli_query($koneksi, $query);
        $data = mysqli_fetch_assoc($result);
        if (!$data) throw new Exception('Data pasien tidak ditemukan');
        echo json_encode(['success' => true, 'data' => $data]);
        exit;
    }

    // === CREATE DATA ===
    elseif ($action === 'create') {
        $nama = trim($_POST['nama'] ?? '');
        $umur = trim($_POST['umur'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $pekerjaan = trim($_POST['pekerjaan'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
        $nim_nip = trim($_POST['nim_nip'] ?? '');
        $no_bpjs = trim($_POST['no_bpjs'] ?? '');
        $layanan = trim($_POST['layanan'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($nama === '' || $umur === '' || $alamat === '') {
            throw new Exception('Nama, umur, dan alamat wajib diisi.');
        }

        // === Generate ID baru ===
        $id = generate_id($koneksi);

        $stmt = $koneksi->prepare("INSERT INTO riwayat_pasien (id, nama, umur, alamat, pekerjaan, status, jenis_kelamin, nim_nip, no_bpjs, layanan, keterangan, waktu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssssssss", $id, $nama, $umur, $alamat, $pekerjaan, $status, $jenis_kelamin, $nim_nip, $no_bpjs, $layanan, $keterangan);
        if (!$stmt->execute()) {
            throw new Exception('Gagal menambah data pasien: ' . $stmt->error);
        }

        // Ambil waktu yang baru saja disimpan agar frontend bisa highlight berdasarkan waktu
        $res_time = mysqli_query($koneksi, "SELECT waktu FROM riwayat_pasien WHERE id='$id' LIMIT 1");
        $row_time = mysqli_fetch_assoc($res_time);
        $inserted_time = $row_time['waktu'] ?? date('Y-m-d H:i:s');

        echo json_encode([
            'success' => true,
            'message' => 'Data pasien berhasil ditambahkan',
            'inserted_id' => $id,
            'inserted_time' => $inserted_time
        ]);
        exit;
    }

    // === UPDATE DATA ===
    elseif ($action === 'update') {
        if (!$id) throw new Exception('ID tidak dikirim');

        $nama = trim($_POST['nama'] ?? '');
        $umur = trim($_POST['umur'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $pekerjaan = trim($_POST['pekerjaan'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
        $nim_nip = trim($_POST['nim_nip'] ?? '');
        $no_bpjs = trim($_POST['no_bpjs'] ?? '');
        $layanan = trim($_POST['layanan'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        $stmt = $koneksi->prepare("UPDATE riwayat_pasien SET nama=?, umur=?, alamat=?, pekerjaan=?, status=?, jenis_kelamin=?, nim_nip=?, no_bpjs=?, layanan=?, keterangan=? WHERE id=?");
        $stmt->bind_param("sssssssssss", $nama, $umur, $alamat, $pekerjaan, $status, $jenis_kelamin, $nim_nip, $no_bpjs, $layanan, $keterangan, $id);
        if (!$stmt->execute()) {
            throw new Exception('Gagal memperbarui data pasien: ' . $stmt->error);
        }

        // Ambil kembali baris yang diupdate untuk waktu (agar frontend bisa highlight)
        $res_time = mysqli_query($koneksi, "SELECT waktu FROM riwayat_pasien WHERE id='$id' LIMIT 1");
        $row_time = mysqli_fetch_assoc($res_time);
        $updated_time = $row_time['waktu'] ?? null;

        echo json_encode([
            'success' => true,
            'message' => 'Data pasien berhasil diperbarui',
            'updated_id' => $id,
            'updated_time' => $updated_time
        ]);
        exit;
    }

    // === DELETE DATA ===
    elseif ($action === 'delete') {
        if (!$id) throw new Exception('ID tidak dikirim');

        $check = mysqli_query($koneksi, "SELECT * FROM riwayat_pasien WHERE id='$id'");
        if (mysqli_num_rows($check) === 0) {
            throw new Exception('Data pasien tidak ditemukan');
        }

        $delete = mysqli_query($koneksi, "DELETE FROM riwayat_pasien WHERE id='$id'");
        if (!$delete) throw new Exception('Gagal menghapus data pasien: ' . mysqli_error($koneksi));

        echo json_encode(['success' => true, 'message' => 'Data pasien berhasil dihapus']);
        exit;
    }

    else {
        throw new Exception('Aksi tidak valid.');
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>