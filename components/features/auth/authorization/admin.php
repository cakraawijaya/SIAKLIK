<?php

    // ===========================================================================================
    // CEK SESSION
    // ===========================================================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }


    // ===========================================================================================
    // KONEKSI & AKSES BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/../../../../config/config.php';


    // ===========================================================================================
    // HANYA CEK LOGIN KALAU $require_login = true
    // ===========================================================================================
    if (isset($require_login) && $require_login === true) {

        // Jika belum login, maka :
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

            // Redirect ke modal login pekerja atau admin
            // Hal ini disertai dengan pesan = Hak akses terbatas!
            header("location: " . BASE_URL . "index.php?pesan=akses_terbatas&modal=pekerja_admin");
            exit; // Menghentikan eksekusi script
        }

        // Jika variabel $allowed_levels belum didefinisikan di halaman pemanggil, maka gunakan :
        if (!isset($allowed_levels)) {

            // Default: Hanya admin yang boleh akses
            $allowed_levels = ['admin'];
        }

        // Jika role user tidak memiliki izin ke halaman ini, maka :
        if (!in_array($_SESSION['level'], $allowed_levels)) {

            // Redirect ke modal login pekerja atau admin
            // Hal ini disertai dengan pesan = Akses ditolak!
            header("location: " . BASE_URL . "index.php?pesan=error&modal=pekerja_admin");
            exit; // Menghentikan eksekusi script
        }
    }


    // ===========================================================================================
    // HELPER LOG AKTIVITAS
    // ===========================================================================================
    function logAktivitas($koneksi, $username, $role, $aksi, $detail) {

        // Jika username atau role kosong, log tidak dijalankan
        if (!$username || !$role) return;

        // Simpan data aktivitas ke database
        mysqli_query($koneksi, "
            INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
            VALUES ('$username', '$role', '$aksi', '$detail', NOW())
        ");
    }


    // ===========================================================================================
    // SET TIMEOUT
    // ===========================================================================================
    $timeout_duration = 300; // 300 detik = 5 menit


    // ===========================================================================================
    // CEK TIMEOUT
    // ===========================================================================================
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

        // Jika belum ada LAST_ACTIVITY (artinya ini adalah aktivitas pertama user), maka :
        if (!isset($_SESSION['LAST_ACTIVITY'])) {

            // Simpan waktu aktivitas pertama ke dalam session
            $_SESSION['LAST_ACTIVITY'] = time();

        } else { // Diluar hal itu, maka lakukan beberapa hal sebagai berikut :

            // Hitung lama waktu user tidak melakukan aktivitas (dalam detik)
            // Waktu sekarang dikurangi waktu aktivitas terakhir
            $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];

            // Jika waktu tidak aktif melebihi batas timeout, maka :
            if ($elapsed_time > $timeout_duration) {

                // Ambil data dari Session
                $username = $_SESSION['username'];
                $level    = $_SESSION['level'];
                $nama     = $_SESSION['nama_lengkap'];

                // Format level
                $level = ucfirst(strtolower($level));

                // Log User: Timeout
                logAktivitas($koneksi, $username, $level, 'Timeout', "$nama telah di Logout paksa oleh Sistem.");

                // Menghapus semua session
                session_unset(); session_destroy();

                // Redirect ke halaman beranda
                // Hal ini disertai dengan pesan = Waktu Sesi Habis!
                header("Location: " . BASE_URL . "index.php?pesan=timeout");
                exit; // Menghentikan eksekusi script
            }
        }

        // Perbarui waktu aktivitas terakhir
        // Dilakukan setelah user lolos dari pengecekan timeout
        $_SESSION['LAST_ACTIVITY'] = time();
    }


    // ===========================================================================================
    // CEK JIKA AKUN TELAH DIHAPUS OLEH ADMIN DATABASE
    // ===========================================================================================
    if (isset($_SESSION['level']) && isset($_SESSION['email'])) {

        // Ambil data dari Session
        $username = $_SESSION['username'];
        $level    = $_SESSION['level'];
        $nama     = $_SESSION['nama_lengkap'];
        $email    = $_SESSION['email'];

        // Mapping level ke tabel dan role_id
        $level_map = [
            'admin' => ['table' => 'akun_pekerja', 'role_id' => 1]
        ];
        $table = $level_map[$level]['table'];
        $role_id = $level_map[$level]['role_id'];

        // Query ini digunakan untuk mengecek apakah akun masih ada di database
        $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE email='$email' AND role_id='$role_id' LIMIT 1");

        // Jika query error, maka :
        if (!$query) {

            // Hentikan eksekusi dan tampilkan error jika query database gagal (untuk debugging)
            die("Query error: " . mysqli_error($koneksi));
        }

        // Jika akun tidak ditemukan (artinya sudah dihapus atau diblokir), maka lakukan :
        if (mysqli_num_rows($query) === 0) {

            // Format level
            $level = ucfirst(strtolower($level));

            // Log User: Akun Dihapus
            logAktivitas($koneksi, $username, $level, 'Akun Diblokir', "Akun a/n. $nama telah diblokir (banned) oleh Admin karena pelanggaran kebijakan.");

            // Menghapus semua session
            session_unset(); session_destroy();

            // Redirect ke halaman beranda
            // Hal ini disertai dengan pesan = Akun Anda Dihapus!
            header("Location: " . BASE_URL . "index.php?pesan=deleted");
            exit; // Menghentikan eksekusi script
        }
    }

?>