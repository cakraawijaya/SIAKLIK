<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include __DIR__.'/../../config/config.php';
    
    header('Content-Type: application/json');

    // Force logout via idle auto timeout
    if (isset($_GET['action']) && $_GET['action'] === 'force_logout') {
        if(session_status() === PHP_SESSION_ACTIVE) {
            session_unset(); session_destroy();
        }
        echo json_encode(['status'=>'auto_timeout']); exit;
    }

    // Cek session valid atau tidak
    if (!isset($_SESSION['email']) || !isset($_SESSION['level']) || !isset($_SESSION['loggedin']) || $_SESSION['loggedin']!==true) {
        session_unset(); session_destroy();
        echo json_encode(['status'=>'auto_timeout']); exit;
    }

    $email = $_SESSION['email'];
    $level = $_SESSION['level'];

    // Tentukan tabel berdasarkan level
    if ($level === 'admin' || $level === 'pekerja') {
        $table = 'akun_pekerja';
    } else {
        $table = 'akun_pasien';
    }

    // Cek apakah akun masih ada
    $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE email='$email' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        session_unset(); session_destroy();
        echo json_encode(['status' => 'auto_deleted']); exit;
    }

    // Update last activity
    $_SESSION['LAST_ACTIVITY'] = time();
    echo json_encode(['status'=>'ok']);
    exit;

?>