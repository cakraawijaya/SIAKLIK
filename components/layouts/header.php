<!DOCTYPE HTML>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" href="<?= BASE_URL ?>public/assets/img/favicon/favicon-32x32.png">

        <title>SIAKLIK</title>
        <meta name="description" content="Website SIAKLIK">
        <meta name="keywords" content="klinik, bpjs, kesehatan" />

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
        
        <!-- Our Custom CSS -->
        <!-- Layouts -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/navbar.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/header.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/sidebar.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/main.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/layouts/footer.css">
        <!-- Global -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/global/font.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/global/vanillatop.css">
        <!-- Modules -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/modules/table.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/modules/highcharts.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/modules/modal.css">
        <!-- Pages -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/home.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/patient/chart_options.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/patient/clinic_facilities.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/patient/clinic_information.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/patient/gallery.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/patient/queue_registration.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/patient/queue_status.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker/dashboard.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker/patient_management.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker/queue_management.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/admin/user_management.css">
        <!-- Under Construction -->
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/admin/profile.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/worker/profile.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/pages/patient/profile.css">
    </head>

    <body class="sidebar-expanded" data-loggedin="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false' ?>">
        <div class="wrapper">
            <div id="content">