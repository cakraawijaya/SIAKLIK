<?php

    // ===========================================================================================
    // AKSES BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/../../config/config.php';

?>


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="d-flex w-100 align-items-center">


            <!--
            ===========================================================================================
            KIRI: TOMBOL SIDEBAR
            - Tombol untuk membuka / menutup sidebar
            ===========================================================================================
            -->
            <div class="me-3">
                <button type="button" id="sidebarCollapse" class="btn btn-sidebar">
                    <i class="fas fa-align-left" aria-hidden="true"></i>
                    <span></span>
                </button>
            </div>


            <!--
            ===========================================================================================
            KANAN: MENU UTAMA
            - Berisi menu navigasi utama
            - Menu ditampilkan berdasarkan role dan status login user
            ===========================================================================================
            -->
            <div class="d-flex flex-grow-1 justify-content-end">
                <ul class="nav navbar-nav d-flex align-items-center">


                    <!--
                    ===========================================================================================
                    MENU DASHBOARD / BERANDA
                    ===========================================================================================
                    -->
                    <li class="nav-item select-none">

                        <!-- Menu khusus untuk Admin -->
                        <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>

                            <!-- Dashboard -->
                            <a class="nav-link" onclick="openLink('<?= BASE_URL ?>index.php?page=admin/dashboard', false)">
                                <i class="fas fa-laptop-house mr-1" aria-hidden="true"></i>
                                Dashboard
                            </a>

                        <!-- Menu khusus untuk Pekerja -->
                        <?php elseif (isset($_SESSION['level']) && $_SESSION['level'] === 'pekerja'): ?>

                            <!-- Dashboard -->
                            <a class="nav-link" onclick="openLink('<?= BASE_URL ?>index.php?page=worker/dashboard', false)">
                                <i class="fas fa-laptop-house mr-1" aria-hidden="true"></i>
                                Dashboard
                            </a>

                        <!-- Menu selain Pekerja dan Admin -->
                        <?php else: ?>

                            <!-- Beranda -->
                            <a class="nav-link" onclick="openLink('<?= BASE_URL ?>', false)">
                                <i class="fas fa-home" aria-hidden="true"></i>
                                Beranda
                            </a>
                        <?php endif; ?>
                    </li>

                    <li class="navbar-divider"></li> <!-- Garis pemisah menu -->


                    <!--
                    ===========================================================================================
                    MENU INFO
                    ===========================================================================================
                    -->
                    <li class="nav-item select-none">
                        <div class="dropdown">
                            <a class="nav-link" onclick="openLink('#', false)" role="button" id="InfoPoliDropdown" data-toggle="dropdown">
                                Info
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="InfoPoliDropdown">

                                <!-- Informasi Pelayanan -->
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=guest/clinic/information', false)">
                                        Informasi Pelayanan
                                        <i class="fas fa-info-circle ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="dropdown-divider"></div> <!-- Garis pemisah submenu -->

                                <!-- Grafik Kunjungan -->
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=guest/statistics/options', false)">
                                        Grafik Kunjungan
                                        <i class="fas fa-chart-line ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="dropdown-divider"></div> <!-- Garis pemisah submenu -->

                                <!-- Fasilitas Poliklinik -->
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=guest/clinic/facilities', false)">
                                        Fasilitas Poliklinik
                                        <i class="fas fa-hand-holding-medical ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="dropdown-divider"></div> <!-- Garis pemisah submenu -->

                                <!-- Galeri -->
                                <div class="dropdown-menu-child">
                                    <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=guest/clinic/gallery', false)">
                                        Galeri
                                        <i class="fas fa-photo-video ml-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="navbar-divider"></li> <!-- Garis pemisah menu -->


                    <!--
                    ===========================================================================================
                    MENU LAYANAN
                    ===========================================================================================
                    -->
                    <?php 
                        // Jika sedang login, maka tampilkan :
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):
                    ?>  

                        <li class="nav-item select-none">
                            <div class="dropdown">
                                <a class="nav-link" onclick="openLink('#', false)" role="button" id="LayananPoliDropdown" data-toggle="dropdown">
                                    Layanan
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="LayananPoliDropdown">

                                    <!-- Menu khusus untuk Admin -->
                                    <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>

                                        <!-- Catatan Aktivitas -->
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=management/logs', false)">
                                                Catatan Aktivitas
                                                <i class="fas fa-folder-open ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>

                                        <div class="dropdown-divider"></div> <!-- Garis pemisah submenu -->
                                    <?php endif; ?>

                                    <!-- Menu untuk Pasien, Pekerja, dan Admin -->
                                    <?php 
                                        $allowed_roles = ['pasien', 'pekerja', 'admin'];
                                        if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                                    ?>

                                        <!-- Registrasi Antrean -->
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=general/queue/registration', false)">
                                                Registrasi Antrean
                                                <i class="fas fa-user-tag ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>

                                        <div class="dropdown-divider"></div> <!-- Garis pemisah submenu -->

                                        <!-- Status Antrean -->
                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=general/queue/status', false)">
                                                Status Antrean
                                                <i class="fas fa-tasks ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </li>

                        <li class="navbar-divider"></li> <!-- Garis pemisah menu -->
                    <?php endif; ?>


                    <!--
                    ===========================================================================================
                    MENU AKUN PENGGUNA
                    ===========================================================================================
                    -->
                    <li class="nav-item select-none">
                        <div class="dropdown">
                            <?php
                                // Mengambil foto profil dari session, jika tidak ada gunakan default
                                $foto = $_SESSION['foto'] ?? 'default.png';

                                // Jika sedang login, maka tampilkan :
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):
                            ?>

                                <a class="nav-link" onclick="openLink('#', false)" role="button" id="ProfileDropdown" data-toggle="dropdown">
                                    <img src="<?= BASE_URL ?>public/assets/img/photo/<?= htmlspecialchars($foto) ?>" alt="Profil" class="navbar-avatar" />
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ProfileDropdown">

                                    <!-- Menu untuk Pasien, Pekerja, dan Admin -->
                                    <?php 
                                        $allowed_roles = ['pasien', 'pekerja', 'admin'];
                                        if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                                    ?>

                                        <div class="dropdown-menu-child">
                                            <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>index.php?page=general/account/profile', false)">
                                                Pengaturan Akun
                                                <i class="fas fa-user-cog ml-1" aria-hidden="true"></i>
                                            </a>
                                        </div>

                                        <div class="dropdown-divider"></div> <!-- Garis pemisah submenu -->
                                    <?php endif; ?>

                                    <!-- Keluar -->
                                    <div class="dropdown-menu-child">
                                        <a class="dropdown-item" onclick="openLink('<?= BASE_URL ?>components/features/auth/authentication/logout.php', false)">
                                            Keluar
                                            <i class="fas fa-sign-out-alt ml-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>

                            <?php
                                else: // Jika belum login, maka tampilkan :
                            ?>

                                <!-- Masuk -->
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