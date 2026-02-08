<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    require_once __DIR__ . '/../../../features/auth/authorization/patient.php';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- GALLERY PHOTO SECTION                                                                       -->
    <!-- =========================================================================================== -->
    <section class="gallery-photo-section" id="gallery-photo">

        <!-- Header Album Foto Poliklinik -->
        <div class="custom-header text-center gallery-foto-text select-none">
            <h2>
                <i class="fa fa-camera-retro mr-1" aria-hidden="true"></i>
                Album Foto Poliklinik
            </h2>
            <p>Potret berbagai kegiatan yang telah dilaksanakan serta fasilitas yang dimiliki oleh Poliklinik UPN Veteran Jatim</p>
        </div>

        <!-- Garis pemisah di bawah header -->
        <div class="content-divider"><hr></div>

        <!-- Pembungkus foto dalam bentuk grid -->
        <div class="gallery-grid">

            <?php
                // Daftar foto yang akan ditampilkan (judul dan nama file)
                $photos = [
                    ['Bakti Sosial', 'bakti_sosial.jpg'],
                    ['Pengabdian Masyarakat', 'pengabdian_masyarakat.jpg'],
                    ['Khitan', 'khitan.jpg'],
                    ['Ruang Utama', 'ruang_utama.jpg'],
                    ['Poli Umum', 'poli_umum.jpg'],
                    ['Ruang Obat', 'ruang_obat.jpg'],
                    ['Poli Gigi', 'poli_gigi.jpg'],
                    ['Ambulan', 'ambulan.jpg'],
                    ['Alat Medis', 'alat_medis.jpg'],
                    ['Penanganan Poli Gigi', 'penanganan_poli_gigi.jpg'],
                    ['Ruang Tindakan', 'ruang_tindakan.jpg'],
                    ['Ruang Tenaga Medis', 'ruang_tenaga_medis.jpg']
                ];

                // Loop untuk menampilkan setiap foto
                foreach ($photos as $index => $photo) :
            ?>

            <!-- Item foto dalam galeri -->
            <div class="gallery-item select-none">

                <!-- Setiap foto bisa diklik -->
                <a onclick="openLink('#', false)">

                    <!-- Gambar -->
                    <img src="<?= BASE_URL ?>public/assets/img/gallery/<?= $photo[1] ?>" alt="<?= strtolower(str_replace(' ', '-', $photo[0])) ?>">

                    <!-- Efek overlay saat foto disentuh atau diarahkan -->
                    <div class="overlay">
                        <div class="overlay-text">
                            <h3><?= $photo[0] ?></h3>
                        </div>
                    </div>

                </a>
            </div>

            <?php
                endforeach;
            ?>

        </div>
    </section>


    <!-- =========================================================================================== -->
    <!-- GALLERY VIDEO SECTION                                                                       -->
    <!-- =========================================================================================== -->
    <section class="gallery-video-section" id="gallery-video">

        <!-- Header Album Video Poliklinik -->
        <div class="custom-header text-center gallery-video-text select-none">
            <h2>
                <i class="fa fa-video mr-1" aria-hidden="true"></i>
                Album Video Poliklinik
            </h2>
            <p>Wujud dedikasi dalam memberikan pelayanan kesehatan bermutu bagi Sivitas Akademika dan Masyarakat tersaji melalui cuplikan Video berikut</p>
        </div>

        <!-- Garis pemisah di bawah header -->
        <div class="content-divider"><hr></div>

        <!-- Pembungkus tampilan video -->
        <div class="video-wrapper">

            <!-- Bagian ini adalah tempat video Google Drive akan dimuat -->
            <div id="gdrive-video"></div>

            <script>
                // ID video Google Drive yang akan ditampilkan
                const Video_ID = '1OTz-z909oK-IRZP884WFaP1aKM2Tn52g';

                // Menampilkan video Google Drive ke dalam halaman
                document.getElementById('gdrive-video').innerHTML = `
                    <iframe
                        src="https://drive.google.com/file/d/${Video_ID}/preview"
                        allow="fullscreen"
                        allowfullscreen
                        frameborder="0"
                    ></iframe>
                `;
            </script>

        </div>
    </section>

</main>