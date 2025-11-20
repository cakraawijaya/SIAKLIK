<?php
include __DIR__ . '/../../../features/auth/authorization/patient.php';

$charts = [    
    ['color' => '#24252d', 'label' => 'SATKER 2015', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2015'],
    ['color' => '#639c1f', 'label' => 'SATKER 2014', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2014'],
    ['color' => '#24252d', 'label' => 'SATKER 2013', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2013'],
    ['color' => '#639c1f', 'label' => 'JENIS KELAMIN', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_gender'],
    ['color' => '#639c1f', 'label' => 'SATKER 2016', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2016'],
    ['color' => '#24252d', 'label' => 'SATKER 2017', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2017'],
    ['color' => '#639c1f', 'label' => 'SATKER 2018', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2018'],
    ['color' => '#24252d', 'label' => 'SATKER 2019', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2019'],
    ['color' => '#639c1f', 'label' => 'SATKER 2020', 'icon' => 'fas fa-notes-medical', 'link' => 'chart_2020'],
];

$firstRow = array_slice($charts, 0, 4);
$secondRow = array_slice($charts, 4);
?>

<main>
    <section class="charts-section table-wrap px-4 w-100">
        <div class="custom-header text-center mb-4 charts-text select-none">
            <h2>
                <i class="far fa-chart-bar mr-3" aria-hidden="true"></i>
                Grafik Kunjungan Pasien
            </h2>
            <p>Daftar grafik kunjungan pasien pada Poliklinik per tahun</p>
        </div>
        <hr>

        <div class="container-fluid mt-5 mb-3 pb-2">

            <!-- Baris pertama -->
            <div class="row text-center justify-content-center mb-4 flex-row-wrap">
                <?php foreach ($firstRow as $chart) : ?>
                    <div class="chart-col chart-col-4">
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/<?= $chart['link'] ?>', false)" class="card-link">
                            <div class="card interactive-card" style="--card-color: <?= $chart['color'] ?>;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <i class="<?= $chart['icon'] ?>" aria-hidden="true"></i>
                                    <span class="mt-2 select-none"><?= $chart['label'] ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Baris kedua -->
            <div class="row text-center justify-content-center flex-row-wrap">
                <?php foreach ($secondRow as $chart) : ?>
                    <div class="chart-col chart-col-5">
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/<?= $chart['link'] ?>', false)" class="card-link">
                            <div class="card interactive-card" style="--card-color: <?= $chart['color'] ?>;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <i class="<?= $chart['icon'] ?>" aria-hidden="true"></i>
                                    <span class="mt-2 select-none"><?= $chart['label'] ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>
</main>