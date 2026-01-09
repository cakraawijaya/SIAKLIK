<?php 
    
    // mengaktifkan session php
    session_start();

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../../../config/config.php';

    // Ambil data dari Session
    $username = $_SESSION['username'];
    $level    = $_SESSION['level'];
    $nama     = $_SESSION['nama_lengkap'];

    // Log User: Logout
    mysqli_query($koneksi, "
        INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
        VALUES ('$username', '$level', 'Logout', '$nama telah Logout.', NOW())
    ");
    
    // menghapus semua session
    $_SESSION = [];
    session_unset();
    session_destroy();

    // mengalihkan halaman ke halaman utama
    header("location: " . BASE_URL . "index.php?pesan=logout");
    exit;

?>