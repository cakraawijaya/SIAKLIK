<?php

    include __DIR__ . '/../../../features/auth/authorization/patient.php';

    $charts_data = [
        ['color' => '#639c1f', 'label' => 'Jenis Kelamin', 'icon' => 'fas fa-procedures', 'link' => 'chart_gender'],
        ['color' => '#24252d', 'label' => 'Satker 2013', 'icon' => 'fas fa-procedures', 'link' => 'chart_2013'],
        ['color' => '#639c1f', 'label' => 'Satker 2014', 'icon' => 'fas fa-procedures', 'link' => 'chart_2014'],
        ['color' => '#24252d', 'label' => 'Satker 2015', 'icon' => 'fas fa-procedures', 'link' => 'chart_2015'],
        ['color' => '#639c1f', 'label' => 'Satker 2016', 'icon' => 'fas fa-procedures', 'link' => 'chart_2016'],
        ['color' => '#24252d', 'label' => 'Satker 2017', 'icon' => 'fas fa-procedures', 'link' => 'chart_2017'],
        ['color' => '#639c1f', 'label' => 'Satker 2018', 'icon' => 'fas fa-procedures', 'link' => 'chart_2018'],
        ['color' => '#24252d', 'label' => 'Satker 2019', 'icon' => 'fas fa-procedures', 'link' => 'chart_2019'],
        ['color' => '#639c1f', 'label' => 'Satker 2020', 'icon' => 'fas fa-procedures', 'link' => 'chart_2020'],
        ['color' => '#24252d', 'label' => 'Satker 2021', 'icon' => 'fas fa-procedures', 'link' => 'chart_2021'],
        ['color' => '#639c1f', 'label' => 'Satker 2022', 'icon' => 'fas fa-procedures', 'link' => 'chart_2022']
    ];

?>

<main>
    <section class="charts-section">
        <div class="custom-header text-center charts-text select-none">
            <h2>
                <i class="fas fa-chart-line" aria-hidden="true"></i>
                Grafik Kunjungan Pasien
            </h2>
            <p>Daftar grafik kunjungan pasien pada Poliklinik per tahun</p>
        </div>
        <hr>
        <div class="charts-grid-container">

            <?php foreach ($charts_data as $charts) : ?>
                <div class="chart-grid">
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/<?= $charts['link'] ?>', false)" class="card-link">
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