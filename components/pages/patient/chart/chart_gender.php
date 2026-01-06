<?php

    // ============================ AUTH =============================
    include __DIR__ . '/../../../features/auth/authorization/patient.php';

?>

<main>
    <section class="charts-section">
        <figure class="highcharts-figure">
            <div class="title text-center charts-text select-none">
                <h2>Kunjungan Pasien Berdasarkan Jenis Kelamin</h2>
                <p>Analisis kunjungan pasien laki-laki dan perempuan di poliklinik</p>
            </div><hr>
            <div id="container"></div>
        </figure>
    </section>
</main>