<?php

    // ===========================================================================================
    // MEMULAI OUTPUT BUFFERING
    // ===========================================================================================
    // Menahan output sementara, sebelum dikirim ke browser
    ob_start();


    // ===========================================================================================
    // CEK SESSION
    // ===========================================================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }


    // ===========================================================================================
    // AKSES BASE_PATH & BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/config/config.php';


    // ===========================================================================================
    // ROUTING HALAMAN
    // ===========================================================================================
    // Ambil parameter 'page' dari URL, jika tidak ada maka default ke 'home'
    $page = $_GET['page'] ?? 'home';

    // Menghapus karakter yang bisa digunakan untuk traversal folder (..) atau direktori relatif (./, \)
    // Ini untuk mencegah serangan Local File Inclusion (LFI)
    $page = str_replace(['..', './', '\\'], '', $page);

    // Menentukan path file view yang akan di-include berdasarkan nilai $page
    $view = BASE_PATH . "/components/pages/{$page}.php";


    // ===========================================================================================
    // CEK FILE VIEW
    // ===========================================================================================
    // Jika file view tidak ditemukan, maka :
    if (!file_exists($view)) {

        // Simpan pesan error (halaman tidak ditemukan) ke dalam session
        $_SESSION['error_message'] = "$page";

        // Redirect ke halaman notifikasi error
        header("Location: " . BASE_URL . "index.php?page=system/error/page_notification");
        exit; // Menghentikan eksekusi script
    }


    // ===========================================================================================
    // TAMPILKAN HALAMAN ERROR TANPA LAYOUT
    // ===========================================================================================
    // Jika halaman berada dalam folder "error/", maka :
    if (strpos($page, 'system/error/') === 0) {
        include $view;      // Include file error (tanpa layout tambahan)
        ob_end_flush();     // Akhiri buffering dan kirim output
        exit;               // Menghentikan eksekusi script
    }


    // ===========================================================================================
    // TAMPILKAN HALAMAN NORMAL DENGAN LAYOUT
    // ===========================================================================================
    // Jika file ditemukan dan bukan halaman error, tampilkan dengan layout lengkap
    include BASE_PATH . '/components/layouts/header.php';   // Komponen header
    include BASE_PATH . '/components/layouts/navbar.php';   // Komponen navbar
    include BASE_PATH . '/components/layouts/sidebar.php';  // Komponen sidebar
    include $view;                                          // Komponen konten
    include BASE_PATH . '/components/layouts/footer.php';   // Komponen footer

    // Akhiri buffering dan kirim output
    ob_end_flush();

?>