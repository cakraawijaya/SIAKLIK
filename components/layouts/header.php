<!DOCTYPE HTML>
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
        <!-- Bootstrap 4 CSS -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/vendor/bootstrap/css/bootstrap.min.css">

        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/vendor/fontawesome/css/all.min.css">

        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/vendor/malihu/jquery.mCustomScrollbar.min.css">

        <!-- Vanillatop -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/vendor/vanillatop/dist/vanillatop.min.css">

        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/vendor/sweetalert2/sweetalert2.min.css">


        <!-- =================================== CUSTOM CSS ================================ -->
        <!-- Layout Utama (Global) -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/navbar.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/header.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/sidebar.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/main.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/footer.css">

        <!-- Halaman Umum (Tidak Harus Login) -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/home.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/clinic/information.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/clinic/facilities.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/clinic/gallery.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/statistics/all.css">

        <!-- Halaman Umum (Harus Login) -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/general/account/profile.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/general/queue/registration.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/general/queue/status.css">

        <!-- Halaman Khusus Admin dan Pekerja -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker_admin/dashboard.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/management/patients.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/management/queues.css">

        <!-- Halaman Khusus Admin -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/management/users.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/management/logs.css">

        <!-- Modal -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/modules/modal.css">
    </head>


    <!-- Memuat pengaturan timeout user dan interval polling AJAX -->
    <?php require_once __DIR__ . '/../../config/timeout_duration.php'; ?>


    <!-- BODY -->
    <body 
        class="sidebar-expanded <?= isset($_SESSION['level']) ? 'role-' . $_SESSION['level'] : '' ?>"
        data-loggedin="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false' ?>"
        data-timeout="<?= AUTH_TIMEOUT ?>" data-poll-interval="<?= AUTH_POLL_INTERVAL ?>"
    >
        <!-- Wrapper Utama Aplikasi -->
        <div class="wrapper">

            <!-- Konten Utama -->
            <div id="content">