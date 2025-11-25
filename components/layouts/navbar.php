<?php require_once __DIR__ . '/../../config/config.php'; ?>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="d-flex w-100 align-items-center">
            <!-- Kiri: Tombol Sidebar -->
            <div class="me-3">
                <button type="button" id="sidebarCollapse" class="btn btn-sidebar">
                    <i class="fas fa-align-left" aria-hidden="true"></i>
                    <span></span>
                </button>
            </div>

            <!-- Kanan: Menu Utama -->
            <div class="d-flex flex-grow-1 justify-content-end">
                <ul class="nav navbar-nav d-flex align-items-center">
                    <li class="nav-item select-none">
                        <a class="nav-link" onclick="openLink('<?= BASE_URL ?>', false)">
                            <i class="fas fa-home mr-1" aria-hidden="true"></i>
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item select-none">
                        <div class="dropdown">
                            <a class="nav-link" onclick="openLink('#', false)" id="PoliDropdown" role="button" data-toggle="dropdown">
                                Poliklinik
                                <i class="fa fa-caret-down ml-1" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            
                                <?php 
                                    $allowed_roles = ['pekerja', 'admin'];
                                    if(isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                                ?>
                                    <div class="dropdown-menu-child">
                                        <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=worker/dashboard', false)">
                                            Dashboard Poliklinik
                                            <i class="fas fa-laptop-medical ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                <?php endif; ?>

                                <?php 
                                    $allowed_roles = ['pasien', 'pekerja', 'admin'];
                                    if(isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                                ?>
                                    <div class="dropdown-menu-child">
                                        <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_registration', false)">
                                            Registrasi Antrean Poliklinik
                                            <i class="fas fa-user-tag ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-menu-child">
                                        <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_status', false)">
                                            Status Antrean Poliklinik
                                            <i class="fas fa-tasks ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                <?php endif; ?>

                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_information', false)">
                                        Informasi Pelayanan
                                        <i class="fas fa-procedures ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_options', false)">
                                        Grafik Kunjungan
                                        <i class="fas fa-chart-bar ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_facilities', false)">
                                        Fasilitas Poliklinik
                                        <i class="fas fa-clinic-medical ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/gallery', false)">
                                        Galeri
                                        <i class="fas fa-photo-video ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                
                                <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?> 
                                    <div class="dropdown-menu-child">
                                        <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>components/features/auth/authentication/logout.php', false)">
                                            Keluar
                                            <i class="fas fa-sign-out-alt ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="dropdown-menu-child">
                                        <a class="dropdown-item" onclick="openLink('#', false)" data-toggle="modal" data-target="#modalLoginPasien">
                                            Masuk
                                            <i class="fas fa-sign-in-alt ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>