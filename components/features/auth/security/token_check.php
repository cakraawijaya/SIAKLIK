<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/../../../../config/config.php';

    $email = isset($_GET['email']) ? mysqli_real_escape_string($koneksi, $_GET['email']) : '';
    $token = isset($_GET['token']) ? mysqli_real_escape_string($koneksi, $_GET['token']) : '';

    $showModal = false;
    if (!empty($email) && !empty($token)) {
        $res = mysqli_query($koneksi, "SELECT * FROM password_resets WHERE email='$email' AND token='$token'");
        if (mysqli_num_rows($res) > 0) {
            $showModal = true; // token valid
        } else {
            header("Location: " . BASE_URL . "index.php?pesan=token_invalid&modal=reset_password");
            exit;
        }
    }

?>