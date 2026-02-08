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
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/home.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/clinic_information.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/chart_options.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/clinic_facilities.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/guest/gallery.css">

        <!-- Halaman Umum (Harus Login) -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/all_roles/profile.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/all_roles/queue_registration.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/all_roles/queue_status.css">

        <!-- Halaman Khusus Admin dan Pekerja -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker_admin/dashboard.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker_admin/patient_management.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker_admin/queue_management.css">

        <!-- Halaman Khusus Admin -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/admin/user_management.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/admin/user_log.css">

        <!-- Modal -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/modules/modal.css">
    </head>


    <!-- BODY -->
    <body 
        class="sidebar-expanded <?= isset($_SESSION['level']) ? 'role-' . $_SESSION['level'] : '' ?>"
        data-loggedin="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false' ?>"
    >
        <!-- Wrapper Utama Aplikasi -->
        <div class="wrapper">

            <!-- Konten Utama -->
            <div id="content">