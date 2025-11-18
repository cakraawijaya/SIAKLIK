<?php

    session_start();
    require_once __DIR__ . '/../../../../config/config.php';

    if (isset($_GET['email'])) {
        $email = mysqli_real_escape_string($koneksi, $_GET['email']);
        mysqli_query($koneksi, "DELETE FROM password_resets WHERE email='$email'");
    }

    // Setelah hapus token, arahkan ke halaman utama dengan modal login pasien
    header("Location: " . BASE_URL . "index.php?modal=pasien");
    exit;

?>