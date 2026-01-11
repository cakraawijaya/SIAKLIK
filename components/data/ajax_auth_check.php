<?php
    
    // mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // jika session belum aktif, maka mulai session baru
    }

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__.'/../../config/config.php';

    // Return JSON
    header('Content-Type: application/json');

    
    // ========================== SESSION ============================
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ||
        !isset($_SESSION['email']) || !isset($_SESSION['level'])) {
            session_unset();
            session_destroy();
            echo json_encode(['status'=>'auto_timeout']);
            exit;
    }

    $username = $_SESSION['username'];
    $level    = $_SESSION['level'];
    $nama     = $_SESSION['nama_lengkap'];
    $email    = $_SESSION['email'];


    // =========================== TIMEOUT ===========================
    if (isset($_GET['action']) && $_GET['action'] === 'force_logout') {
        // Format level
        $level = ucfirst(strtolower($level));

        // Log User: Timeout
        if (!isset($_SESSION['__timeout_logged'])) {
            mysqli_query($koneksi, "
                INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                VALUES ('$username', '$level', 'Timeout', '$nama telah di Logout paksa oleh Sistem.', NOW())
            ");
            $_SESSION['__timeout_logged'] = true;
        }
        session_unset(); session_destroy();
        echo json_encode(['status' => 'auto_timeout']); exit;
    }

    // Cek session valid atau tidak
    if (!isset($_SESSION['email']) || !isset($_SESSION['level']) || !isset($_SESSION['loggedin']) || $_SESSION['loggedin']!==true) {
        session_unset(); session_destroy();
        echo json_encode(['status' => 'auto_timeout']); exit;
    }



    // ======================= DELETED ACCOUNT =======================

    // Tentukan tabel berdasarkan level
    if ($level === 'admin' || $level === 'pekerja') {
        $table = 'akun_pekerja';
    } else {
        $table = 'akun_pasien';
    }

    // Cek apakah akun masih ada
    $query = mysqli_query($koneksi, "SELECT 1 FROM $table WHERE email='$email' LIMIT 1");

    // Jika data tidak ada maka hapus Session loggedin (akun dikeluarkan secara paksa)
    if (mysqli_num_rows($query) === 0) {
        // Format level
        $level = ucfirst(strtolower($level));
        
        // Log User: Akun Dihapus
        mysqli_query($koneksi, "
            INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
            VALUES ('$username', '$level', 'Akun Diblokir', 'Akun a/n. $nama telah diblokir (banned) oleh Admin karena pelanggaran kebijakan.', NOW())
        ");
        session_unset(); session_destroy();
        echo json_encode(['status' => 'auto_deleted']); exit;
    }


    // ===================== UPDATE LAST ACTIVITY ====================
    $_SESSION['LAST_ACTIVITY'] = time();
    echo json_encode(['status' => 'ok']);
    exit;

?>