<?php

    session_start();
    require_once __DIR__ . '/../../../../config/config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Aman dari SQL Injection
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);
        $token = $_POST['token'];
        $password = $_POST['reset-password'];
        $password_confirm = $_POST['reset-confirm-password'];

        // ---------------------------------------------
        // CEK TOKEN
        // ---------------------------------------------
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM password_resets WHERE email = ? AND token = ?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $token);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) === 0) {
            header("Location: " . BASE_URL . "index.php?pesan=token_invalid&modal=reset_password");
            exit;
        }

        // ---------------------------------------------
        // VALIDASI PASSWORD
        // ---------------------------------------------
        if ($password !== $password_confirm) {
            header("Location: " . BASE_URL . "index.php?pesan=password_tidak_sesuai&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit;
        }

        if (strlen($password) < 8) {
            header("Location: " . BASE_URL . "index.php?pesan=password_singkat&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit;
        }

        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            header("Location: " . BASE_URL . "index.php?pesan=password_lemah&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit;
        }

        // ---------------------------------------------
        // CEK PASSWORD LAMA
        // ---------------------------------------------
        $stmt2 = mysqli_prepare($koneksi, "SELECT password FROM akun_pasien WHERE email = ?");
        mysqli_stmt_bind_param($stmt2, "s", $email);
        mysqli_stmt_execute($stmt2);
        $cek_user = mysqli_stmt_get_result($stmt2);

        if (mysqli_num_rows($cek_user) > 0) {
            $data_user = mysqli_fetch_assoc($cek_user);

            if (password_verify($password, $data_user['password'])) {
                header("Location: " . BASE_URL . "index.php?pesan=password_sudah_ada&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
                exit;
            }
        }

        // ---------------------------------------------
        // UPDATE PASSWORD (Prepared Statement)
        // ---------------------------------------------
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt3 = mysqli_prepare($koneksi, "UPDATE akun_pasien SET password = ? WHERE email = ?");
        mysqli_stmt_bind_param($stmt3, "ss", $password_hash, $email);

        if (!mysqli_stmt_execute($stmt3)) {
            die("SQL Error saat update password: " . mysqli_error($koneksi));
        }

        // ---------------------------------------------
        // HAPUS TOKEN (Prepared Statement)
        // ---------------------------------------------
        $stmt4 = mysqli_prepare($koneksi, "DELETE FROM password_resets WHERE email = ?");
        mysqli_stmt_bind_param($stmt4, "s", $email);
        mysqli_stmt_execute($stmt4);

        // ---------------------------------------------
        // REDIRECT SUKSES
        // ---------------------------------------------
        header("Location: " . BASE_URL . "index.php?pesan=reset_sukses");
        exit;
    }

?>