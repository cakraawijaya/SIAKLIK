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
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/error/database_notification.css">
    </head>
    <body>
        <div class="card">
            <h1 class="error">❌ Oops! Koneksi Database Gagal</h1>
            <p>Silakan hubungi Admin atau periksa konfigurasi Anda.</p>
            <small>Error: <strong><?= $error_message ? htmlspecialchars($error_message).'.' : 'Tidak ada informasi error.' ?></strong></small>
        </div>
    </body>
</html>