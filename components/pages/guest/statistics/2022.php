<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    require_once __DIR__ . '/../../../features/auth/authorization/patient.php';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- CHARTS SECTION                                                                              -->
    <!-- =========================================================================================== -->
    <section class="charts-section">

        <!-- Pembungkus grafik -->
        <figure class="highcharts-figure">

            <!-- Judul dan Subjudul grafik -->
            <div class="title text-center charts-text select-none">
                <h2>Kunjungan Pasien Berdasarkan Satker Tahun 2022</h2>
                <p>Analisis kunjungan pasien di poliklinik sepanjang tahun 2022</p>
            </div>

            <hr> <!-- Garis pemisah di antara judul dan tampilan grafik -->

            <!-- Bagian ini adalah tempat grafik akan ditampilkan -->
            <div id="container"></div>
        </figure>
    </section>

</main>