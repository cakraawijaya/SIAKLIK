<?php 

    if (!defined('BASE_URL')) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST']; // localhost

        // ambil path folder root proyek relatif terhadap DOCUMENT_ROOT
        $docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
        $projectRoot = str_replace($docRoot, '', str_replace('\\', '/', realpath(__DIR__ . '/../../../')));

        $projectRoot = rtrim($projectRoot, '/') . '/';

        define('BASE_URL', $protocol . $host . $projectRoot);
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['error_message'])) {
        header("Location: " . BASE_URL);
        exit;
    }

    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);

?>


<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link rel="icon" href="<?= BASE_URL ?>public/assets/img/favicon/favicon-32x32.png">
        <title>SIAKLIK</title>
        <meta name="description" content="Website SIAKLIK">
        <meta name="keywords" content="klinik, bpjs, kesehatan" />

        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/vendor/fontawesome/css/all.min.css">

        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/error/page_notification.css">
        <style>
            body {
                background-image: url("<?= BASE_URL ?>public/assets/img/others/medical_background.jpg");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
    </head>
    <body>
        <main>
            <section class="page-notification-section">
                <div class="card-wrapper select-none">
                    <div class="card-header">
                        <h1 class="card-title">
                            <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>
                            Oops! Terjadi Kesalahan
                        </h1>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Halaman <span>
                            '<strong><?= htmlspecialchars($error_message) ?></strong>'
                            </span> tidak ditemukan.
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="<?= BASE_URL ?>"><span>Kembali ke Beranda</span></a>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>