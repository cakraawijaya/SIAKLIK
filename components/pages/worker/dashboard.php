<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    $require_login = true; // harus login
    $allowed_levels = ['pekerja']; // akses yang diberikan
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

            <!-- ======================== CARD 1: MENU MANAJEMEN PASIEN ======================== -->
            <div class="dashboard-item select-none">
                <a onclick="openLink('<?= BASE_URL ?>index.php?page=management/patients', false)">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <i class="fas fa-book" aria-hidden="true"></i>
                            <span class="font-weight-bold">Manajemen Pasien</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- ======================== CARD 2: MENU MANAJEMEN ANTREAN ======================= -->
            <div class="dashboard-item select-none">
                <a onclick="openLink('<?= BASE_URL ?>index.php?page=management/queues', false)">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <i class="fas fa-tasks" aria-hidden="true"></i>
                            <span class="font-weight-bold">Manajemen Antrean</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- ======================== CARD 3: MENU GRAFIK KUNJUNGAN ======================== -->
            <div class="dashboard-item select-none">
                <a onclick="openLink('<?= BASE_URL ?>index.php?page=guest/statistics/options', false)">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <i class="fas fa-chart-bar" aria-hidden="true"></i>
                            <span class="font-weight-bold">Grafik Kunjungan</span>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </section>
</main>