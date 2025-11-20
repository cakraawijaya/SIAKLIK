<?php
    // pengecekan otentikasi
    include __DIR__ . '/../../../features/auth/authorization/patient.php';
?>

<main>
    <!-- Gallery Foto -->
    <section id="gallery-foto" class="mb-5 pb-4">
        <div class="custom-header text-center gallery-foto-text select-none">
            <h2>
                <i class="fa fa-camera-retro mr-1" aria-hidden="true"></i>
                Album Foto Poliklinik
            </h2>
            <p>Potret Kegiatan dan Fasilitas Poliklinik</p>
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

    <!-- Gallery Video -->
    <section id="gallery-video" class="mt-5 pt-4">
        <div class="custom-header text-center gallery-video-text select-none">
            <h2>
                <i class="fa fa-video mr-1" aria-hidden="true"></i>
                Album Video Poliklinik
            </h2>
            <p>Menampilkan Fasilitas dan Kegiatan Poliklinik Secara Visual</p>
        </div>
        <hr>
        <div class="video-wrapper">
            <video controls autoplay>
                <source src="<?= BASE_URL ?>public/assets/video/poliklinik_upn_jatim.mp4" type="video/mp4"/>
            </video>
        </div>
    </section>
</main>