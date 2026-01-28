<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    require_once __DIR__ . '/../../../features/auth/authorization/patient.php';


    // ===========================================================================================
    // PDF SETTINGS
    // ===========================================================================================

    // Nama file PDF
    $poli_umum_pdf = "poli_umum.pdf";
    $poli_gigi_pdf = "poli_gigi.pdf";
    $laboratorium_sederhana_pdf = "laboratorium_sederhana.pdf";

    // Base URL PDF.js viewer
    $viewerUrl = "https://mozilla.github.io/pdf.js/web/viewer.html";

    // Base URL folder PDF di GitHub
    $pdfBaseUrl = "https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/";

    // Full URL PDF
    $poli_umum = $pdfBaseUrl . $poli_umum_pdf;
    $poli_gigi = $pdfBaseUrl . $poli_gigi_pdf;
    $laboratorium_sederhana = $pdfBaseUrl . $laboratorium_sederhana_pdf;

?>


<header>

    <!-- =========================================================================================== -->
    <!-- CAROUSEL SECTION                                                                            -->
    <!-- =========================================================================================== -->
    <section class="carousel-wrapper">

        <!-- Carousel header untuk menampilkan highlight layanan & kegiatan poliklinik -->
        <div id="carousel-captions" class="carousel carousel-fade" data-ride="carousel">

            <!-- Indikator titik navigasi carousel header -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-captions" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-captions" data-slide-to="1"></li>
                <li data-target="#carousel-captions" data-slide-to="2"></li>
                <li data-target="#carousel-captions" data-slide-to="3"></li>
                <li data-target="#carousel-captions" data-slide-to="4"></li>
                <li data-target="#carousel-captions" data-slide-to="5"></li>
                <li data-target="#carousel-captions" data-slide-to="6"></li>
            </ol>

            <!-- Konten slide carousel header -->
            <div class="carousel-content select-none">

                <!-- =========================== SLIDE 1: LAYANAN AMBULAN ========================== -->
                <div class="carousel-item active" data-interval="4000">

                    <!-- Gambar Slide 1 -->
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/ambulan.jpg" class="d-block w-100" alt="poli ambulance">

                    <!-- Judul dan Subjudul Slide 1 -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Ambulan</h3>
                        <p class="text-light">Layanan Ambulan Siap 24 Jam</p>
                    </div>
                </div>


                <!-- ============================== SLIDE 2: POLI GIGI ============================= -->
                <div class="carousel-item" data-interval="4000">

                    <!-- Gambar Slide 2 -->
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/fasilitas_poli_gigi.jpg" class="d-block w-100" alt="pemeriksaan gigi">

                    <!-- Judul dan Subjudul Slide 2 -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Poli Gigi</h3>
                        <p class="text-light">Pemeriksaan dan Perawatan Gigi Profesional</p>
                    </div>
                </div>


                <!-- ============================== SLIDE 3: POLI UMUM ============================= -->
                <div class="carousel-item" data-interval="4000">

                    <!-- Gambar Slide 3 -->
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/tindakan_keperawatan.jpg" class="d-block w-100" alt="Poli Umum">

                    <!-- Judul dan Subjudul Slide 3 -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Poli Umum</h3>
                        <p class="text-light">Pelayanan Kesehatan Umum dan Keperawatan</p>
                    </div>
                </div>


                <!-- ============================ SLIDE 4: BAKTI SOSIAL ============================ -->
                <div class="carousel-item" data-interval="4000">

                    <!-- Gambar Slide 4 -->
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/bakti_sosial.jpg" class="d-block w-100" alt="Bakti Sosial">

                    <!-- Judul dan Subjudul Slide 4 -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Bakti Sosial</h3>
                        <p class="text-light">Kegiatan Sosial untuk Masyarakat</p>
                    </div>
                </div>


                <!-- ============================ SLIDE 5: DONOR DARAH ============================= -->
                <div class="carousel-item" data-interval="4000">

                    <!-- Gambar Slide 5 -->
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/donor_darah.jpg" class="d-block w-100" alt="Donor Darah">

                    <!-- Judul dan Subjudul Slide 5 -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Donor Darah</h3>
                        <p class="text-light">Kegiatan Donor Darah Rutin oleh Poliklinik</p>
                    </div>
                </div>


                <!-- ===================== SLIDE 6: TES KESEHATAN POLIKLINIK ======================= -->
                <div class="carousel-item" data-interval="4000">

                    <!-- Gambar Slide 6 -->
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/tes_kesehatan.jpg" class="d-block w-100" alt="Tes Kesehatan">

                    <!-- Judul dan Subjudul Slide 6 -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Tes Kesehatan Poliklinik</h3>
                        <p class="text-light">Pemeriksaan Kesehatan Lengkap</p>
                    </div>
                </div>


                <!-- ========================== SLIDE 7: KHITANAN MASSAL =========================== -->
                <div class="carousel-item" data-interval="4000">

                    <!-- Gambar Slide 7 -->
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/khitan_massal.jpg" class="d-block w-100" alt="Khitanan Massal">

                    <!-- Judul dan Subjudul Slide 7 -->
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Khitanan Massal</h3>
                        <p class="text-light">Program Khitanan Massal Aman dan Terjangkau untuk Seluruh Lapisan Masyarakat yang membutuhkan</p>
                    </div>
                </div>
            </div>

            <!-- Tombol navigasi kiri & kanan carousel header -->
            <a class="carousel-control-prev" onclick="openLink('#carousel-captions', false)" 
            role="button" data-target="#carousel-captions" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" onclick="openLink('#carousel-captions', false)" 
            role="button" data-target="#carousel-captions" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
