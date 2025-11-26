<?php

    // pengecekan otentikasi
    include __DIR__ . '/../../../features/auth/authorization/patient.php';

    // nama file PDF
    $poli_umum_pdf = "poli_umum.pdf";
    $poli_gigi_pdf = "poli_gigi.pdf";
    $laboratorium_sederhana_pdf = "laboratorium_sederhana.pdf";

    // base URL PDF.js viewer
    $viewerUrl = "https://mozilla.github.io/pdf.js/web/viewer.html";

    // base URL folder PDF di GitHub
    $pdfBaseUrl = "https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/";

    // full URL PDF
    $poli_umum = $pdfBaseUrl . $poli_umum_pdf;
    $poli_gigi = $pdfBaseUrl . $poli_gigi_pdf;
    $laboratorium_sederhana = $pdfBaseUrl . $laboratorium_sederhana_pdf;

?>

<header>
    <section class="carousel-wrapper">
        <div id="carousel-captions" class="carousel carousel-fade" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-captions" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-captions" data-slide-to="1"></li>
                <li data-target="#carousel-captions" data-slide-to="2"></li>
                <li data-target="#carousel-captions" data-slide-to="3"></li>
                <li data-target="#carousel-captions" data-slide-to="4"></li>
                <li data-target="#carousel-captions" data-slide-to="5"></li>
                <li data-target="#carousel-captions" data-slide-to="6"></li>
            </ol>

            <!-- Slides -->
            <div class="carousel-content select-none">
                <div class="carousel-item active" data-interval="4000">
                    <img height="380" src="<?= BASE_URL ?>public/assets/img/highlights/ambulan.jpg" class="d-block w-100" alt="poli ambulance">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Ambulan</h3>
                        <p class="text-light">Layanan Ambulan Siap 24 Jam</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img height="380" src="<?= BASE_URL ?>public/assets/img/highlights/fasilitas_poli_gigi.jpg" class="d-block w-100" alt="pemeriksaan gigi">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Poli Gigi</h3>
                        <p class="text-light">Pemeriksaan dan Perawatan Gigi Profesional</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img height="380" src="<?= BASE_URL ?>public/assets/img/highlights/tindakan_keperawatan.jpg" class="d-block w-100" alt="Poli Umum">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Poli Umum</h3>
                        <p class="text-light">Pelayanan Kesehatan Umum dan Keperawatan</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img height="380" src="<?= BASE_URL ?>public/assets/img/highlights/bakti_sosial.jpg" class="d-block w-100" alt="Bakti Sosial">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Bakti Sosial</h3>
                        <p class="text-light">Kegiatan Sosial untuk Masyarakat</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img height="380" src="<?= BASE_URL ?>public/assets/img/highlights/donor_darah.jpg" class="d-block w-100" alt="Donor Darah">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Donor Darah</h3>
                        <p class="text-light">Kegiatan Donor Darah Rutin oleh Poliklinik</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img height="380" src="<?= BASE_URL ?>public/assets/img/highlights/tes_kesehatan.jpg" class="d-block w-100" alt="Tes Kesehatan">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Tes Kesehatan Poliklinik</h3>
                        <p class="text-light">Pemeriksaan Kesehatan Lengkap</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img height="380" src="<?= BASE_URL ?>public/assets/img/highlights/khitan_massal.jpg" class="d-block w-100" alt="Khitanan Massal">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Khitanan Massal</h3>
                        <p class="text-light">Program Khitanan Massal Aman dan Terjangkau untuk Seluruh Lapisan Masyarakat yang membutuhkan</p>
                    </div>
                </div>
            </div>

            <!-- Controls -->
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
    <section class="general-unit-section">
        <div class="custom-header select-none">
            <div class="text-center align-middle general-unit-text">
                <h2>
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    Poli Umum
                </h2>
                <p>Pemeriksaan dan Konsultasi, serta Pengobatan Umum untuk Semua Usia<p>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($poli_umum) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>
    </section>

    <section class="dental-unit-section">
        <div class="custom-header select-none">
            <div class="text-center align-middle dental-unit-text">
                <h2>
                    <i class="fas fa-tooth" aria-hidden="true"></i>
                    Poli Gigi
                </h2>
                <p>Pemeriksaan, Konsultasi, dan Perawatan Gigi Profesional untuk Semua Usia<p>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($poli_gigi) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>
    </section>

    <section class="clinic-lab-section">
        <div class="custom-header select-none">
            <div class="text-center align-middle clinic-lab-text">
                <h2>
                    <i class="fas fa-flask" aria-hidden="true"></i>
                    Laboratorium
                </h2>
                <p>Tingkatkan Kewaspadaan Kesehatan Sejak Dini melalui Tes GDA, Kolesterol, dan Asam Urat Terpadu<p>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($laboratorium_sederhana) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>
    </section>
</main>