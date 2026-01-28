<?php

    // ===========================================================================================
    // KONFIGURASI DASAR SISTEM
    // ===========================================================================================
    // File ini bertanggung jawab untuk mendefinisikan konstanta global seperti :
    // BASE_URL dan BASE_PATH yang digunakan di seluruh sistem

    // Pastikan BASE_URL hanya didefinisikan satu kali
    if (!defined('BASE_URL')) {

        // Deteksi protokol yang digunakan (HTTP atau HTTPS)
        // HTTPS dianggap aktif jika variabel HTTPS tersedia atau server berjalan di port 443
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // Ambil host dari request (contoh: localhost, domain.com)
        $host = $_SERVER['HTTP_HOST'];

        // Ambil path folder project relatif terhadap document root
        $projectFolder = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', dirname(__DIR__)));

        // Pastikan path diakhiri dengan slash
        $projectFolder = rtrim($projectFolder, '/') . '/';

        // Definisikan BASE_URL sebagai URL absolut aplikasi
        define('BASE_URL', $protocol . $host . $projectFolder);
    }

    // Pastikan BASE_PATH hanya didefinisikan satu kali
    if (!defined('BASE_PATH')) {

        // Definisikan BASE_PATH sebagai path absolut folder root aplikasi di server
        define('BASE_PATH', realpath(__DIR__ . '/..'));
    }


    // ===========================================================================================
    // MEMUAT KONFIGURASI DAN KONEKSI DATABASE
    // ===========================================================================================
    // File connection.php bertanggung jawab untuk inisialisasi koneksi database
    require_once BASE_PATH . '/config/connection.php';

?>
