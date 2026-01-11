<?php

    // ======================== CONFIG & AUTH ========================
    $require_login = true; // harus login
    include __DIR__ . '/../features/auth/authorization/admin.php';

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../config/config.php';


    // ======================== DATA PER PAGE ========================
    $per_page = 5;


    // ======================== IMAGE SETTINGS =======================
    $upload_dir = __DIR__ . '/../../public/assets/img/photo/';
    $max_file_size = 2 * 1024 * 1024; // 2MB
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];


    // ========================== SESSION ============================
    $username      =  $_SESSION['username'];
    $level         =  $_SESSION['level'];
    $nama_lengkap  =  $_SESSION['nama_lengkap'];
    $nama_depan    =  '';
    if ($nama_lengkap !== '') { $nama_depan = explode(' ', trim($nama_lengkap))[0]; }



    // ========================== HELPERS ============================
    function send_json($arr) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($arr);
        exit;
    }

    function clean($s) {
        global $koneksi;
        return mysqli_real_escape_string($koneksi, trim($s));
    }

    function handle_upload($field_name) {
        global $upload_dir, $allowed_ext, $max_file_size;
        if (!isset($_FILES[$field_name]) || $_FILES[$field_name]['error'] !== 0) return null;

        $f = $_FILES[$field_name];
        if ($f['size'] > $max_file_size) return ['error' => 'Ukuran file foto terlalu besar'];

        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) return ['error' => 'Ekstensi file tidak diperbolehkan'];

        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $target = uniqid('user_') . '.' . $ext;
        if (!move_uploaded_file($f['tmp_name'], $upload_dir . $target)) return ['error' => 'Gagal menyimpan file'];

        return ['file' => $target];
    }



    // ========================== CAPTCHA ============================
    function verify_captcha($kode, $captcha_id) {
        $session_key = 'captcha_' . $captcha_id;
        if (!isset($_SESSION[$session_key])) return false;
        $valid = strtolower(trim($kode)) === strtolower($_SESSION[$session_key]);
        unset($_SESSION[$session_key]); // captcha sekali pakai
        return $valid;
    }

    // =================== PAGINATE & SORT NATURAL ===================
    function get_paginated_users($kategori, $per_page, $page_param, $search = '') {
        global $koneksi, $upload_dir;
        $page = isset($_GET[$page_param]) && $_GET[$page_param] > 1 ? (int)$_GET[$page_param] : 1;
        $offset = ($page - 1) * $per_page;
        $s = mysqli_real_escape_string($koneksi, $search);
        $where_search = $search !== '' ? "AND (email LIKE '%$s%' OR username LIKE '%$s%' OR nama LIKE '%$s%')" : '';

        if ($kategori === 'pasien') {
            $table = "akun_pasien";
            $where_clause = "WHERE 1=1 $where_search";
        } else if ($kategori === 'pekerja' || $kategori === 'admin') {
            $table = "akun_pekerja";
            $role_id = ($kategori === 'admin') ? 1 : 2;
            $where_clause = "WHERE role_id=$role_id $where_search";
        } else return ['data' => [], 'total_page' => 1, 'current_page' => 1, 'total_data' => 0];

        // Hitung total data
        $cnt_sql = "SELECT COUNT(*) AS cnt FROM $table $where_clause";
        $cnt_q = mysqli_query($koneksi, $cnt_sql);
        $cnt_row = mysqli_fetch_assoc($cnt_q);
        $total_data = (int)$cnt_row['cnt'];

        // Query data dengan natural sort
        $sql = "SELECT email, foto, username, nama FROM $table
                $where_clause
                ORDER BY
                    REGEXP_REPLACE(email, '[0-9]', '') ASC,
                    CAST(REGEXP_SUBSTR(email, '[0-9]+') AS UNSIGNED) ASC,
                    email ASC
                LIMIT $per_page OFFSET $offset";

        $rows = [];
        $q = mysqli_query($koneksi, $sql);
        while($r = mysqli_fetch_assoc($q)) {
            $r['foto'] = (!isset($r['foto']) || $r['foto'] === '' || !file_exists($upload_dir . $r['foto'])) ? 'default.png' : $r['foto'];
            $rows[] = $r;
        }

        $total_page = $per_page > 0 ? ceil($total_data / $per_page) : 1;
        return ['data' => $rows, 'total_page' => $total_page, 'current_page' => $page, 'total_data' => $total_data];
    }


    // =================== GET PAGE UNTUK HIGHLIGHT ==================
    function get_user_page($kategori, $email, $per_page) {
        global $koneksi;

        $email = mysqli_real_escape_string($koneksi, $email);

        if ($kategori === 'pasien') {
            $table = "akun_pasien";
            $where = "WHERE 1=1";
        } else if ($kategori === 'pekerja' || $kategori === 'admin') {
            $role_id = ($kategori === 'admin') ? 1 : 2;
            $table = "akun_pekerja";
            $where = "WHERE role_id=$role_id";
        } else {
            return 1;
        }

        $sql = "
            SELECT COUNT(*) AS rank FROM $table
            $where AND (
                REGEXP_REPLACE(email,'[0-9]','') <
                REGEXP_REPLACE('$email','[0-9]','')
                OR (
                    REGEXP_REPLACE(email,'[0-9]','') =
                    REGEXP_REPLACE('$email','[0-9]','')
                    AND (
                        CAST(REGEXP_SUBSTR(email,'[0-9]+') AS UNSIGNED) <
                        CAST(REGEXP_SUBSTR('$email','[0-9]+') AS UNSIGNED)
                        OR (
                            CAST(REGEXP_SUBSTR(email,'[0-9]+') AS UNSIGNED) =
                            CAST(REGEXP_SUBSTR('$email','[0-9]+') AS UNSIGNED)
                            AND email <= '$email'
                        )
                    )
                )
            )
        ";

        $res = mysqli_query($koneksi, $sql);
        $count = 0;
        if ($res && $row = mysqli_fetch_assoc($res)) {
            $count = (int)$row['rank'];
        }

        return max(1, ceil($count / $per_page));
    }


    // ============================ READ =============================
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search = $_GET['search'] ?? '';
        $users = [
            'pasien' => get_paginated_users('pasien', $per_page, 'link_pasien', $search),
            'pekerja' => get_paginated_users('pekerja', $per_page, 'link_pekerja', $search),
            'admin' => get_paginated_users('admin', $per_page, 'link_admin', $search),
        ];
        send_json(['users' => $users]);
    }

    // ========================= POST CRUD ===========================
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $kategori = isset($_POST['kategori']) ? clean($_POST['kategori']) : '';
        $kode = $_POST['kode'] ?? '';

        // Tentukan captcha ID sesuai kategori & form
        $kategori = isset($_POST['kategori']) ? clean($_POST['kategori']) : '';
        $kode = $_POST['kode'] ?? '';

        $captcha_id = '';

        if (isset($_POST['submit_add_user'])) {
            $captcha_id = 'add_user_' . $kategori;
        } 
        else if (isset($_POST['submit_edit_user'])) {
            $captcha_id = 'edit_user_' . $kategori;
        }

        if ($captcha_id && !verify_captcha($kode, $captcha_id)) {
            send_json(['success' => false, 'msg' => 'Kode captcha salah']);
        }

        // =================== Role Name untuk Alert =====================
        if ($kategori === 'pasien') $role_name = 'pasien';
        else if ($kategori === 'pekerja') $role_name = 'pekerja';
        else if ($kategori === 'admin') $role_name = 'admin';
        else $role_name = 'pengguna';

        $msg_success_add = "Akun $role_name berhasil ditambahkan";
        $msg_success_update = "Akun $role_name berhasil diperbarui";
        $msg_success_delete = "Akun $role_name berhasil dihapus";

        // ========================== CREATE =============================
        if (isset($_POST['submit_add_user'])) {
            $raw_username = $_POST['add-username'] ?? '';
            $username_akun = strtolower(preg_replace('/[^a-z0-9]/i', '', $raw_username));
            $raw_name = $_POST['add-name'] ?? '';
            $nama_akun = ucwords(strtolower(trim($raw_name)));
            $email = strtolower(clean($_POST['add-email'] ?? ''));
            $raw_password = $_POST['add-password'] ?? '';
            $raw_password_confirm = $_POST['add-confirm-password'] ?? '';

            if ($username_akun === '' || $nama_akun === '' || $email === '' || $raw_password === '') {
                send_json(['success' => false, 'msg' => 'Field wajib belum lengkap']);
            }
            
            // ===================== VALIDASI PASSWORD =======================
            if (strlen($raw_password) < 8) {
                send_json([
                    'success' => false,
                    'msg' => 'Password harus minimal 8 karakter'
                ]);
            }
            if ($raw_password !== $raw_password_confirm) {
                send_json(['success' => false, 'msg' => 'Password dan Konfirmasi Password tidak sama']);
            }
            if (!preg_match('/[^A-Za-z0-9]/', $raw_password)) {
                send_json([
                    'success' => false,
                    'msg' => 'Password harus mengandung minimal 1 karakter khusus (!@#$%^&* dll)'
                ]);
            }

            // ======================= CEK DUPLIKAT ==========================
            // Cek Email di Kedua Tabel
            $checkEmail = mysqli_query($koneksi, "
                SELECT email FROM akun_pasien WHERE email='$email' UNION
                SELECT email FROM akun_pekerja WHERE email='$email' LIMIT 1
            ");

            if (mysqli_num_rows($checkEmail) > 0) {
                send_json(['success' => false, 'msg' => 'Email yang diisikan sudah terpakai di akun lain']);
            }

            // Cek Username di Kedua Tabel
            $checkUsername = mysqli_query($koneksi, "
                SELECT username FROM akun_pasien WHERE username='$username_akun' UNION
                SELECT username FROM akun_pekerja WHERE username='$username_akun' LIMIT 1
            ");

            if (mysqli_num_rows($checkUsername) > 0) {
                send_json(['success' => false, 'msg' => 'Username yang diisikan sudah terpakai di akun lain']);
            }

            // Upload foto
            $foto = 'default.png';
            $uploadRes = handle_upload('add-foto');
            if ($uploadRes && isset($uploadRes['error'])) send_json(['success' => false, 'msg' => $uploadRes['error']]);
            if ($uploadRes && isset($uploadRes['file'])) $foto = $uploadRes['file'];

            $pwd_hash = password_hash($raw_password, PASSWORD_DEFAULT);

            if ($kategori === 'pasien') {
                $stmt = $koneksi->prepare("INSERT INTO akun_pasien (email, foto, username, nama, password, role_id) VALUES (?,?,?,?,?,?)");
                $roleid_pasien = 3;
                $stmt->bind_param("sssssi", $email, $foto, $username_akun, $nama_akun, $pwd_hash, $roleid_pasien);
                $exec = $stmt->execute();
                $err = $stmt->error;
                $stmt->close();
                
                if ($exec) {
                    // Format level
                    $level = ucfirst(strtolower($level));

                    // Log User: Tambah Akun Pasien
                    mysqli_query($koneksi, "
                        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                        VALUES ('$username', '$level', 'Tambah Akun', '$nama_depan telah menambahkan akun baru a/n. $nama_akun (Username: $username_akun) sebagai Pasien.', NOW())
                    ");

                    $pageBaru = get_user_page($kategori, $email, $per_page);
                    send_json([
                        'success' => true,
                        'msg' => $msg_success_add,
                        'highlight_email' => $email,
                        'highlight_page' => $pageBaru
                    ]);
                }
                send_json(['success' => false, 'msg' => 'Gagal menyimpan: '.$err]);

            } else {
                $role_id = ($kategori === 'admin') ? 1 : 2;
                $stmt = $koneksi->prepare("INSERT INTO akun_pekerja (email, foto, username, nama, password, role_id) VALUES (?,?,?,?,?,?)");
                $stmt->bind_param("sssssi", $email, $foto, $username_akun, $nama_akun, $pwd_hash, $role_id);
                $exec = $stmt->execute();
                $err = $stmt->error;
                $stmt->close();

                if ($exec) {
                    // Format level
                    $level = ucfirst(strtolower($level));
                    
                    // Log User: Tambah Akun Admin / Pekerja
                    $peran = ($kategori === 'admin') ? 'admin' : 'pekerja';
                    mysqli_query($koneksi, "
                        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                        VALUES ('$username', '$level', 'Tambah Akun', '$nama_depan telah menambahkan akun baru a/n. $nama_akun (Username: $username_akun) sebagai " . ucfirst(strtolower($peran)) . ".', NOW())
                    ");

                    $pageBaru = get_user_page($kategori, $email, $per_page);
                    send_json([
                        'success' => true,
                        'msg' => $msg_success_add,
                        'highlight_email' => $email,
                        'highlight_page' => $pageBaru
                    ]);
                }
                send_json(['success' => false, 'msg' => 'Gagal menyimpan: '.$err]);
            }
        }

        // ========================== UPDATE =============================
        if (isset($_POST['submit_edit_user'])) {
            $email_lama = clean($_POST['edit-email-lama'] ?? '');
            $email_baru = strtolower(clean($_POST['edit-email'] ?? ''));
            $raw_username = $_POST['edit-username'] ?? '';
            $username_akun = strtolower(preg_replace('/[^a-z0-9]/i', '', $raw_username));
            $raw_name = $_POST['edit-name'] ?? '';
            $nama_akun = ucwords(strtolower(trim($raw_name)));
            $raw_password = $_POST['edit-password'] ?? '';
            $raw_password_confirm = $_POST['edit-confirm-password'] ?? '';

            if ($email_lama === '' || $email_baru === '' || $username_akun === '' || $nama_akun === '') {
                send_json(['success' => false, 'msg' => 'Field wajib belum lengkap']);
            }


            // ====== AMBIL USERNAME LAMA AKUN (UNTUK CEK AKUN SENDIRI) ======
            if ($kategori === 'pasien') {
                $resU = mysqli_query($koneksi, "SELECT username FROM akun_pasien WHERE email='$email_lama' LIMIT 1");
            } else {
                $role_id = ($kategori === 'admin') ? 1 : 2;
                $resU = mysqli_query($koneksi, "SELECT username FROM akun_pekerja WHERE email='$email_lama' AND role_id=$role_id LIMIT 1");
            }
            $dataU = mysqli_fetch_assoc($resU);
            $username_lama = $dataU['username'] ?? null;


            // ======================= CEK DUPLIKAT ==========================
            $checkEmail = mysqli_query($koneksi, "
                SELECT email FROM akun_pasien WHERE email='$email_baru' AND email<>'$email_lama' UNION 
                SELECT email FROM akun_pekerja WHERE email='$email_baru' AND email<>'$email_lama' LIMIT 1
            ");
            if (mysqli_num_rows($checkEmail) > 0) {
                send_json(['success' => false, 'msg' => 'Email yang diisikan sudah terpakai di akun lain']);
            }

            $checkUsername = mysqli_query($koneksi, "
                SELECT username FROM akun_pasien WHERE username='$username_akun' AND email<>'$email_lama' UNION 
                SELECT username FROM akun_pekerja WHERE username='$username_akun' AND email<>'$email_lama' LIMIT 1
            ");
            if (mysqli_num_rows($checkUsername) > 0) {
                send_json(['success' => false, 'msg' => 'Username yang diisikan sudah terpakai di akun lain']);
            }

            // ===================== VALIDASI PASSWORD =======================
            $pwd_hash = null; // default: tidak diubah
            if ($raw_password !== '') {
                // Ambil password lama dari database
                if ($kategori === 'pasien') {
                    $res = mysqli_query($koneksi, "SELECT password FROM akun_pasien WHERE email='$email_lama' LIMIT 1");
                } else {
                    $role_id = ($kategori === 'admin') ? 1 : 2;
                    $res = mysqli_query($koneksi, "SELECT password FROM akun_pekerja WHERE email='$email_lama' AND role_id=$role_id LIMIT 1");
                }
                
                $pwd_lama = '';
                if ($res && $row = mysqli_fetch_assoc($res)) {
                    $pwd_lama = $row['password'];
                }

                // Cek apakah password baru sama dengan password lama
                if (password_verify($raw_password, $pwd_lama)) {
                    send_json([
                        'success' => false,
                        'msg' => 'Password baru tidak boleh sama dengan password lama'
                    ]);
                }

                // Validasi minimal 8 karakter
                if (strlen($raw_password) < 8) {
                    send_json([
                        'success' => false,
                        'msg' => 'Password harus minimal 8 karakter'
                    ]);
                }
                // Cek konfirmasi
                if ($raw_password !== $raw_password_confirm) {
                    send_json(['success' => false, 'msg' => 'Password dan Konfirmasi Password tidak sama']);
                }
                // Harus ada karakter khusus
                if (!preg_match('/[^A-Za-z0-9]/', $raw_password)) {
                    send_json([
                        'success' => false,
                        'msg' => 'Password harus mengandung minimal 1 karakter khusus (!@#$%^&* dll)'
                    ]);
                }

                $pwd_hash = password_hash($raw_password, PASSWORD_DEFAULT);
            }

            // ======================== UPLOAD FOTO ==========================
            $foto_new = null;
            $uploadRes = handle_upload('edit-foto');
            if ($uploadRes && isset($uploadRes['error'])) send_json(['success' => false, 'msg' => $uploadRes['error']]);
            if ($uploadRes && isset($uploadRes['file'])) $foto_new = $uploadRes['file'];

            // ======================= BUILD UPDATE ==========================
            $updateParts = []; $params = []; $types = '';
            $updateParts[] = "email=?"; $params[] = $email_baru; $types .= 's';
            $updateParts[] = "username=?"; $params[] = $username_akun; $types .= 's';
            $updateParts[] = "nama=?"; $params[] = $nama_akun; $types .= 's';

            if ($pwd_hash !== null) {
                $updateParts[] = "password=?"; $params[] = $pwd_hash; $types .= 's';
            }

            if ($foto_new !== null) {
                $updateParts[] = "foto=?";
                $params[] = $foto_new;
                $types .= 's';
            }

            $setClause = implode(', ', $updateParts);

            // ======================= QUERY UPDATE ==========================
            if ($kategori === 'pasien') {
                if ($foto_new !== null) {
                    $res = mysqli_query($koneksi, "SELECT foto FROM akun_pasien WHERE email='$email_lama' LIMIT 1");
                    if ($res && mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);
                        $foto_old = $row['foto'] ?? 'default.png';
                        if ($foto_old !== 'default.png' && file_exists($upload_dir.$foto_old)) unlink($upload_dir.$foto_old);
                    }
                }
                $stmt = $koneksi->prepare("UPDATE akun_pasien SET $setClause WHERE email=?");
                $params[] = $email_lama;
                $types .= 's';
                $stmt->bind_param($types,...$params);
                $exec = $stmt->execute();
                $err = $stmt->error;
                $stmt->close();

                if ($exec) {
                    // Format level
                    $level = ucfirst(strtolower($level));

                    // Log User: Ubah Akun Pasien
                    mysqli_query($koneksi, "
                        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                        VALUES ('$username', '$level', 'Ubah Akun', '$nama_depan telah mengubah data akun Pasien milik $nama_akun (Username: $username_akun).', NOW())
                    ");

                    $pageBaru = get_user_page($kategori, $email_baru, $per_page);
                    send_json([
                        'success' => true,
                        'msg' => $msg_success_update,
                        'highlight_email' => $email_baru,
                        'highlight_page' => $pageBaru
                    ]);
                }
                send_json(['success' => false, 'msg' => 'Gagal update: '.$err]);

            } else if ($kategori === 'pekerja' || $kategori === 'admin') {
                $role_id = ($kategori === 'admin') ? 1 : 2;
                if ($foto_new !== null) {
                    $res = mysqli_query($koneksi, "SELECT foto FROM akun_pekerja WHERE email='$email_lama' AND role_id=$role_id LIMIT 1");
                    if ($res && mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);
                        $foto_old = $row['foto'] ?? 'default.png';
                        if ($foto_old !== 'default.png' && file_exists($upload_dir.$foto_old)) unlink($upload_dir.$foto_old);
                    }
                }
                $stmt = $koneksi->prepare("UPDATE akun_pekerja SET $setClause WHERE email=? AND role_id=$role_id");
                $params[] = $email_lama;
                $types.='s';
                $stmt->bind_param($types,...$params);
                $exec = $stmt->execute();
                $err = $stmt->error;
                $stmt->close();

                if ($exec) {
                    // Update Session Jika Akun yang diedit sedang login
                    $is_self = false;
                    if ($username_lama !== null && $username_lama === $_SESSION['username']) {
                        $_SESSION['username'] = $username_akun;
                        $_SESSION['nama_lengkap'] = $nama_akun;
                        $_SESSION['email'] = $email_baru;

                        if ($foto_new !== null) {
                            $_SESSION['foto'] = $foto_new;
                        }

                        $is_self = true;
                    }

                    // Format level
                    $level = ucfirst(strtolower($level));

                    // Cek apakah akun milik sendiri
                    $peran = ($kategori === 'admin') ? 'admin' : 'pekerja';
                    if ($is_self) {
                        $detail = "$nama_depan telah mengubah data akun miliknya sendiri (Username: $username_akun).";
                    } else {
                        $detail = "$nama_depan telah mengubah data akun " . ucfirst(strtolower($peran)) . " milik $nama_akun (Username: $username_akun).";
                    }

                    // Log User: Ubah Akun Admin / Pekerja
                    mysqli_query($koneksi, "
                        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                        VALUES ('$username', '$level', 'Ubah Akun', '$detail', NOW())
                    ");

                    $pageBaru = get_user_page($kategori, $email_baru, $per_page);
                    send_json([
                        'success' => true,
                        'msg' => $msg_success_update,
                        'highlight_email' => $email_baru,
                        'highlight_page' => $pageBaru,
                        'updated_self' => $is_self
                    ]);
                }
                send_json(['success' => false, 'msg' => 'Gagal update: '.$err]);

            } else send_json(['success' => false, 'msg' => 'Kategori tidak valid']);
        }

        // ========================== DELETE =============================
        if (isset($_POST['submit_delete_user'])) {
            $email = strtolower(clean($_POST['delete-email'] ?? ''));
            if ($email === '') {
                send_json(['success' => false, 'msg' => 'Email tidak dikirim']);
            }

            // Cegah Hapus Akun Sendiri
            if ($email === $_SESSION['email']) {
                send_json([
                    'success' => false,
                    'msg' => 'Tidak boleh menghapus akun sendiri'
                ]);
            }
            
            $fotoToDelete = 'default.png';

            if ($kategori === 'pasien') {
                $res = mysqli_query($koneksi, "SELECT username, nama, foto FROM akun_pasien WHERE email='$email' LIMIT 1");
                if ($res && mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $username_akun = $row['username'];
                    $nama_akun     = $row['nama'];
                    $fotoToDelete  = $row['foto'] ?? 'default.png';
                }
                $exec = mysqli_query($koneksi, "DELETE FROM akun_pasien WHERE email='$email'");
                if ($exec) {
                    // Format level
                    $level = ucfirst(strtolower($level));
                    
                    // Log User: Hapus Akun Pasien
                    mysqli_query($koneksi, "
                        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                        VALUES ('$username', '$level', 'Hapus Akun', '$nama_depan telah menghapus akun Pasien milik $nama_akun (Username: $username_akun).', NOW())
                    ");

                    if ($fotoToDelete !== 'default.png' && file_exists($upload_dir.$fotoToDelete)) unlink($upload_dir.$fotoToDelete);
                    send_json(['success' => true, 'msg' => $msg_success_delete]);
                }
                send_json(['success' => false, 'msg' => 'Gagal menghapus: '.mysqli_error($koneksi)]);

            } else if ($kategori === 'pekerja' || $kategori === 'admin') {
                $role_id = ($kategori === 'admin') ? 1 : 2;
                $res = mysqli_query($koneksi, "SELECT username, nama, foto FROM akun_pekerja WHERE email='$email' AND role_id=$role_id LIMIT 1");
                if ($res && mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $username_akun = $row['username'];
                    $nama_akun     = $row['nama'];
                    $fotoToDelete  = $row['foto'] ?? 'default.png';
                } else send_json(['success' => false, 'msg' => 'Akun tidak ditemukan untuk kategori ini']);
                $exec = mysqli_query($koneksi, "DELETE FROM akun_pekerja WHERE email='$email' AND role_id=$role_id");

                if ($exec) {
                    // Format level
                    $level = ucfirst(strtolower($level));

                    // Log User: Hapus Akun Admin / Pekerja
                    $peran = ($kategori === 'admin') ? 'admin' : 'pekerja';
                    mysqli_query($koneksi, "
                        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                        VALUES ('$username', '$level', 'Hapus Akun', '$nama_depan telah menghapus akun " . ucfirst(strtolower($peran)) . " milik $nama_akun (Username: $username_akun).', NOW())
                    ");

                    if ($fotoToDelete !== 'default.png' && file_exists($upload_dir.$fotoToDelete)) unlink($upload_dir.$fotoToDelete);
                    send_json(['success' => true, 'msg' => $msg_success_delete]);
                }
                send_json(['success' => false, 'msg' => 'Gagal menghapus: '.mysqli_error($koneksi)]);

            } else send_json(['success' => false, 'msg' => 'Kategori tidak valid']);
        }

        send_json(['success' => false, 'msg' => 'Permintaan POST tidak dikenali']);
    }

    // ========================== DEFAULT ============================
    send_json([
        'users' => [
            'pasien' => ['data' => [], 'total_data' => 0, 'current_page' => 1, 'total_page' => 1],
            'pekerja' => ['data' => [], 'total_data' => 0, 'current_page' => 1, 'total_page' => 1],
            'admin' => ['data' => [], 'total_data' => 0, 'current_page' => 1, 'total_page' => 1]
        ]
    ]);

?>