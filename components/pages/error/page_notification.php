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
        <style>
            body { font-family: Arial; background: #f2f2f2; display: flex; justify-content: center; align-items: center; height: 100vh; }
            .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
            .error { color: red; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1 class="error">❌ Oops! Terjadi Kesalahan</h1>
            <p><?= htmlspecialchars($error_message) ?></p>
            <br>
            <a href="<?= BASE_URL ?>">Kembali ke Beranda</a>
        </div>
    </body>
</html>