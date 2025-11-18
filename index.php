<?php

    // Memulai output buffering
    ob_start();

    // Memulai session
    session_start();

    // Konfigurasi utama
    require_once __DIR__ . '/config/config.php';

    // Routing halaman
    $page = $_GET['page'] ?? 'home';
    $page = str_replace(['..', './', '\\'], '', $page);
    $view = BASE_PATH . "/components/pages/{$page}.php";

    // Jika page tidak ditemukan maka redirect ke halaman error
    if (!file_exists($view)) {
        $_SESSION['error_message'] = "Halaman '$page' tidak ditemukan.";
        header("Location: " . BASE_URL . "index.php?page=error/page_notification");
        exit;
    }

    // Jika halaman berada dalam folder `error/`, tampilkan tanpa layout
    if (strpos($page, 'error/') === 0) {
        include $view;
        ob_end_flush();
        exit;
    }

    // ---------------------------------------------------------------
    // Jika tidak error maka atur konten beserta layoutnya sekaligus
    // ---------------------------------------------------------------

    // Komponen header
    include BASE_PATH . '/components/layouts/header.php';

    // Komponen navbar
    include BASE_PATH . '/components/layouts/navbar.php';

    // Komponen sidebar
    include BASE_PATH . '/components/layouts/sidebar.php';

    // Komponen konten
    include $view;

    // Komponen footer
    include BASE_PATH . '/components/layouts/footer.php';

    // Akhiri buffering dan kirim output
    ob_end_flush();

?>