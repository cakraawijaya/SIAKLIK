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
    // LOGOUT MANUAL
    // ===========================================================================================

    // Ambil data dari Session
    $username = $_SESSION['username'];
    $level    = $_SESSION['level'];
    $nama     = $_SESSION['nama_lengkap'];

    // Format level
    $level = ucfirst(strtolower($level));

    // Log User: Logout
    mysqli_query($koneksi, "
        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
        VALUES ('$username', '$level', 'Logout', '$nama telah Logout.', NOW())
    ");

    // Menghapus semua session
    $_SESSION = [];
    session_unset();
    session_destroy();

    // Redirect ke halaman beranda
    // Hal ini disertai dengan pesan = Anda telah logout!
    header("location: " . BASE_URL . "index.php?pesan=logout");
    exit; // Menghentikan eksekusi script

?>