<?php

    // pengecekan otentikasi
    include __DIR__ . '/../features/auth/authorization/patient.php';

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
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/ambulan.jpg" class="d-block w-100" alt="poli ambulance">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Ambulan</h3>
                        <p class="text-light">Layanan Ambulan Siap 24 Jam</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/fasilitas_poli_gigi.jpg" class="d-block w-100" alt="pemeriksaan gigi">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Poli Gigi</h3>
                        <p class="text-light">Pemeriksaan dan Perawatan Gigi Profesional</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/tindakan_keperawatan.jpg" class="d-block w-100" alt="Poli Umum">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Poli Umum</h3>
                        <p class="text-light">Pelayanan Kesehatan Umum dan Keperawatan</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/bakti_sosial.jpg" class="d-block w-100" alt="Bakti Sosial">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Bakti Sosial</h3>
                        <p class="text-light">Kegiatan Sosial untuk Masyarakat</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/donor_darah.jpg" class="d-block w-100" alt="Donor Darah">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Donor Darah</h3>
                        <p class="text-light">Kegiatan Donor Darah Rutin oleh Poliklinik</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/tes_kesehatan.jpg" class="d-block w-100" alt="Tes Kesehatan">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <h3>Tes Kesehatan Poliklinik</h3>
                        <p class="text-light">Pemeriksaan Kesehatan Lengkap</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="4000">
                    <img src="<?= BASE_URL ?>public/assets/img/highlights/khitan_massal.jpg" class="d-block w-100" alt="Khitanan Massal">
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
    <section class="about-section">
        <div class="row d-flex align-items-stretch">
            <div class="calendar-wrapper col-12 col-sm-4 col-md-3 d-flex">
                <div class="calendar w-100 select-none">
                    <p id="namaBulan"></p>

                    <div class="calendar-body d-flex flex-column justify-content-center">
                        <p id="namaHari"></p>
                        <p id="tanggal"></p>
                        <p id="tahun"></p>
                    </div>
                </div>
            </div>

            <!-- Text Column -->
            <div class="about-wrapper col-12 col-sm-8 col-md-9">
                <div class="about-text select-none">
                    <h2>Tentang SIAKLIK</h2><hr>
                    <p class="mt-2">Sistem Pelayanan Klinik Kesehatan (SIAKLIK) merupakan sebuah website yang digunakan untuk pelayanan kesehatan, adapun fungsinya sebagai berikut :</p>
                    <ol class="about-list">
                        <li><span>Memberikan pelayanan kesehatan dalam rangka mendukung program kesehatan preventif, kuratif, dan promotif, meliputi primary health care, family health care, kesehatan kerja, serta pelayanan kesehatan di Poli Umum, Poli Gigi, dan Kamar Obat.</span></li>
                        <li class="mt-3"><span>Melaksanakan administrasi pelayanan poliklinik serta pencatatan rekam medis secara tertib, efisien, dan terintegrasi.</span></li>
                    </ol> 
                </div>
            </div>
        </div>
    </section>

    <section class="article-section">
        <div class="custom-header select-none">
            <div class="text-center align-middle article-text">
                <h2>
                    <i class="fas fa-newspaper" aria-hidden="true"></i>
                    Artikel SIAKLIK
                </h2>
                <p>Artikel dan berita terbaru dari Sistem Pelayanan Klinik Kesehatan (SIAKLIK)</p>
            </div>
        </div>
        <hr>
        <div class="carousel-wrapper position-relative">
            <div class="row">
                <div class="col-12">
                    <!-- === NAVIGATION TETAP DI BAWAH === -->
                    <div class="carousel-controls text-center">
                        <div class="carousel-controls-title select-none">
                            <p class="font-weight-light">Geser untuk memilih artikel</p>
                        </div>
                        <a class="btn btn-success mr-2" onclick="openLink('#carousel-indicators2', false)" 
                        role="button" data-target="#carousel-indicators2" data-slide="prev">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-success" onclick="openLink('#carousel-indicators2', false)" 
                        role="button" data-target="#carousel-indicators2" data-slide="next">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div id="carousel-indicators2" class="carousel carousel-fade" data-ride="carousel">
                        <div class="carousel-content select-none">

                            <!-- === SLIDE 1 === -->
                            <div class="carousel-item active" data-interval="5000">
                                <div class="row d-flex align-items-stretch">
                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="HIV AIDS" src="<?= BASE_URL ?>public/assets/img/articles/hiv_aids.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    HIV / AIDS
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    HIV merupakan singkatan dari Human Immunodeficiency Virus (HIV) merupakan retrovirus
                                                    yang menjangkiti sel-sel sistem kekebalan tubuh manusia. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/hiv.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Stroke" src="<?= BASE_URL ?>public/assets/img/articles/stroke.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    STROKE
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Stroke adalah penyakit atau gangguan fungsional otak akut fokal maupun global akibat
                                                    terhambatnya peredaran darah ke otak. Gangguan peredaran darah. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/stroke.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="TBC" src="<?= BASE_URL ?>public/assets/img/articles/tbc.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    TBC (TUBERCULOSIS)
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Tuberkulosis merupakan infeksi yang disebabkan oleh Mycobacterium tuberculosis yang dapat menyerang
                                                    berbagai organ tubuh mulai dari paru. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/tuberkulosis.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- === SLIDE 2 === -->
                            <div class="carousel-item" data-interval="5000">
                                <div class="row d-flex align-items-stretch">
                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Hepatitis" src="<?= BASE_URL ?>public/assets/img/articles/hepatitis.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    HEPATITIS
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Hepatitis adalah peradangan pada sel hati yang dapat disebabkan oleh infeksi virus, 
                                                    konsumsi alkohol berlebihan, atau obat-obatan tertentu. Penyakit ini. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/hepatitis.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Diare" src="<?= BASE_URL ?>public/assets/img/articles/diare.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    DIARE
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Penyakit diare adalah suatu penyakit yang ditandai dengan perubahan bentuk dan
                                                    konsistensi tinja yang lembek sampai mencair dan bertambahnya frekuensi. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/diare.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Pneumonia" src="<?= BASE_URL ?>public/assets/img/articles/pneumonia.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    PNEUMONIA
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Pneumonia adalah peradangan parenkim paru distal dari bronkiolus terminalis yang mencakup
                                                    bronkiolus respiratorius dan alveoli serta menimbulkan. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/pneumonia.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- === SLIDE 3 === -->
                            <div class="carousel-item" data-interval="5000">
                                <div class="row d-flex align-items-stretch">
                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Difteri" src="<?= BASE_URL ?>public/assets/img/articles/difteri.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    DIFTERI
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Difteri merupakan penyakit infeksi akut yang terutama menyerang tonsil, faring, laring,
                                                    hidung, dan ada kalanya. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/difteri.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="DBD" src="<?= BASE_URL ?>public/assets/img/articles/dbd.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    DBD (DEMAM BERDARAH DENGUE)
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Demam berdarah dengue atau DBD merupakan penyakit arbovirus dari keluarga flavivirus
                                                    yang memiliki empat serotipe. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/dbd.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Kanker" src="<?= BASE_URL ?>public/assets/img/articles/kanker.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    KANKER
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Kanker adalah istilah untuk kondisi di mana sel telah kehilangan pengendalian dan mekanisme
                                                    normalnya sehingga. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/kanker.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- === SLIDE 4 === -->
                            <div class="carousel-item" data-interval="5000">
                                <div class="row d-flex align-items-stretch">
                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Kudis" src="<?= BASE_URL ?>public/assets/img/articles/kudis.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    KUSTA
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Kusta merupakan penyakit infeksi kronis yang disebabkan oleh bakteri Mycobacterium leprae, yang menyerang 
                                                    kulit, saraf tepi, dan selaput lendir. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/kusta.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="Stunting" src="<?= BASE_URL ?>public/assets/img/articles/stunting.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    STUNTING (GIZI BURUK)
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    Stunting (Gizi Buruk) merupakan kondisi gagal tumbuh pada anak akibat kekurangan gizi kronis dalam 
                                                    jangka panjang, terutama pada 1.000 hari pertama kehidupan. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/stunting.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-wrapper col-md-4 d-flex">
                                        <div class="card h-100 flex-fill d-flex flex-column">
                                            <img class="img-fluid" alt="COVID-19" src="<?= BASE_URL ?>public/assets/img/articles/covid19.jpg">
                                            <div class="card-header text-center">
                                                <h5 class="mb-0">
                                                    COVID-19
                                                </h5>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <p class="card-text mb-auto">
                                                    COVID-19 merupakan penyakit menular yang disebabkan oleh virus Corona (SARS-CoV-2), yang menyerang 
                                                    sistem pernapasan dan dapat menimbulkan. . .
                                                </p>
                                            </div>
                                            <div class="card-footer text-center border-0 mt-auto">
                                                <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/covid19.pdf', true)" class="text-success font-weight-bold">
                                                    Baca Selengkapnya<i class="fas fa-external-link-alt ml-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>