<?php

    // pengecekan otentikasi
    $require_login = true; // harus login
    include __DIR__ . '/../../features/auth/authorization/worker.php';

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../../config/config.php';

?>

<main>
    <section class="dashboard-section">
        <div class="custom-header text-center dashboard-text select-none">
            <h2>
                <i class="fas fa-laptop-house mr-1" aria-hidden="true"></i>
                Dashboard
            </h2>
            <p>Memantau dan mengelola seluruh aktivitas Poliklinik dalam satu layar</p>
        </div><hr>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid text-center">

            <?php 
                // Jika login sebagai admin → munculkan Menu Manajemen Pekerja
                if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin'):
            ?>
                <!-- Card 1 -->
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

            <!-- Card 2 -->
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
            
            <!-- Card 3 -->
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
            
            <!-- Card 4 -->
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
            
        </div>
    </section>
</main>