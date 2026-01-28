<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    require_once __DIR__ . '/../../../features/auth/authorization/patient.php';


    // ===========================================================================================
    // PDF SETTINGS
    // ===========================================================================================

    // Nama file PDF
    $rujukan_berjenjang_pdf = "rujukan_berjenjang.pdf";

    // Base URL PDF.js viewer
    $viewerUrl = "https://mozilla.github.io/pdf.js/web/viewer.html";

    // Base URL folder PDF di GitHub
    $pdfBaseUrl = "https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/";

    // Full URL PDF
    $rujukan_berjenjang = $pdfBaseUrl . $rujukan_berjenjang_pdf;

?>


<main>

    <!-- =========================================================================================== -->
    <!-- INFORMATION SECTION                                                                         -->
    <!-- =========================================================================================== -->
    <section class="information-section">

        <!-- Header Informasi Pelayanan -->
        <div class="custom-header text-center information-text select-none">
            <h2>
                <i class="fas fa-info-circle mr-1" aria-hidden="true"></i>
                Informasi Pelayanan
            </h2>
            <p>Panduan pendaftaran dan alur pelayanan Pasien Poliklinik secara Offline maupun Online</p>
        </div>

        <!-- Garis pemisah di bawah header -->
        <div class="content-divider"><hr></div>

        <!-- Kontainer -->
        <div class="container">

            <!-- Gambar Alur Pelayanan Poliklinik -->
            <img class="img-fluid rounded select-none" src="<?= BASE_URL ?>public/assets/img/others/alur_poli.png" alt="Alur Poli">

            <!-- Baris untuk menata tampilan agar kolom Offline dan Online sejajar dan rapi -->
            <div class="row g-2 mt-3">

                <!-- ================================= KOLOM: OFFLINE ============================== -->
                <div class="col-md-5 col-left">
                    <div class="card h-100 border-0 shadow-sm card-wrapper">
                        <div class="card-body">
                            <h4 class="text-center text-success select-none">
                                <i class="fas fa-street-view" aria-hidden="true"></i>
                                OFFLINE
                            </h4>

                            <hr> <!-- Garis pemisah di bawah h4 -->

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


                <!-- ================================= KOLOM: ONLINE =============================== -->
                <div class="col-md-6 col-right">
                    <div class="card h-100 border-0 shadow-sm card-wrapper">
                        <div class="card-body">
                            <h4 class="text-center text-primary select-none">
                                <i class="fas fa-globe" aria-hidden="true"></i>
                                ONLINE
                            </h4>

                            <hr> <!-- Garis pemisah di bawah h4 -->

                            <p class="text-justify text-secondary select-none">
                                Pasien dapat <strong>mendaftar secara online dengan langkah yang mudah</strong>. Jika belum memiliki akun, 
                                pasien cukup <strong>membuat akun terlebih dahulu</strong>, lalu <strong>login ke SIAKLIK</strong>. 
                                Setelah berhasil masuk, pilih menu <strong>“Registrasi Antrean”</strong>, lalu tentukan <strong>jenis antrean</strong> 
                                sesuai kebutuhan: <strong>INTERNAL</strong>, <strong>BPJS</strong>, atau <strong>UMUM</strong>. Selanjutnya, pilih 
                                <strong>“Poli/Layanan”</strong> yang diinginkan untuk mendapatkan <strong>kuota antrean</strong>. Setelah proses registrasi selesai, 
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


    <!-- =========================================================================================== -->
    <!-- REFERRAL SECTION                                                                            -->
    <!-- =========================================================================================== -->
    <section class="referral-section">

        <!-- Header Rujukan Berjenjang -->
        <div class="custom-header select-none">
            <div class="text-center align-middle referral-text">
                <h2>
                    <i class="fas fa-ambulance mr-1" aria-hidden="true"></i>
                    Rujukan Berjenjang
                </h2>
                <p>Gambaran umum terkait prosedur rujukan berjenjang dari Faskes Tingkat 1 (Poliklinik) ke Rumah Sakit tujuan terdekat</p>
            </div>
        </div>

        <!-- Garis pemisah di bawah header -->
        <div class="content-divider"><hr></div>

        <!-- Bagian ini membuat isi di dalamnya berada di tengah halaman -->
        <div class="d-flex justify-content-center">

            <!-- Menampilkan file PDF menggunakan PDF.js viewer -->
            <article class="select-none">
                <iframe 
                    src="<?= $viewerUrl ?>?file=<?= urlencode($rujukan_berjenjang) ?>"
                    allowfullscreen>
                </iframe>
            </article>
        </div>

    </section>
</main>