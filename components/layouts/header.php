<!DOCTYPE HTML>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" href="<?= BASE_URL ?>public/assets/img/brand/favicon-32x32.png">

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
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/navbar.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/sidebar.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/font.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/main.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/table.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/chart.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/gallery.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/modal.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/vanillatop.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/footer.css">
    </head>

    <body data-loggedin="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false' ?>">
        <div class="wrapper">
            <div id="content" >