<?php require_once __DIR__ . '/../../config/config.php'; ?>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn custom-btn-color">
            <i class="fas fa-align-left" aria-hidden="true"></i>
            <span></span>
        </button>

        <button class="btn btn-dark d-inline-block d-lg-none ml-auto py-2" type="button" 
                data-toggle="collapse" data-target="#navbarSupportedContent">
            <i class="fas fa-align-justify" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active mx-3 select-none">
                    <a class="nav-link" href="<?= BASE_URL ?>">
                        <i class="fas fa-home mr-1" aria-hidden="true"></i>
                        Beranda
                    </a>
                </li>

                <li class="nav-item mx-3 select-none">
                    <div class="dropdown show">
                        <a class="nav-link" href="#" id="PoliDropdown" role="button" data-toggle="dropdown">
                            Poliklinik
                            <i class="fa fa-caret-down ml-1" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right custom-icons mt-2" aria-labelledby="navbarDropdown">
                           
                            <?php 
                                $allowed_roles = ['pekerja', 'admin'];
                                if(isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                            ?>
                                <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>index.php?page=worker/dashboard">
                                    <i class="fas fa-laptop-medical mr-2" aria-hidden="true"></i>
                                    Dashboard Poliklinik
                                </a>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>

                            <?php 
                                $allowed_roles = ['pasien', 'pekerja', 'admin'];
                                if(isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                            ?>
                                <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>index.php?page=patient/clinic/queue_registration">
                                    <i class="fas fa-user-tag mr-2" aria-hidden="true"></i>
                                    Registrasi Antrean Poliklinik
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>index.php?page=patient/clinic/queue_status">
                                    <i class="fas fa-tasks mr-2" aria-hidden="true"></i>
                                    Status Antrean Poliklinik
                                </a>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>

                            <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>index.php?page=patient/clinic/clinic_information">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                Informasi Pelayanan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>index.php?page=patient/chart/chart_options">
                                <i class="fas fa-chart-bar mr-2" aria-hidden="true"></i>
                                Grafik Kunjungan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>index.php?page=patient/clinic/clinic_facilities">
                                <i class="fas fa-clinic-medical mr-2" aria-hidden="true"></i>
                                Fasilitas Poliklinik
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>index.php?page=patient/clinic/gallery">
                                <i class="fas fa-photo-video mr-2" aria-hidden="true"></i>
                                Galeri
                            </a>
                            <div class="dropdown-divider"></div>

                            <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?> 
                                <a class="dropdown-item custom-dropdown" href="<?= BASE_URL ?>components/features/logout.php">
                                    <i class="fas fa-sign-out-alt mr-2" aria-hidden="true"></i>
                                    Keluar
                                </a>
                            <?php else: ?>
                                <a class="dropdown-item custom-dropdown" href="#" data-toggle="modal" data-target="#modalLoginPasien">
                                    <i class="fas fa-sign-in-alt mr-2" aria-hidden="true"></i>
                                    Masuk
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>