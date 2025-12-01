<?php

    // pengecekan otentikasi
    include __DIR__ . '/../../../features/auth/authorization/patient.php';

    // nama file PDF
    $rujukan_berjenjang_pdf = "rujukan_berjenjang.pdf";

    // base URL PDF.js viewer
    $viewerUrl = "https://mozilla.github.io/pdf.js/web/viewer.html";

    // base URL folder PDF di GitHub
    $pdfBaseUrl = "https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/";

    // full URL PDF
    $rujukan_berjenjang = $pdfBaseUrl . $rujukan_berjenjang_pdf;

?>

<main>
    <section class="information-section">
        <div class="custom-header text-center information-text select-none">
            <h2>
                <i class="fas fa-procedures mr-1" aria-hidden="true"></i>
                Informasi Pelayanan Poliklinik
            </h2>
            <p>Panduan pendaftaran dan alur pelayanan Pasien Poliklinik secara Offline maupun Online</p>
        </div>
        <div class="content-divider"><hr></div>
        <div class="container">
            <img class="img-fluid rounded select-none" src="<?= BASE_URL ?>public/assets/img/others/alur_poli.png" alt="Alur Poli">
            <div class="row g-2 mt-3">

                <!-- Kolom Kiri: Offline -->
                <div class="col-md-5 col-left">
                    <div class="card h-100 border-0 shadow-sm card-wrapper">
                        <div class="card-body">
                            <h4 class="text-center text-success select-none">
                                <i class="fas fa-street-view" aria-hidden="true"></i>
                                OFFLINE
                            </h4><hr>
                            <p class="text-justify text-secondary select-none">
                                Pasien bisa datang langsung ke bagian pendaftaran yang ada di <strong>Poliklinik UPN “Veteran” 
                                Jawa Timur</strong>. Petugas akan membantu melakukan verifikasi data, dan proses ini <strong>
                                tidak dipungut biaya apa pun</strong>. Setelah selesai mendaftar, pasien dipersilakan 
                                <strong>menunggu di ruang tunggu</strong>. Nanti, petugas akan <strong>memanggil 
                                pasien sesuai dengan nomor antrean</strong>. Khusus untuk <strong>Pasien Eksternal</strong> 
                                (pasien yang <strong>bukan civitas akademika UPN “Veteran” Jawa Timur</strong>), akan 
                                dikenakan <strong>biaya sesuai dengan jenis tindakan dan pengobatan yang diberikan</strong>. 
                                Seluruh proses dilakukan dengan ramah, mudah, dan terbuka untuk semua pasien, termasuk 
                                penyandang disabilitas.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Online -->
                <div class="col-md-6 col-right">
                    <div class="card h-100 border-0 shadow-sm card-wrapper">
                        <div class="card-body">
                            <h4 class="text-center text-primary select-none">
                              <i class="fas fa-globe" aria-hidden="true"></i>
                              ONLINE
                            </h4><hr>
                            <p class="text-justify text-secondary select-none">
                                Pasien dapat <strong>mendaftar secara online dengan langkah yang mudah</strong>. Jika belum memiliki akun, 
                                pasien cukup <strong>membuat akun terlebih dahulu</strong>, lalu <strong>login ke SIAKLIK</strong>. 
                                Setelah berhasil masuk, pilih menu <strong>“Registrasi Antrean Poliklinik”</strong>, lalu tentukan <strong>jenis antrean</strong> 
                                sesuai kebutuhan: <strong>INTERNAL</strong>, <strong>BPJS</strong>, atau <strong>UMUM</strong>. Selanjutnya, pilih 
                                <strong>Poli/Layanan</strong> yang diinginkan untuk mendapatkan <strong>kuota antrean</strong>. Setelah proses registrasi selesai, 
                                pasien perlu datang ke <strong>Poliklinik</strong> untuk <strong>verifikasi data</strong>, kemudian menunggu di ruang tunggu 
                                hingga <strong>nomor antrean dipanggil</strong>. Seluruh proses <strong>pendaftaran dan verifikasi gratis</strong>, mudah diikuti, 
                                serta tersedia <strong>bantuan bagi pasien penyandang disabilitas</strong>, seperti <strong>penerjemah bahasa isyarat</strong> atau 
                                <strong>pendamping dari petugas Poliklinik</strong>. Khusus untuk <strong>Pasien Eksternal</strong> (pasien yang <strong>bukan 
                                civitas akademika UPN “Veteran” Jawa Timur</strong>), akan dikenakan <strong>biaya sesuai dengan jenis tindakan dan pengobatan 
                                yang diberikan</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="referral-section">
        <div class="custom-header select-none">
            <div class="text-center align-middle referral-text">
                <h2>
                    <i class="fas fa-ambulance mr-1" aria-hidden="true"></i>
                    Rujukan Medis Berjenjang
                </h2>
                <p>Gambaran umum terkait prosedur rujukan berjenjang dari Faskes Tingkat 1 (Poliklinik) ke Rumah Sakit tujuan terdekat (berada di wilayah Surabaya)</p>
            </div>
        </div>
        <div class="content-divider"><hr></div>
        <div class="d-flex justify-content-center">
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($rujukan_berjenjang) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>
    </section>
</main>