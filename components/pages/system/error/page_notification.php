<?php

    // ===========================================================================================
    // AKSES BASE_URL
    // ===========================================================================================

    // Pastikan BASE_URL hanya didefinisikan satu kali
    if (!defined('BASE_URL')) {

        // Deteksi protokol yang digunakan (HTTP atau HTTPS)
        // HTTPS dianggap aktif jika variabel HTTPS tersedia atau server berjalan di port 443
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // Ambil host dari request (contoh: localhost, domain.com)
        $host = $_SERVER['HTTP_HOST'];

        // Document root server (diseragamkan dengan slash)
        $docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

        // Ambil path folder project relatif terhadap document root
        $projectFolder = str_replace($docRoot, '', str_replace('\\', '/', realpath(__DIR__ . '/../../../')));

        // Pastikan path diakhiri dengan slash
        $projectFolder = rtrim($projectFolder, '/') . '/';

        // Definisikan BASE_URL sebagai URL absolut aplikasi
        define('BASE_URL', $protocol . $host . $projectFolder);
    }


    // ===========================================================================================
    // CEK SESSION
    // ===========================================================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }


    // ===========================================================================================
    // ERROR HANDLING
    // ===========================================================================================

    // Jika tidak ada pesan error, maka :
    if (!isset($_SESSION['error_message'])) {

        // Cek apakah saat ini user tidak login, jika iya maka :
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

            // Redirect ke halaman beranda
            header("Location: " . BASE_URL);
            exit; // Menghentikan eksekusi script
        }

        // Konfigurasi pemetaan role user ke route tujuan masing-masing
        $redirectMap = [
            'pasien'  => "index.php?page=general/queue/registration",  // Halaman registrasi antrean pasien
            'pekerja' => "index.php?page=worker/dashboard",            // Halaman dashboard pekerja
            'admin'   => "index.php?page=admin/dashboard",             // Halaman dashboard admin
        ];

        // Jika level user tersedia dan terdaftar dalam mapping (dikenali), maka :
        if (isset($_SESSION['level']) && isset($redirectMap[$_SESSION['level']])) {

            // Redirect ke halaman yang sudah ditentukan (sesuai dengan level user yang sedang login)
            header("Location: " . BASE_URL . $redirectMap[$_SESSION['level']]);
            exit; // Menghentikan eksekusi script
        }
    }

    // Ambil pesan error
    $error_message = $_SESSION['error_message'] ?? NULL;

    // Menghapus pesan error dari session setelah digunakan
    // Tujuannya agar pesan error hanya ditampilkan satu kali
    unset($_SESSION['error_message']);

?>


<!DOCTYPE html>
<html lang="id">
    <!-- HEAD -->
    <head>
        <!-- Charset & Responsive Setup -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Favicon -->
        <link rel="icon" href="<?= BASE_URL ?>public/assets/img/favicon/favicon-32x32.png">

        <!-- Judul Halaman -->
        <title>SIAKLIK</title>

        <!-- SEO Meta -->
        <meta name="description" content="SIAKLIK adalah sistem informasi pelayanan klinik kesehatan berbasis web untuk pendaftaran pasien, antrean online, layanan BPJS, dan manajemen rekam medis secara terintegrasi.">
        <meta name="keywords" content="siaklik, sistem informasi klinik, aplikasi klinik, poliklinik, klinik kesehatan, upn jatim, layanan bpjs" />


        <!-- =================================== VENDOR CSS ================================ -->
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/vendor/fontawesome/css/all.min.css">


        <!-- =================================== CUSTOM CSS ================================ -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/system/error/page_notification.css">
        <style>
            body {
                background-image: url("<?= BASE_URL ?>public/assets/img/others/medical_background.jpg");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
    </head>


    <!-- BODY -->
    <body>
        <main>

            <!-- =========================================================================================== -->
            <!-- PAGE NOTIFICATION SECTION                                                                   -->
            <!-- =========================================================================================== -->
            <section class="page-notification-section">

                <!-- Pembungkus Card -->
                <div class="card-wrapper select-none">

                    <!-- Judul Error -->
                    <div class="card-header">
                        <h1 class="card-title">
                            <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>
                            Oops! Terjadi Kesalahan
                        </h1>
                    </div>

                    <!-- Deskripsi Error -->
                    <div class="card-body">
                        <p class="card-text">
                            Halaman <span>
                            '<strong><?= htmlspecialchars($error_message) ?></strong>'
                            </span> tidak ditemukan.
                        </p>
                    </div>

                    <!-- Tombol Kembali ke Beranda -->
                    <div class="card-footer">
                        <a href="<?= BASE_URL ?>"><span>Kembali ke Beranda</span></a>
                    </div>

                </div>
            </section>
        </main>
    </body>
</html>