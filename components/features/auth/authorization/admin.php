<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Atur Timeout menjadi 300 detik = 5 menit
    $timeout_duration = 300;

    // --- CEK TIMEOUT ---
    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];
        if ($elapsed_time > $timeout_duration) {
            session_unset();
            session_destroy();
            header("Location: " . BASE_URL . "index.php?pesan=timeout");
            exit;
        }
    }

    // Update aktivitas terakhir jika login
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    /*
    ------------------------------------------------
    Hanya cek login kalau $require_login = true
    ------------------------------------------------
    */

    if (isset($require_login) && $require_login === true) {

        // ✅ Jika belum login → munculkan modal login pekerja/admin
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("location: " . BASE_URL . "index.php?pesan=akses_terbatas&modal=pekerja_admin");
            exit;
        }

        // ✅ Hanya admin yang boleh akses
        $allowed_levels = ['admin'];
        if (!in_array($_SESSION['level'], $allowed_levels)) {
            header("location: " . BASE_URL . "index.php?pesan=error");
            exit;
        }
    }

    // ===========================================================
    // CEK JIKA AKUN TELAH DIHAPUS OLEH ADMIN DATABASE
    // ===========================================================
    if (isset($_SESSION['level']) && isset($_SESSION['email'])) {
        include __DIR__ . '/../../../../config/config.php';

        $email = $_SESSION['email'];
        $level = $_SESSION['level'];

        $level_map = ['admin' => ['table' => 'akun_pekerja', 'role_id' => 1]];
        $table = $level_map[$level]['table'];
        $role_id = $level_map[$level]['role_id'];

        $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE email='$email' AND role_id='$role_id' LIMIT 1");

        if (!$query) {
            die("Query error: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($query) === 0) {
            session_unset(); session_destroy();
            header("Location: " . BASE_URL . "index.php?pesan=deleted");
            exit;
        }
    }

?>