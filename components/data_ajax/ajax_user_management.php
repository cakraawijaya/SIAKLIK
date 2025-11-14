<?php
// ======================== CONFIG & AUTH ========================
$require_login = true;
include __DIR__ . '/../features/admin_auth_check.php';
include __DIR__ . '/../../config/config.php';

$per_page = 3;
$upload_dir = __DIR__ . '/../../public/assets/img/user_photo/';
$max_file_size = 2 * 1024 * 1024; // 2MB
$allowed_ext = ['jpg','jpeg','png','gif'];

// ======================== HELPERS ========================
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
    if ($f['size'] > $max_file_size) return ['error'=>'Ukuran file foto terlalu besar'];

    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) return ['error'=>'Ekstensi file tidak diperbolehkan'];

    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    $target = uniqid('user_') . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], $upload_dir . $target)) return ['error'=>'Gagal menyimpan file'];

    return ['file'=>$target];
}

// ======================== CAPTCHA ========================
function verify_captcha($kode, $captcha_id) {
    $session_key = 'captcha_' . $captcha_id;
    if (!isset($_SESSION[$session_key])) return false;
    $valid = strtolower(trim($kode)) === strtolower($_SESSION[$session_key]);
    unset($_SESSION[$session_key]); // captcha sekali pakai
    return $valid;
}

// ======================== PAGINATE & SORT NATURAL ========================
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
    } else return ['data'=>[], 'total_page'=>1, 'current_page'=>1, 'total_data'=>0];

    // Hitung total data
    $cnt_sql = "SELECT COUNT(*) AS cnt FROM $table " . str_replace("WHERE", "WHERE", $where_clause);
    $cnt_q = mysqli_query($koneksi, $cnt_sql);
    $cnt_row = mysqli_fetch_assoc($cnt_q);
    $total_data = (int)$cnt_row['cnt'];

    // Query data dengan natural sort
    $sql = "SELECT email, foto, username, nama FROM $table
            $where_clause
            ORDER BY 
              CAST(REGEXP_SUBSTR(username,'[0-9]+$') AS UNSIGNED) ASC,
              username ASC
            LIMIT $per_page OFFSET $offset";

    $rows = [];
    $q = mysqli_query($koneksi, $sql);
    while($r = mysqli_fetch_assoc($q)) {
        $r['foto'] = (!isset($r['foto']) || $r['foto']==='' || !file_exists($upload_dir . $r['foto'])) ? 'default.png' : $r['foto'];
        $rows[] = $r;
    }

    $total_page = $per_page>0 ? ceil($total_data / $per_page) : 1;
    return ['data' => $rows, 'total_page' => $total_page, 'current_page' => $page, 'total_data' => $total_data];
}

// ======================== GET PAGE UNTUK HIGHLIGHT ========================
function get_user_page($kategori, $username, $per_page = 3) {
    global $koneksi;

    $username = mysqli_real_escape_string($koneksi, $username);

    if ($kategori==='pasien') {
        $table = "akun_pasien";
        $where = "WHERE 1=1";
    } else if ($kategori==='pekerja' || $kategori==='admin') {
        $role_id = ($kategori==='admin') ? 1 : 2;
        $table = "akun_pekerja";
        $where = "WHERE role_id=$role_id";
    } else {
        return 1;
    }

    // ================= NATURAL SORT =================
    $rank_sql = "
        SELECT COUNT(*) AS rank
        FROM $table
        $where
        AND (
            CAST(REGEXP_SUBSTR(username,'[0-9]+$') AS UNSIGNED) < CAST(REGEXP_SUBSTR('$username','[0-9]+$') AS UNSIGNED)
            OR (CAST(REGEXP_SUBSTR(username,'[0-9]+$') AS UNSIGNED) = CAST(REGEXP_SUBSTR('$username','[0-9]+$') AS UNSIGNED)
                AND username <= '$username')
        )
    ";
    $res = mysqli_query($koneksi, $rank_sql);
    $count = 0;
    if ($res && $row = mysqli_fetch_assoc($res)) $count = (int)$row['rank'];

    return $per_page>0 ? ceil($count / $per_page) : 1;
}

// ======================== READ ========================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = $_GET['search'] ?? '';
    $users = [
        'pasien' => get_paginated_users('pasien', $per_page, 'link_pasien', $search),
        'pekerja' => get_paginated_users('pekerja', $per_page, 'link_pekerja', $search),
        'admin' => get_paginated_users('admin', $per_page, 'link_admin', $search),
    ];
    send_json(['users' => $users]);
}

