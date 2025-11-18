<?php

    // pengecekan otentikasi
    $require_login = true; // harus login
    include __DIR__ . '/../../features/auth/authorization/worker.php';

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../../config/config.php';

?>

<main>
    <section class="dashboard-section px-4 w-100">
        <div class="custom-header text-center dashboard-text select-none">
            <h2>
                <i class="fas fa-laptop-medical mr-1" aria-hidden="true"></i>
                Dashboard Poliklinik
            </h2>
            <p>Memantau dan mengelola seluruh aktivitas Poliklinik dalam satu layar</p>
        </div><hr>

        <!-- Tombol Menu -->
        <div class="container-fluid px-4 mt-5 mb-3 pb-2">
            <div class="row text-center justify-content-center" style="gap:5px;">

                <?php 
                    // Jika login sebagai admin → munculkan Menu Manajemen Pekerja
                    if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin'):
                ?>
                    <!-- Card 1 -->
                    <div class="col select-none">
                        <a href="<?= BASE_URL ?>index.php?page=admin/user_management" class="card-link">
                            <div class="card bg-secondary text-white interactive-card h-100">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <i class="fas fa-user-cog mb-3" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Manajemen Pengguna</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Card 2 -->
                <div class="col select-none">
                    <a href="<?= BASE_URL ?>index.php?page=worker/patient_management" class="card-link">
                        <div class="card bg-primary text-white interactive-card h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="fas fa-book mb-3" aria-hidden="true"></i>
                                <span class="font-weight-bold">Manajemen Pasien</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Card 3 -->
                <div class="col select-none">
                    <a href="<?= BASE_URL ?>index.php?page=worker/queue_management" class="card-link">
                        <div class="card bg-info text-white interactive-card h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="fas fa-tasks mb-3" aria-hidden="true"></i>
                                <span class="font-weight-bold">Manajemen Antrean</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Card 4 -->
                <div class="col select-none">
                    <a href="<?= BASE_URL ?>index.php?page=patient/chart/chart_options" class="card-link">
                        <div class="card bg-success text-white interactive-card h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="fas fa-chart-bar mb-3" aria-hidden="true"></i>
                                <span class="font-weight-bold">Grafik Kunjungan</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    /* Card Interaktif */
    .interactive-card {
        border-radius: 20px;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        position: relative;
    }

    /* Efek saat hover */
    .interactive-card:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        filter: brightness(1.08);
    }

    /* Glow halus dari bawah saat hover */
    .interactive-card::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: rgba(255, 255, 255, 0.4);
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease-in-out;
    }
    .interactive-card:hover::after {
        opacity: 1;
        transform: translateY(0);
    }

    /* Animasi ikon */
    .interactive-card i {
        font-size: 70px;
        margin-bottom: 10px;
        transition: transform 0.5s ease, color 0.3s ease;
    }

    /* Ikon berputar lembut & sedikit membesar */
    .interactive-card:hover i {
        transform: rotate(10deg) scale(1.15);
    }

    /* Centering isi card (ikon + teks) */
    .interactive-card .card-body {
        height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    /* Teks */
    .interactive-card span {
        font-size: 1.1rem;
        transition: color 0.3s ease;
    }

    /* Hover efek teks sedikit lebih terang */
    .interactive-card:hover span {
        color: #fff;
    }

    /* Hilangkan underline dari link */
    .card-link {
        text-decoration: none;
    }
    .card-link:hover {
        text-decoration: none;
        color: inherit;
    }

    /* Responsif di HP (card jadi stack ke bawah) */
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
            gap: 20px !important;
        }
        .interactive-card .card-body {
            height: 150px;
        }
        .interactive-card i {
            font-size: 50px;
        }
    }
</style>