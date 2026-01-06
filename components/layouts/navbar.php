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
                        <?php 
                            $allowed_roles = ['pekerja', 'admin'];
                            if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                        ?>
                            <a class="nav-link" onclick="openLink('<?= BASE_URL ?>index.php?page=worker/dashboard', false)">
                                <i class="fas fa-laptop-house mr-1" aria-hidden="true"></i>
                                Dashboard
                            </a>
                        <?php else: ?>
                            <a class="nav-link" onclick="openLink('<?= BASE_URL ?>', false)">
                                <i class="fas fa-home" aria-hidden="true"></i>
                                Beranda
                            </a>
                        <?php endif; ?>
                    </li>
                    <li class="navbar-divider"></li>
                    <li class="nav-item select-none">
                        <div class="dropdown">
                            <a class="nav-link" onclick="openLink('#', false)" role="button" id="InfoPoliDropdown" data-toggle="dropdown">
                                Info
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="InfoPoliDropdown">
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_information', false)">
                                        Informasi Pelayanan
                                        <i class="fas fa-info-circle ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_options', false)">
                                        Grafik Kunjungan
                                        <i class="fas fa-chart-line ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_facilities', false)">
                                        Fasilitas Poliklinik
                                        <i class="fas fa-hand-holding-medical ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/gallery', false)">
                                        Galeri
                                        <i class="fas fa-photo-video ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="navbar-divider"></li>
                    
                    <?php 
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):
                    ?>  
                        <li class="nav-item select-none">
                            <div class="dropdown">
                                <a class="nav-link" onclick="openLink('#', false)" role="button" id="LayananPoliDropdown" data-toggle="dropdown">
                                    Layanan
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="LayananPoliDropdown">

                                    <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=admin/user_log', false)">
                                                Catatan Aktivitas
                                                <i class="fas fa-folder-open ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    <?php endif; ?>

                                    <?php 
                                        $allowed_roles = ['pasien', 'pekerja', 'admin'];
                                        if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                                    ?>
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_registration', false)">
                                                Registrasi Antrean
                                                <i class="fas fa-user-tag ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_status', false)">
                                                Status Antrean
                                                <i class="fas fa-tasks ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </li>
                        <li class="navbar-divider"></li>
                    <?php endif; ?>

                    <li class="nav-item select-none">
                        <div class="dropdown">
                            <?php 
                                $foto = $_SESSION['foto'] ?? 'default.png';
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):
                            ?>
                                <a class="nav-link" onclick="openLink('#', false)" role="button" id="ProfileDropdown" data-toggle="dropdown">
                                    <img src="<?= BASE_URL ?>public/assets/img/photo/<?= htmlspecialchars($foto) ?>" alt="Profil" class="navbar-avatar" />
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ProfileDropdown">

                                    <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=admin/profile', false)">
                                                Pengaturan Akun
                                                <i class="fas fa-user-cog ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'pekerja'): ?>
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=worker/profile', false)">
                                                Pengaturan Akun
                                                <i class="fas fa-user-cog ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'pasien'): ?>
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/profile', false)">
                                                Pengaturan Akun
                                                <i class="fas fa-user-cog ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    <?php endif; ?>

                                    <div class="dropdown-menu-child">
                                        <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>components/features/auth/authentication/logout.php', false)">
                                            Keluar
                                            <i class="fas fa-sign-out-alt ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a class="nav-link" onclick="openLink('#', false)" data-toggle="modal" data-target="#modalLoginPasien">
                                    Masuk
                                    <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>