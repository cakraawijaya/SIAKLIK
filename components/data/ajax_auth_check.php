<?php

    // ===========================================================================================
    // RETURN JSON
    // ===========================================================================================
    // Set response ke format JSON
    header('Content-Type: application/json');


    // ===========================================================================================
    // CEK SESSION
    // ===========================================================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }

    // Daftar key session yang wajib ada
    $requiredSession = ['loggedin', 'email', 'level', 'username', 'nama_lengkap'];

    // Loop untuk mengecek setiap session yang wajib ada
    foreach ($requiredSession as $key) {

        // Jika salah satu session tidak ada atau bernilai kosong, maka session login tidak valid, sehingga :
        if (!isset($_SESSION[$key]) || $_SESSION[$key] === '') {

            // Menghapus semua session
            session_unset(); session_destroy();

            // Mengirimkan status 'auto_timeout'
            echo json_encode(['status'=>'auto_timeout']);
            exit; // Menghentikan eksekusi script
        }
    }


    // ===========================================================================================
    // KONEKSI DATABASE
    // ===========================================================================================
    require_once __DIR__.'/../../config/config.php';


    // ===========================================================================================
    // SIMPAN DATA SESSION KE VARIABEL
    // ===========================================================================================
    $username = $_SESSION['username'];      // Ambil username pengguna dari Session
    $level    = $_SESSION['level'];         // Ambil level pengguna dari Session
    $nama     = $_SESSION['nama_lengkap'];  // Ambil nama lengkap pengguna dari Session
    $email    = $_SESSION['email'];         // Ambil email pengguna dari Session


    // ===========================================================================================
    // HELPER LOG AKTIVITAS
    // ===========================================================================================
    function logAktivitas($koneksi, $username, $role, $aksi, $detail) {

        // Jika username atau role kosong, log tidak dijalankan
        if (!$username || !$role) return;

        // Mencoba untuk memproses :
        try {

            // Insert Statement
            // Digunakan untuk menyimpan data aktivitas ke database
            $stmt = $koneksi->prepare("
                INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");

            // Mengikat 4 parameter (username, role, aksi, dan detail) ke dalam query
            $stmt->bind_param("ssss", $username, $role, $aksi, $detail);

            $stmt->execute();   // Menjalankan query
            $stmt->close();     // Menutup statement

        // Menangkap exception jika terjadi kesalahan pada proses database
        } catch (mysqli_sql_exception $e) {

            // Mencatat detail error ke log server untuk keperluan debugging
            error_log("Database error: " . $e->getMessage());

            // Simpan pesan error ke dalam session
            $_SESSION['error_message'] = $e->getMessage();

            // Kirim response JSON error
            echo json_encode(['status' => 'auto_db_error', 'message' => 'Terjadi kesalahan pada database', 'error'=>$e->getMessage()]);
            exit; // Menghentikan eksekusi script
        }
    }


    // ===========================================================================================
    // CEK TIMEOUT
    // ===========================================================================================
    // Jika ada permintaan logout paksa, maka lakukan beberapa hal, yaitu :
    if (isset($_GET['action']) && $_GET['action'] === 'force_logout') {

        // Mencoba untuk memproses :
        try {

            // Select Statement
            // Digunakan untuk mengecek ketersediaan koneksi database sebelum melanjutkan proses
            $koneksi->query("SELECT 1");

        // Menangkap exception jika terjadi kesalahan pada proses database
        } catch (mysqli_sql_exception $e) {

            // Mencatat detail error ke log server untuk keperluan debugging
            error_log("Database error: " . $e->getMessage());

            // Simpan pesan error ke dalam session
            $_SESSION['error_message'] = $e->getMessage();

            // Kirim response JSON error
            echo json_encode(['status' => 'auto_db_error', 'message' => 'Terjadi kesalahan pada database', 'error'=>$e->getMessage()]);
            exit; // Menghentikan eksekusi script
        }

        // Format level
        $level = ucfirst(strtolower($level));

        // Jika Log User: Timeout belum pernah dicatat sama sekali, maka atur :
        if (!isset($_SESSION['__timeout_logged'])) {

            // Log User: Timeout
            $aksi   = "Timeout";
            $detail = "$nama telah di Logout paksa oleh Sistem.";
            logAktivitas($koneksi, $username, $level, $aksi, $detail);

            // Penanda Log User: Timeout agar hanya dicatat satu kali
            $_SESSION['__timeout_logged'] = true;
        }

        // Menghapus semua session
        session_unset(); session_destroy();

        // Mengirimkan status 'auto_timeout'
        echo json_encode(['status' => 'auto_timeout']);
        exit; // Menghentikan eksekusi script
    }


    // ===========================================================================================
    // CEK JIKA AKUN TELAH DIHAPUS OLEH ADMIN DATABASE
    // ===========================================================================================
    // Menentukan tabel berdasarkan level pengguna
    $table = ($level==='admin' || $level==='pekerja') ? 'akun_pekerja' : 'akun_pasien';

    // Mencoba untuk memproses :
    try {

        // Select Statement
        // Digunakan untuk mengecek apakah akun masih ada di database
        $stmt = $koneksi->prepare("SELECT 1 FROM $table WHERE email = ? LIMIT 1");

        $stmt->bind_param("s", $email);    // Mengikat parameter email ke query
        $stmt->execute();                  // Menjalankan query
        $stmt->store_result();             // Menyimpan hasil query

        // Jika data tidak ada, maka :
        if ($stmt->num_rows === 0) {

            // Format level
            $level = ucfirst(strtolower($level));

            // Log User: Akun Dihapus
            $aksi   = "Akun Diblokir";
            $detail = "Akun a/n. $nama telah diblokir (banned) oleh Admin karena pelanggaran kebijakan.";
            logAktivitas($koneksi, $username, $level, $aksi, $detail);

            // Menghapus semua session
            session_unset(); session_destroy();

            // Mengirimkan status 'auto_deleted'
            echo json_encode(['status' => 'auto_deleted']);
            exit; // Menghentikan eksekusi script
        }

        // Menutup statement
        $stmt->close();

    // Menangkap exception jika terjadi kesalahan pada proses database
    } catch (mysqli_sql_exception $e) {

        // Mencatat detail error ke log server untuk keperluan debugging
        error_log("Database error: " . $e->getMessage());

        // Simpan pesan error ke dalam session
        $_SESSION['error_message'] = $e->getMessage();

        // Kirim response JSON error
        echo json_encode(['status' => 'auto_db_error', 'message' => 'Terjadi kesalahan pada database', 'error'=>$e->getMessage()]);
        exit; // Menghentikan eksekusi script
    }


    // ===========================================================================================
    // RESPONSE STATUS OK
    // ===========================================================================================
    echo json_encode(['status' => 'ok']);   // Mengirimkan status 'ok'
    exit;                                   // Menghentikan eksekusi script

?>
