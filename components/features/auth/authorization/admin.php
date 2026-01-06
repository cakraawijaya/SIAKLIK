<?php

    // ===========================================================
    // CEK SESSION
    // ===========================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }


    // ===========================================================
    // KONEKSI
    // ===========================================================
    include __DIR__ . '/../../../../config/config.php';


    // ===========================================================
    // SET TIMEOUT
    // ===========================================================
    $timeout_duration = 300; // 300 detik = 5 menit


    // ===========================================================
    // HELPER LOG AKTIVITAS
    // ===========================================================
    function logAktivitas($koneksi, $username, $role, $aksi, $detail) {
        if (!$username || !$role) return;

        mysqli_query($koneksi, "
            INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
            VALUES ('$username', '$role', '$aksi', '$detail', NOW())
        ");
    }


    // ===========================================================
    // HANYA CEK LOGIN KALAU $require_login = true
    // ===========================================================
    if (isset($require_login) && $require_login === true) {
        // Jika belum login, tampilkan: modal login pekerja/admin
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("location: " . BASE_URL . "index.php?pesan=akses_terbatas&modal=pekerja_admin");
            exit;
        }

        // Hanya admin yang boleh akses
        $allowed_levels = ['admin'];
        if (!in_array($_SESSION['level'], $allowed_levels)) {
            header("location: " . BASE_URL . "index.php?pesan=error");
            exit;
        }
    }


    // ===========================================================
    // CEK TIMEOUT
    // ===========================================================
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        if (isset($_SESSION['LAST_ACTIVITY'])) {
            $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];
            
            if ($elapsed_time > $timeout_duration) {
                // Ambil data dari Session
                $username = $_SESSION['username'];
                $level    = $_SESSION['level'];
                $nama     = $_SESSION['nama'];

                // Log User: Timeout
                logAktivitas($koneksi, $username, $level, 'Timeout', "$nama telah di Logout paksa oleh Sistem");

                // Menghapus semua session
                session_unset(); session_destroy();

                // Mengalihkan ke Beranda, yang disertai dengan notifikasi
                header("Location: " . BASE_URL . "index.php?pesan=timeout");
                exit;
            }
        }
    }


    // ===========================================================
    // UPDATE LAST ACTIVITY
    // ===========================================================
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $_SESSION['LAST_ACTIVITY'] = time();
    }


    // ===========================================================
    // CEK JIKA AKUN TELAH DIHAPUS OLEH ADMIN DATABASE
    // ===========================================================
    if (isset($_SESSION['level']) && isset($_SESSION['email'])) {
        // Ambil data dari Session
        $username = $_SESSION['username'];
        $level    = $_SESSION['level'];
        $nama     = $_SESSION['nama'];
        $email    = $_SESSION['email'];

        $level_map = ['admin' => ['table' => 'akun_pekerja', 'role_id' => 1]];
        $table = $level_map[$level]['table'];
        $role_id = $level_map[$level]['role_id'];

        $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE email='$email' AND role_id='$role_id' LIMIT 1");

        if (!$query) {
            die("Query error: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($query) === 0) {
            // Log User: Akun Dihapus
            logAktivitas($koneksi, $username, $level, 'Akun Dihapus', "Akun a/n. $nama telah Dihapus, karena dianggap melanggar ketentuan Poliklinik");

            // Menghapus semua session
            session_unset(); session_destroy();

            // Mengalihkan ke Beranda, yang disertai dengan notifikasi
            header("Location: " . BASE_URL . "index.php?pesan=deleted");
            exit;
        }
    }

?>