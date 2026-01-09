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
    // HANYA CEK LOGIN KALAU $require_login = true
    // ===========================================================
    if (isset($require_login) && $require_login === true) {
        // Jika belum login, tampilkan: modal login pasien
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("location: " . BASE_URL . "index.php?pesan=belum_login&modal=pasien");
            exit;
        }

        // Jika variabel $allowed_levels belum didefinisikan di halaman pemanggil, maka gunakan:
        if (!isset($allowed_levels)) {
            // Default: Semua role (pasien, pekerja, admin) boleh akses
            $allowed_levels = ['pasien', 'pekerja', 'admin'];
        }

        // Tolak akses jika role user tidak memiliki izin ke halaman ini
        if (!in_array($_SESSION['level'], $allowed_levels)) {
            header("location: " . BASE_URL . "index.php?pesan=error");
            exit;
        }
    }


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
    // SET TIMEOUT
    // ===========================================================
    $timeout_duration = 300; // 300 detik = 5 menit


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
                $nama     = $_SESSION['nama_lengkap'];

                // Log User: Timeout
                logAktivitas($koneksi, $username, $level, 'Timeout', "$nama telah di Logout paksa oleh Sistem.");

                // Menghapus semua session
                session_unset(); session_destroy();

                // Mengalihkan ke Beranda, yang disertai dengan notifikasi
                header("Location: " . BASE_URL . "index.php?pesan=timeout");
                exit;
            }
        }
    }


    // ===========================================================
    // CEK JIKA AKUN TELAH DIHAPUS OLEH ADMIN / ADMIN DATABASE
    // ===========================================================
    if (isset($_SESSION['level']) && isset($_SESSION['email'])) {
        // Ambil data dari Session
        $username = $_SESSION['username'];
        $level    = $_SESSION['level'];
        $nama     = $_SESSION['nama_lengkap'];
        $email    = $_SESSION['email'];

        $level_map = [
            'admin'   => ['table' => 'akun_pekerja', 'role_id' => 1],
            'pekerja' => ['table' => 'akun_pekerja', 'role_id' => 2],
            'pasien' => ['table' => 'akun_pasien', 'role_id' => 3],
        ];

        $table = $level_map[$level]['table'];
        $role_id = $level_map[$level]['role_id'];

        $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE email='$email' AND role_id='$role_id' LIMIT 1");

        if (!$query) {
            die("Query error: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($query) === 0) {
            // Log User: Akun Dihapus
            logAktivitas($koneksi, $username, $level, 'Akun Dihapus', "Akun milik $nama telah dihapus oleh Admin.");

            // Menghapus semua session
            session_unset(); session_destroy();

            // Mengalihkan ke Beranda, yang disertai dengan notifikasi
            header("Location: " . BASE_URL . "index.php?pesan=deleted");
            exit;
        }
    }


    // ===========================================================
    // UPDATE LAST ACTIVITY
    // ===========================================================
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $_SESSION['LAST_ACTIVITY'] = time();
    }

?>