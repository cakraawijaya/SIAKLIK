<?php

    // ============================ AUTH =============================
    include __DIR__ . '/../../../features/auth/authorization/patient.php';
    
?>

<main>
    <section class="gallery-photo-section" id="gallery-photo">
        <div class="custom-header text-center gallery-foto-text select-none">
            <h2>
                <i class="fa fa-camera-retro mr-1" aria-hidden="true"></i>
                Album Foto Poliklinik
            </h2>
            <p>Potret berbagai kegiatan yang telah dilaksanakan serta fasilitas yang dimiliki oleh Poliklinik UPN Veteran Jatim</p>
        </div>
        <hr>
        <div class="gallery-grid">
            <?php
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

                foreach ($photos as $index => $photo) :
            ?>
            <div class="gallery-item select-none">
                <a onclick="openLink('#', false)">
                    <img src="<?= BASE_URL ?>public/assets/img/gallery/<?= $photo[1] ?>" alt="<?= strtolower(str_replace(' ', '-', $photo[0])) ?>">
                    <div class="overlay">
                        <div class="overlay-text">
                            <h3><?= $photo[0] ?></h3>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="gallery-video-section" id="gallery-video">
        <div class="custom-header text-center gallery-video-text select-none">
            <h2>
                <i class="fa fa-video mr-1" aria-hidden="true"></i>
                Album Video Poliklinik
            </h2>
            <p>Wujud dedikasi dalam memberikan pelayanan kesehatan bermutu bagi Sivitas Akademika dan Masyarakat tersaji melalui cuplikan Video berikut</p>
        </div>
        <div class="content-divider"><hr></div>
        <div class="video-wrapper">
            <div id="gdrive-video"></div>
            <script>
                const Video_ID = '1OTz-z909oK-IRZP884WFaP1aKM2Tn52g';
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