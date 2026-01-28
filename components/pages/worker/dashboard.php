<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    $require_login = true; // harus login
    require_once __DIR__ . '/../../features/auth/authorization/worker.php';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- DASHBOARD SECTION                                                                           -->
    <!-- =========================================================================================== -->
    <section class="dashboard-section">

        <!-- Header dashboard -->
        <div class="custom-header text-center dashboard-text select-none">
            <h2>
                <i class="fas fa-laptop-house mr-1" aria-hidden="true"></i>
                Dashboard
            </h2>
            <p>Memantau dan mengelola seluruh aktivitas Poliklinik dalam satu layar</p>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Pembungkus card dalam bentuk grid -->
        <div class="dashboard-grid text-center">

            <!-- Menu khusus untuk Admin -->
            <?php 
                // Jika login sebagai admin, maka munculkan tambahan menu :
                if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin'):
            ?>

                <!-- ======================== CARD 1: MENU MANAJEMEN PEKERJA ======================= -->
                <div class="dashboard-item select-none">
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=admin/user_management', false)">
                        <div class="card bg-secondary text-white h-100">
                            <div class="card-body">
                                <i class="fas fa-user-cog" aria-hidden="true"></i>
                                <span class="font-weight-bold">Manajemen Pengguna</span>
                            </div>
                        </div>
                    </a>
                </div>

            <?php endif; ?>


            <!-- Menu untuk Pekerja dan Admin -->
            <?php 
                // Secara default (login sebagai pekerja / admin), munculkan menu :
                $allowed_roles = ['pekerja', 'admin'];
                if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
            ?>

                <!-- ======================== CARD 2: MENU MANAJEMEN PASIEN ======================== -->
                <div class="dashboard-item select-none">
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=worker/patient_management', false)">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <i class="fas fa-book" aria-hidden="true"></i>
                                <span class="font-weight-bold">Manajemen Pasien</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- ======================== CARD 3: MENU MANAJEMEN ANTREAN ======================= -->
                <div class="dashboard-item select-none">
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=worker/queue_management', false)">
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <i class="fas fa-tasks" aria-hidden="true"></i>
                                <span class="font-weight-bold">Manajemen Antrean</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- ======================== CARD 4: MENU GRAFIK KUNJUNGAN ======================== -->
                <div class="dashboard-item select-none">
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_options', false)">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <i class="fas fa-chart-bar" aria-hidden="true"></i>
                                <span class="font-weight-bold">Grafik Kunjungan</span>
                            </div>
                        </div>
                    </a>
                </div>

            <?php endif; ?>
        </div>
    </section>
</main>