</header>


<main>

    <!-- =========================================================================================== -->
    <!-- GENERAL UNIT SECTION                                                                        -->
    <!-- =========================================================================================== -->
    <section class="general-unit-section">

        <!-- Header poli umum -->
        <div class="custom-header select-none">
            <div class="text-center align-middle general-unit-text">
                <h2>
                    <i class="fas fa-clinic-medical" aria-hidden="true"></i>
                    Poli Umum
                </h2>
                <p>Pemeriksaan dan Konsultasi, serta Pengobatan Umum untuk Semua Usia<p>
            </div>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Bagian ini membuat isi di dalamnya berada di tengah halaman -->
        <div class="d-flex justify-content-center">

            <!-- Menampilkan file PDF menggunakan PDF.js viewer -->
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($poli_umum) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>
    </section>


    <!-- =========================================================================================== -->
    <!-- DENTAL UNIT SECTION                                                                         -->
    <!-- =========================================================================================== -->
    <section class="dental-unit-section">

        <!-- Header poli gigi -->
        <div class="custom-header select-none">
            <div class="text-center align-middle dental-unit-text">
                <h2>
                    <i class="fas fa-tooth" aria-hidden="true"></i>
                    Poli Gigi
                </h2>
                <p>Pemeriksaan, Konsultasi, dan Perawatan Gigi Profesional untuk Semua Usia<p>
            </div>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Bagian ini membuat isi di dalamnya berada di tengah halaman -->
        <div class="d-flex justify-content-center">

            <!-- Menampilkan file PDF menggunakan PDF.js viewer -->
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($poli_gigi) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>
    </section>


    <!-- =========================================================================================== -->
    <!-- CLINIC LAB SECTION                                                                          -->
    <!-- =========================================================================================== -->
    <section class="clinic-lab-section">

        <!-- Header laboratorium -->
        <div class="custom-header select-none">
            <div class="text-center align-middle clinic-lab-text">
                <h2>
                    <i class="fas fa-microscope" aria-hidden="true"></i>
                    Laboratorium
                </h2>
                <p>Tingkatkan Kewaspadaan Kesehatan Sejak Dini melalui Tes GDA, Kolesterol, dan Asam Urat Terpadu<p>
            </div>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Bagian ini membuat isi di dalamnya berada di tengah halaman -->
        <div class="d-flex justify-content-center">

            <!-- Menampilkan file PDF menggunakan PDF.js viewer -->
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($laboratorium_sederhana) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>
    </section>
</main>