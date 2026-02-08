<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    require_once __DIR__ . '/../../../features/auth/authorization/patient.php';


    // ===========================================================================================
    // CHARTS
    // ===========================================================================================
    // Data grafik yang akan ditampilkan di halaman
    // Berisi warna kartu, judul grafik, ikon, dan link tujuan grafik
    $charts_data = [
        ['color' => '#639c1f', 'label' => 'Jenis Kelamin', 'icon' => 'fas fa-procedures', 'link' => 'gender'],
        ['color' => '#24252d', 'label' => 'Satker 2013', 'icon' => 'fas fa-procedures', 'link' => '2013'],
        ['color' => '#639c1f', 'label' => 'Satker 2014', 'icon' => 'fas fa-procedures', 'link' => '2014'],
        ['color' => '#24252d', 'label' => 'Satker 2015', 'icon' => 'fas fa-procedures', 'link' => '2015'],
        ['color' => '#639c1f', 'label' => 'Satker 2016', 'icon' => 'fas fa-procedures', 'link' => '2016'],
        ['color' => '#24252d', 'label' => 'Satker 2017', 'icon' => 'fas fa-procedures', 'link' => '2017'],
        ['color' => '#639c1f', 'label' => 'Satker 2018', 'icon' => 'fas fa-procedures', 'link' => '2018'],
        ['color' => '#24252d', 'label' => 'Satker 2019', 'icon' => 'fas fa-procedures', 'link' => '2019'],
        ['color' => '#639c1f', 'label' => 'Satker 2020', 'icon' => 'fas fa-procedures', 'link' => '2020'],
        ['color' => '#24252d', 'label' => 'Satker 2021', 'icon' => 'fas fa-procedures', 'link' => '2021'],
        ['color' => '#639c1f', 'label' => 'Satker 2022', 'icon' => 'fas fa-procedures', 'link' => '2022']
    ];

?>


<main>

    <!-- =========================================================================================== -->
    <!-- CHARTS SECTION                                                                              -->
    <!-- =========================================================================================== -->
    <section class="charts-section">

        <!-- Header grafik kunjungan -->
        <div class="custom-header text-center charts-text select-none">
            <h2>
                <i class="fas fa-chart-line" aria-hidden="true"></i>
                Grafik Kunjungan
            </h2>
            <p>Daftar grafik kunjungan pada Poliklinik per tahun</p>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Pembungkus daftar grafik -->
        <div class="charts-grid-container">

            <!-- Loop data grafik untuk membuat card satu per satu -->
            <?php foreach ($charts_data as $charts) : ?>
                <div class="chart-grid">

                    <!-- Card grafik yang bisa diklik -->
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=guest/statistics/<?= $charts['link'] ?>', false)" class="card-link">
                        <div class="card interactive-card" style="--card-color: <?= $charts['color'] ?>;">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="<?= $charts['icon'] ?>" aria-hidden="true"></i>
                                <span class="select-none"><?= $charts['label'] ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

        </div>
    </section>
</main>