<?php 
    
    // mengaktifkan session php
    session_start();
    
    // menghapus semua session
    $_SESSION = [];
    session_unset();
    session_destroy();
    
    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../config/config.php';

    // mengalihkan halaman ke halaman utama
    header("location: " . BASE_URL . "index.php?pesan=logout");
    exit;

?>