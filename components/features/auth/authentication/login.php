<?php

    session_start();
    include __DIR__ . '/../../../../config/config.php';

    // Fungsi untuk mendapatkan level string dari role_id
    function getLevel($role_id, $koneksi) {
        $query = mysqli_query($koneksi, "SELECT level FROM hak_akses WHERE id='$role_id'");
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            return $row['level'];
        }
        return 'pasien';
    }

    // ===== LOGIN PASIEN =====
    if (isset($_POST['patient-submit'])) {

        // Ambil id captcha yang digunakan
        $captcha_id = 'login_pasien'; // sesuaikan dengan id di img captcha

        // validasi captcha hanya saat submit
        if (empty($_SESSION["captcha_".$captcha_id]) || strcasecmp($_POST["kode"], $_SESSION["captcha_".$captcha_id]) !== 0) {
            header("location: " . BASE_URL . "index.php?pesan=gagal&modal=pasien");
            exit;
        }

        $email = $_POST['patient-email'];
        $password = $_POST['patient-password'];

        $login = mysqli_query($koneksi, "SELECT * FROM akun_pasien WHERE email='$email'");
        if (mysqli_num_rows($login) === 0) {
            header("location: " . BASE_URL . "index.php?pesan=email_salah&modal=pasien");
            exit;
        }

        $data = mysqli_fetch_assoc($login);
        $level = getLevel($data['role_id'], $koneksi);

        if (password_verify($password, $data['password']) || $password === $data['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['level'] = $level;
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            unset($_SESSION["captcha_".$captcha_id]); // hapus captcha setelah login sukses

            header("location: " . BASE_URL . "index.php?pesan=login_sukses&modal=pasien");
            exit;
        } else {
            header("location: " . BASE_URL . "index.php?pesan=password_salah&modal=pasien");
            exit;
        }
    }

    // ===== LOGIN PEKERJA / ADMIN =====
    else if (isset($_POST['pekerja-submit'])) {

        // Ambil id captcha yang digunakan
        $captcha_id = 'login_pekerja'; // sesuaikan dengan id di img captcha

        // validasi captcha hanya saat submit
        if (empty($_SESSION["captcha_".$captcha_id]) || strcasecmp($_POST["kode"], $_SESSION["captcha_".$captcha_id]) !== 0) {
            header("location: " . BASE_URL . "index.php?pesan=gagal&modal=pekerja_admin");
            exit;
        }

        $email = $_POST['pekerja-email'];
        $password = $_POST['pekerja-password'];

        $login = mysqli_query($koneksi, "SELECT * FROM akun_pekerja WHERE email='$email'");
        if (mysqli_num_rows($login) === 0) {
            header("location: " . BASE_URL . "index.php?pesan=email_salah&modal=pekerja_admin");
            exit;
        }

        $data = mysqli_fetch_assoc($login);
        $level = getLevel($data['role_id'], $koneksi);

        if (password_verify($password, $data['password']) || $password === $data['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['level'] = $level;
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            unset($_SESSION["captcha_".$captcha_id]); // hapus captcha setelah login sukses

            header("location: " . BASE_URL . "index.php?pesan=login_sukses&modal=pekerja_admin");
            exit;
        } else {
            header("location: " . BASE_URL . "index.php?pesan=password_salah&modal=pekerja_admin");
            exit;
        }
    }

?>