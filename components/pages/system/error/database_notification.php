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
        $projectFolder = str_replace($docRoot, '', str_replace('\\', '/', realpath(__DIR__ . '/../../../../')));

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
    // FUNGSI REDIRECT BERDASARKAN STATUS LOGIN & LEVEL USER
    // ===========================================================================================
    function redirectBySession() {

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


    // ===========================================================================================
    // CLEAR ERROR SESSION & RETURN TO SPECIFIC PAGE
    // ===========================================================================================

    // Menjalankan proses reset jika parameter 'clear' bernilai '1'
    if (isset($_GET['clear']) && $_GET['clear'] === '1') {

        // Menghapus tanda error database dari session setelah digunakan
        // Tujuannya supaya sistem bisa kembali berjalan normal
        unset($_SESSION['__db_error']);

        // Menghapus pesan error dari session setelah digunakan
        // Tujuannya agar pesan error hanya ditampilkan satu kali
        unset($_SESSION['error_message']);

        // Panggil fungsi redirect khusus
        redirectBySession();
    }


    // ===========================================================================================
    // ERROR HANDLING
    // ===========================================================================================

    // Jika database tidak ada error dan halaman notifikasi error database diakses secara ilegal, maka :
    if (!isset($_SESSION['__db_error']) || $_SESSION['__db_error'] !== true) {

        // Jika tidak ada pesan error, maka :
        if (!isset($_SESSION['error_message'])) {

            // Panggil fungsi redirect khusus
            redirectBySession();
        }
    }


    // ===========================================================================================
    // AMBIL PESAN ERROR
    // ===========================================================================================
    $error_message = $_SESSION['error_message'] ?? NULL;

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
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/system/error/database_notification.css">
        <style>
            body {
                background-image: url("<?= BASE_URL ?>public/assets/img/others/medical_background.jpg");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
    </head>


    <!-- Memuat pengaturan interval polling AJAX -->
    <?php require_once __DIR__ . '/../../../../config/timeout_duration.php'; ?>


    <!-- BODY -->
    <body data-poll-interval="<?= AUTH_POLL_INTERVAL ?>">
        <main>

            <!-- =========================================================================================== -->
            <!-- DATABASE NOTIFICATION SECTION                                                               -->
            <!-- =========================================================================================== -->
            <section class="database-notification-section">

                <!-- Pembungkus Card -->
                <div class="card-wrapper select-none">

                    <!-- Judul Error -->
                    <div class="card-header">
                        <h1 class="card-title">
                            <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>
                            Oops! Kesalahan Database
                        </h1>
                    </div>

                    <!-- Deskripsi Error -->
                    <div class="card-body">
                        <p class="card-text">
                            <small>
                                Pesan Error: <span>
                                    <strong>
                                        <?= $error_message ? htmlspecialchars($error_message).'.' : 'Tidak ada informasi error.' ?>
                                    </strong>
                                </span>
                            </small>
                        </p>
                    </div>

                </div>
            </section>
        </main>


        <!-- =========================================================================================== -->
        <!-- PENGECEKAN STATUS DATABASE SECARA BERKALA                                                   -->
        <!-- =========================================================================================== -->
        <script>

            // Definisi BASE-URL untuk AJAX
            var BASE_URL = '<?= BASE_URL ?>';

            // Mengambil interval polling AJAX dari <body>
            const CHECK_INTERVAL = parseInt(document.body.dataset.pollInterval);

            // Lokasi halaman yang dituju saat terjadi error pada database
            const PAGE_DB_ERROR = "components/pages/system/error/database_notification.php";

            // Menjalankan polling AJAX secara berkala
            setInterval(() => {

                // Mengirimkan request ke server untuk mengecek status session
                fetch(BASE_URL + "components/data/ajax_auth_check.php", {
                    credentials: 'same-origin'
                })
                .then(res => res.json())    // Mengubah response menjadi format JSON
                .then(res => {              // Memproses data JSON yang diterima dari server

                    // Jika status dari server adalah 'ok' (Artinya database sudah kembali normal), maka :
                    if (res.status === 'ok') {

                        // Redirect ke halaman notifikasi error database dengan parameter 'clear=1'
                        // Tujuannya untuk menghapus flag error dan mengembalikan user ke halaman semula
                        window.location.href = BASE_URL + PAGE_DB_ERROR + "?clear=1";
                    }

                })

                // Tidak melakukan tindakan apa pun agar polling tetap berjalan
                .catch(() => {});

            // Menentukan interval polling ke server
            }, CHECK_INTERVAL);

        </script>
    </body>
</html>