// ======================== POST CRUD ========================
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
        send_json(['success'=>false,'msg'=>'Kode captcha salah']);
    }

    // ====================== Role Name untuk Alert ======================
    if ($kategori === 'pasien') $role_name = 'pasien';
    else if ($kategori === 'pekerja') $role_name = 'pekerja';
    else if ($kategori === 'admin') $role_name = 'admin';
    else $role_name = 'pengguna';

    $msg_success_add = "Akun $role_name berhasil ditambahkan";
    $msg_success_update = "Akun $role_name berhasil diperbarui";
    $msg_success_delete = "Akun $role_name berhasil dihapus";

    // ======================== CREATE ========================
    if (isset($_POST['submit_add_user'])) {
        $raw_username = $_POST['add-username'] ?? '';
        $username = strtolower(preg_replace('/[^a-z0-9]/i','',$raw_username));
        $raw_name = $_POST['add-name'] ?? '';
        $nama = ucwords(strtolower(trim($raw_name)));
        $email = strtolower(clean($_POST['add-email'] ?? ''));
        $raw_password = $_POST['add-password'] ?? '';
        $raw_password_confirm = $_POST['add-confirm-password'] ?? '';

        if ($username==='' || $nama==='' || $email==='' || $raw_password==='') {
            send_json(['success'=>false,'msg'=>'Field wajib belum lengkap']);
        }
        
        // ======================== VALIDASI PASSWORD ========================
        if (strlen($raw_password) < 8) {
            send_json([
                'success' => false,
                'msg' => 'Password harus minimal 8 karakter'
            ]);
        }
        if ($raw_password !== $raw_password_confirm) {
            send_json(['success'=>false,'msg'=>'Password dan Konfirmasi Password tidak sama']);
        }
        if (!preg_match('/[^A-Za-z0-9]/', $raw_password)) {
            send_json([
                'success' => false,
                'msg' => 'Password harus mengandung minimal 1 karakter khusus (!@#$%^&* dll)'
            ]);
        }

        // ===================== CEK DUPLIKAT =====================
        // Cek Email di Kedua Tabel
        $checkEmail = mysqli_query($koneksi, "
            SELECT email FROM akun_pasien WHERE email='$email' UNION
            SELECT email FROM akun_pekerja WHERE email='$email' LIMIT 1
        ");

        if (mysqli_num_rows($checkEmail) > 0) {
            send_json(['success'=>false,'msg'=>'Email yang diisikan sudah terpakai di akun lain']);
        }

        // Cek Username di Kedua Tabel
        $checkUsername = mysqli_query($koneksi, "
            SELECT username FROM akun_pasien WHERE username='$username' UNION
            SELECT username FROM akun_pekerja WHERE username='$username' LIMIT 1
        ");

        if (mysqli_num_rows($checkUsername) > 0) {
            send_json(['success'=>false,'msg'=>'Username yang diisikan sudah terpakai di akun lain']);
        }

        // Upload foto
        $foto = 'default.png';
        $uploadRes = handle_upload('add-foto');
        if ($uploadRes && isset($uploadRes['error'])) send_json(['success'=>false,'msg'=>$uploadRes['error']]);
        if ($uploadRes && isset($uploadRes['file'])) $foto = $uploadRes['file'];

        $pwd_hash = password_hash($raw_password, PASSWORD_DEFAULT);

        if ($kategori==='pasien') {
            $stmt = $koneksi->prepare("INSERT INTO akun_pasien (email,foto,username,nama,password,role_id) VALUES (?,?,?,?,?,?)");
            $roleid_pasien=3;
            $stmt->bind_param("sssssi",$email,$foto,$username,$nama,$pwd_hash,$roleid_pasien);
            $exec=$stmt->execute(); $err=$stmt->error; $stmt->close();
            if ($exec) {
                $pageBaru = get_user_page($kategori, $username, $per_page);
                send_json(['success'=>true,'msg'=>$msg_success_add,'highlight_username'=>$username,'highlight_page'=>$pageBaru]);
            }
            send_json(['success'=>false,'msg'=>'Gagal menyimpan: '.$err]);
        } else {
            $role_id = ($kategori==='admin') ? 1 : 2;
            $stmt = $koneksi->prepare("INSERT INTO akun_pekerja (email,foto,username,nama,password,role_id) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("sssssi",$email,$foto,$username,$nama,$pwd_hash,$role_id);
            $exec=$stmt->execute(); $err=$stmt->error; $stmt->close();
            if ($exec) {
                $pageBaru = get_user_page($kategori, $username, $per_page);
                send_json(['success'=>true,'msg'=>$msg_success_add,'highlight_username'=>$username,'highlight_page'=>$pageBaru]);
            }
            send_json(['success'=>false,'msg'=>'Gagal menyimpan: '.$err]);
        }
    }

    // ======================== UPDATE ========================
    if (isset($_POST['submit_edit_user'])) {
        $email_lama = clean($_POST['edit-email-lama'] ?? '');
        $email_baru = strtolower(clean($_POST['edit-email'] ?? ''));
        $raw_username = $_POST['edit-username'] ?? '';
        $username = strtolower(preg_replace('/[^a-z0-9]/i','',$raw_username));
        $raw_name = $_POST['edit-name'] ?? '';
        $nama = ucwords(strtolower(trim($raw_name)));
        $raw_password = $_POST['edit-password'] ?? '';
        $raw_password_confirm = $_POST['edit-confirm-password'] ?? '';

        if ($email_lama==='' || $email_baru==='' || $username==='' || $nama==='') {
            send_json(['success'=>false,'msg'=>'Field wajib belum lengkap']);
        }

        // ===================== CEK DUPLIKAT =====================
        $checkEmail = mysqli_query($koneksi, "
            SELECT email FROM akun_pasien WHERE email='$email_baru' AND email<>'$email_lama' UNION 
            SELECT email FROM akun_pekerja WHERE email='$email_baru' AND email<>'$email_lama' LIMIT 1
        ");
        if (mysqli_num_rows($checkEmail) > 0) {
            send_json(['success'=>false,'msg'=>'Email yang diisikan sudah terpakai di akun lain']);
        }

        $checkUsername = mysqli_query($koneksi, "
            SELECT username FROM akun_pasien WHERE username='$username' AND email<>'$email_lama' UNION 
            SELECT username FROM akun_pekerja WHERE username='$username' AND email<>'$email_lama' LIMIT 1
        ");
        if (mysqli_num_rows($checkUsername) > 0) {
            send_json(['success'=>false,'msg'=>'Username yang diisikan sudah terpakai di akun lain']);
        }

        // ======================== VALIDASI PASSWORD ========================
        $pwd_hash = null; // default: tidak diubah
        if ($raw_password !== '') {
            // Ambil password lama dari database
            if ($kategori==='pasien') {
                $res=mysqli_query($koneksi,"SELECT password FROM akun_pasien WHERE email='$email_lama' LIMIT 1");
            } else {
                $role_id = ($kategori==='admin') ? 1 : 2;
                $res=mysqli_query($koneksi,"SELECT password FROM akun_pekerja WHERE email='$email_lama' AND role_id=$role_id LIMIT 1");
            }
            $pwd_lama = '';
            if ($res && $row=mysqli_fetch_assoc($res)) {
                $pwd_lama = $row['password'];
            }

            // Cek apakah password baru sama dengan password lama
            if (password_verify($raw_password, $pwd_lama)) {
                send_json([
                    'success'=>false,
                    'msg'=>'Password baru tidak boleh sama dengan password lama'
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
                send_json(['success'=>false,'msg'=>'Password dan Konfirmasi Password tidak sama']);
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

        // ======================== UPLOAD FOTO ========================
        $foto_new = null;
        $uploadRes = handle_upload('edit-foto');
        if ($uploadRes && isset($uploadRes['error'])) send_json(['success'=>false,'msg'=>$uploadRes['error']]);
        if ($uploadRes && isset($uploadRes['file'])) $foto_new = $uploadRes['file'];

        // ======================== BUILD UPDATE ========================
        $updateParts=[]; $params=[]; $types='';
        $updateParts[]="email=?"; $params[]=$email_baru; $types.='s';
        $updateParts[]="username=?"; $params[]=$username; $types.='s';
        $updateParts[]="nama=?"; $params[]=$nama; $types.='s';
        if ($pwd_hash !== null) { 
            $updateParts[]="password=?"; $params[]=$pwd_hash; $types.='s'; 
        }
        if ($foto_new!==null) { 
            $updateParts[]="foto=?"; 
            $params[]=$foto_new; 
            $types.='s'; 
        }

        $setClause = implode(', ', $updateParts);

        // ======================== QUERY UPDATE ========================
        if ($kategori==='pasien') {
            if ($foto_new!==null) {
                $res=mysqli_query($koneksi,"SELECT foto FROM akun_pasien WHERE email='$email_lama' LIMIT 1");
                if ($res && mysqli_num_rows($res)>0) {
                    $row=mysqli_fetch_assoc($res);
                    $foto_old=$row['foto'] ?? 'default.png';
                    if ($foto_old!=='default.png' && file_exists($upload_dir.$foto_old)) unlink($upload_dir.$foto_old);
                }
            }
            $stmt=$koneksi->prepare("UPDATE akun_pasien SET $setClause WHERE email=?");
            $params[]=$email_lama; $types.='s';
            $stmt->bind_param($types,...$params);
            $exec=$stmt->execute(); $err=$stmt->error; $stmt->close();
            if ($exec) {
                $pageBaru = get_user_page($kategori, $username, $per_page);
                send_json(['success'=>true,'msg'=>$msg_success_update,'highlight_username'=>$username,'highlight_page'=>$pageBaru]);
            }
            send_json(['success'=>false,'msg'=>'Gagal update: '.$err]);
        } else if ($kategori==='pekerja' || $kategori==='admin') {
            $role_id = ($kategori==='admin') ? 1 : 2;
            if ($foto_new!==null) {
                $res=mysqli_query($koneksi,"SELECT foto FROM akun_pekerja WHERE email='$email_lama' AND role_id=$role_id LIMIT 1");
                if ($res && mysqli_num_rows($res)>0) {
                    $row=mysqli_fetch_assoc($res);
                    $foto_old=$row['foto'] ?? 'default.png';
                    if ($foto_old!=='default.png' && file_exists($upload_dir.$foto_old)) unlink($upload_dir.$foto_old);
                }
            }
            $stmt=$koneksi->prepare("UPDATE akun_pekerja SET $setClause WHERE email=? AND role_id=$role_id");
            $params[]=$email_lama; $types.='s';
            $stmt->bind_param($types,...$params);
            $exec=$stmt->execute(); $err=$stmt->error; $stmt->close();
            if ($exec) {
                $pageBaru = get_user_page($kategori, $username, $per_page);
                send_json(['success'=>true,'msg'=>$msg_success_update,'highlight_username'=>$username,'highlight_page'=>$pageBaru]);
            }
            send_json(['success'=>false,'msg'=>'Gagal update: '.$err]);
        } else send_json(['success'=>false,'msg'=>'Kategori tidak valid']);
    }

    // ======================== DELETE ========================
    if (isset($_POST['submit_delete_user'])) {
        $email = strtolower(clean($_POST['delete-email'] ?? ''));
        if ($email==='') send_json(['success'=>false,'msg'=>'Email tidak dikirim']);
        $fotoToDelete='default.png';

        if ($kategori==='pasien') {
            $res=mysqli_query($koneksi,"SELECT foto FROM akun_pasien WHERE email='$email' LIMIT 1");
            if ($res && mysqli_num_rows($res)>0) {
                $row=mysqli_fetch_assoc($res);
                $fotoToDelete = $row['foto'] ?? 'default.png';
            }
            $exec=mysqli_query($koneksi,"DELETE FROM akun_pasien WHERE email='$email'");
            if ($exec) { 
                if ($fotoToDelete!=='default.png' && file_exists($upload_dir.$fotoToDelete)) unlink($upload_dir.$fotoToDelete);
                send_json(['success'=>true,'msg'=>$msg_success_delete]);
            }
            send_json(['success'=>false,'msg'=>'Gagal menghapus: '.mysqli_error($koneksi)]);
        } else if ($kategori==='pekerja' || $kategori==='admin') {
            $role_id=($kategori==='admin')?1:2;
            $res=mysqli_query($koneksi,"SELECT foto FROM akun_pekerja WHERE email='$email' AND role_id=$role_id LIMIT 1");
            if ($res && mysqli_num_rows($res)>0) {
                $row=mysqli_fetch_assoc($res);
                $fotoToDelete = $row['foto'] ?? 'default.png';
            } else send_json(['success'=>false,'msg'=>'Akun tidak ditemukan untuk kategori ini']);
            $exec=mysqli_query($koneksi,"DELETE FROM akun_pekerja WHERE email='$email' AND role_id=$role_id");
            if ($exec) { 
                if ($fotoToDelete!=='default.png' && file_exists($upload_dir.$fotoToDelete)) unlink($upload_dir.$fotoToDelete);
                send_json(['success'=>true,'msg'=>$msg_success_delete]);
            }
            send_json(['success'=>false,'msg'=>'Gagal menghapus: '.mysqli_error($koneksi)]);
        } else send_json(['success'=>false,'msg'=>'Kategori tidak valid']);
    }

    send_json(['success'=>false,'msg'=>'Permintaan POST tidak dikenali']);
}

// ======================== DEFAULT ========================
send_json([
    'users'=>[
        'pasien'=>['data'=>[], 'total_data'=>0, 'current_page'=>1, 'total_page'=>1],
        'pekerja'=>['data'=>[], 'total_data'=>0, 'current_page'=>1, 'total_page'=>1],
        'admin'=>['data'=>[], 'total_data'=>0, 'current_page'=>1, 'total_page'=>1]
    ]
]);