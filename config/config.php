<?php

    // ========================================
    // KONFIGURASI DASAR SISTEM
    // ========================================

    // Pastikan tidak didefinisikan dua kali
    if (!defined('BASE_URL')) {
        // Deteksi protokol (http/https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST']; // contoh: localhost

        // Ambil path proyek relatif terhadap DOCUMENT_ROOT
        $projectFolder = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', dirname(__DIR__)));

        // Tambahkan trailing slash
        $projectFolder = rtrim($projectFolder, '/') . '/';

        // Definisikan BASE_URL (URL absolut)
        define('BASE_URL', $protocol . $host . $projectFolder);
    }

    if (!defined('BASE_PATH')) {
        // Definisikan BASE_PATH (path absolut di server)
        define('BASE_PATH', realpath(__DIR__ . '/..'));
    }

    // ========================================
    // MUAT KONEKSI DATABASE
    // ========================================
    require_once BASE_PATH . '/config/connection.php';

?>
