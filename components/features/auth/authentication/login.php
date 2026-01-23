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
    // FUNGSI LEVEL STRING (role_id)
    // ===========================================================================================
    function getLevel($role_id, $koneksi) {

        // Query ini digunakan untuk mengambil level dari tabel hak_akses berdasarkan role_id
        $query = mysqli_query($koneksi, "SELECT level FROM hak_akses WHERE id='$role_id'");

        // Jika data ditemukan
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query); // Ambil data hasil query
            return $row['level']; // Kembalikan nilai level
        }

        // Jika tidak ditemukan, default level = pasien
        return 'pasien';
    }


    // ===========================================================================================
    // LOGIN PASIEN
    // ===========================================================================================
    if (isset($_POST['patient-submit'])) {

        // Ambil id captcha yang digunakan
        $captcha_id = 'login_pasien'; // Sesuaikan dengan id di img captcha

        // Validasi captcha hanya saat submit
        if (empty($_SESSION["captcha_".$captcha_id]) || strcasecmp($_POST["kode"], $_SESSION["captcha_".$captcha_id]) !== 0) {

            // Jika captcha salah, maka redirect ke modal login pasien
            // Hal ini disertai dengan pesan = Captcha salah!
            header("location: " . BASE_URL . "index.php?pesan=gagal&modal=pasien");
            exit; // Menghentikan eksekusi script
        }

        // Ambil input email & password dari form
        $email = $_POST['patient-email'];
        $password = $_POST['patient-password'];

        // Query ini digunakan untuk mencari akun pasien berdasarkan email
        $login = mysqli_query($koneksi, "SELECT * FROM akun_pasien WHERE email='$email'");

        // Jika email tidak ditemukan di database, maka :
        if (mysqli_num_rows($login) === 0) {

            // Redirect ke modal login pasien
            // Hal ini disertai dengan pesan = Email tidak ditemukan!
            header("location: " . BASE_URL . "index.php?pesan=email_salah&modal=pasien");
            exit; // Menghentikan eksekusi script
        }

        // Ambil data akun pasien
        $data = mysqli_fetch_assoc($login);

        // Ambil level user berdasarkan role_id
        $level = getLevel($data['role_id'], $koneksi);

        // Validasi password bisa menggunakan password_hash() ataupun password plain lama
        if (password_verify($password, $data['password']) || $password === $data['password']) {

            // Set session login
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['level'] = $level;
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama_lengkap'] = $data['nama'];
            $_SESSION['foto'] = $data['foto'];

            // Hapus captcha dari session setelah login sukses
            unset($_SESSION["captcha_".$captcha_id]);

            // Format level
            $level = ucfirst(strtolower($level));

            // Log User: Login Pasien
            mysqli_query($koneksi, "
                INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                VALUES ('{$data['username']}', '$level', 'Login', '{$data['nama']} telah Login.', NOW())
            ");

            // Jika login sukses, maka redirect ke halaman beranda
            // Hal ini disertai dengan pesan = Anda berhasil login!
            header("location: " . BASE_URL . "index.php?pesan=login_sukses&modal=pasien");
            exit; // Menghentikan eksekusi script

        } else { // Jika password salah, maka :

            // Redirect ke modal login pasien
            // Hal ini disertai dengan pesan = Password salah!
            header("location: " . BASE_URL . "index.php?pesan=password_salah&modal=pasien");
            exit; // Menghentikan eksekusi script
        }
    }


    // ===========================================================================================
    // LOGIN PEKERJA ATAU ADMIN
    // ===========================================================================================
    else if (isset($_POST['pekerja-submit'])) {

        // Ambil id captcha yang digunakan
        $captcha_id = 'login_pekerja'; // Sesuaikan dengan id di img captcha

        // Validasi captcha hanya saat submit
        if (empty($_SESSION["captcha_".$captcha_id]) || strcasecmp($_POST["kode"], $_SESSION["captcha_".$captcha_id]) !== 0) {

            // Jika captcha salah, maka redirect ke modal login pekerja atau admin
            // Hal ini disertai dengan pesan = Captcha salah!
            header("location: " . BASE_URL . "index.php?pesan=gagal&modal=pekerja_admin");
            exit; // Menghentikan eksekusi script
        }

        // Ambil input email & password dari form
        $email = $_POST['pekerja-email'];
        $password = $_POST['pekerja-password'];

        // Query ini digunakan untuk mencari akun pekerja atau admin berdasarkan email
        $login = mysqli_query($koneksi, "SELECT * FROM akun_pekerja WHERE email='$email'");

        // Jika email tidak ditemukan di database, maka :
        if (mysqli_num_rows($login) === 0) {

            // Redirect ke modal login pekerja atau admin
            // Hal ini disertai dengan pesan = Email tidak ditemukan!
            header("location: " . BASE_URL . "index.php?pesan=email_salah&modal=pekerja_admin");
            exit; // Menghentikan eksekusi script
        }

        // Ambil data akun pekerja atau admin
        $data = mysqli_fetch_assoc($login);

        // Ambil level user berdasarkan role_id
        $level = getLevel($data['role_id'], $koneksi);

        // Validasi password bisa menggunakan password_hash() ataupun password plain lama
        if (password_verify($password, $data['password']) || $password === $data['password']) {

            // Set session login
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['level'] = $level;
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama_lengkap'] = $data['nama'];
            $_SESSION['foto'] = $data['foto'];

            // Hapus captcha dari session setelah login sukses
            unset($_SESSION["captcha_".$captcha_id]);

            // Format level
            $level = ucfirst(strtolower($level));

            // Log User: Login Pekerja atau Admin
            mysqli_query($koneksi, "
                INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
                VALUES ('{$data['username']}', '$level', 'Login', '{$data['nama']} telah Login.', NOW())
            ");

            // Jika login sukses, maka redirect ke halaman beranda
            // Hal ini disertai dengan pesan = Anda berhasil login!
            header("location: " . BASE_URL . "index.php?pesan=login_sukses&modal=pekerja_admin");
            exit; // Menghentikan eksekusi script

        } else { // Jika password salah, maka :

            // Redirect ke modal login pekerja atau admin
            // Hal ini disertai dengan pesan = Password salah!
            header("location: " . BASE_URL . "index.php?pesan=password_salah&modal=pekerja_admin");
            exit; // Menghentikan eksekusi script
        }
    }

?>