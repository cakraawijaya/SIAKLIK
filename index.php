<?php

    // Memulai output buffering
    ob_start();

    // Memulai session
    session_start();

    // Konfigurasi utama
    require_once __DIR__ . '/config/config.php';

    // Komponen header
    include BASE_PATH . '/components/layouts/header.php';

    // Komponen sidebar
    include BASE_PATH . '/components/layouts/sidebar.php';

    // Komponen navbar
    include BASE_PATH . '/components/layouts/navbar.php';

    // Route halaman
    $page = $_GET['page'] ?? 'home'; // default: home
    $page = str_replace(['..', './', '\\'], '', $page); // mencegah akses di luar folder
    $view = BASE_PATH . "/components/pages/{$page}.php"; // menentukan tampilan web yang akan dimuat

    // Tampilkan halaman jika ada
    // Jika tidak ada, maka tampilkan "404 - Halaman Tidak Ditemukan"
    if(file_exists($view)){
        include $view;
    } else {
        echo "<h2>404 - Halaman Tidak Ditemukan</h2>";
    }

    // Komponen footer
    include BASE_PATH . '/components/layouts/footer.php';

    // Akhiri buffering dan kirim output
    ob_end_flush();

?>