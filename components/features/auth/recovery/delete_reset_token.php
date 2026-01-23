<?php

    // ===========================================================================================
    // KONEKSI & AKSES BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/../../../../config/config.php';


    // ===========================================================================================
    // PROSES HANYA DIJALANKAN JIKA REQUEST = GET
    // ===========================================================================================
    // Mengecek apakah parameter 'email' dikirim melalui URL (method GET)
    // Script hanya akan berjalan jika email benar-benar tersedia
    if (isset($_GET['email'])) {

        // Mengambil email dari URL lalu mengamankannya sebelum data dipakai dalam query database
        $email = mysqli_real_escape_string($koneksi, $_GET['email']);

        // Menghapus token berdasarkan email
        mysqli_query($koneksi, "DELETE FROM password_resets WHERE email='$email'");
    }


    // ===========================================================================================
    // REDIRECT MODAL
    // ===========================================================================================
    // Setelah hapus token, lalu lakukan redirect ke modal login pasien
    header("Location: " . BASE_URL . "index.php?modal=pasien");
    exit; // Menghentikan eksekusi script

?>