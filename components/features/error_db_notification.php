<?php 
    if (!defined('BASE_URL')) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST']; // localhost

        // ambil path folder root proyek relatif terhadap DOCUMENT_ROOT
        $docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
        $projectRoot = str_replace($docRoot, '', str_replace('\\', '/', realpath(__DIR__ . '/../../')));

        $projectRoot = rtrim($projectRoot, '/') . '/';

        define('BASE_URL', $protocol . $host . $projectRoot);
    }

    session_start();

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
        <meta charset="UTF-8">
        <title>Koneksi Database Gagal</title>
        <style>
            body { font-family: Arial; background: #f2f2f2; display: flex; justify-content: center; align-items: center; height: 100vh; }
            .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
            .error { color: red; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1 class="error">❌ Oops! Koneksi Database Gagal</h1>
            <p>Silakan hubungi admin atau periksa konfigurasi.</p>
            <small>Error: <strong><?= $error_message ? htmlspecialchars($error_message).'.' : 'Tidak ada informasi error.' ?></strong></small>
        </div>
    </body>
</html>