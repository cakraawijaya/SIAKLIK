<?php

    // pengecekan otentikasi
    include __DIR__ . '/../../../features/patient_auth_check.php';

?>

<main>
    <section class="information-section pb-5">
        <div class="custom-header text-center mb-4 information-text select-none">
            <h2>
                <i class="fas fa-procedures me-2" aria-hidden="true"></i>
                Informasi Pelayanan Pasien
            </h2>
            <p>Panduan pendaftaran dan alur pelayanan pasien secara offline maupun online</p>
        </div><hr>
        <div class="container mt-5">
            <div class="text-center mb-4">
                <img class="img-fluid rounded select-none" src="<?= BASE_URL ?>public/assets/img/others/alur_poli.png" alt="Alur Poli">
            </div>
            <div class="row g-4 mt-4">

                <!-- Kolom Kiri: Offline -->
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm card-wrapper">
                        <div class="card-body p-4">
                            <h4 class="text-center text-success select-none">
                                <i class="fas fa-street-view" aria-hidden="true"></i>
                                OFFLINE
                            </h4><hr>
                            <p class="text-justify text-secondary mt-4 mb-0 select-none">
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
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm card-wrapper">
                        <div class="card-body p-4">
                            <h4 class="text-center text-primary select-none">
                              <i class="fas fa-globe" aria-hidden="true"></i>
                              ONLINE
                            </h4><hr>
                            <p class="text-justify text-secondary mt-4 mb-0 select-none">
                                Pasien dapat <strong>mendaftar secara online dengan langkah yang mudah</strong>. Jika belum memiliki akun, 
                                pasien cukup <strong>membuat akun terlebih dahulu</strong>, lalu <strong>login ke SIAKLIK</strong>. 
                                Setelah berhasil masuk, pilih menu <strong>“Registrasi Antrean Klinik”</strong>, lalu tentukan <strong>jenis antrean</strong> 
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

    <section class="referral-section mt-5 pt-4">
        <div class="custom-header select-none">
            <div class="text-center align-middle referral-text">
                <h2>
                    <i class="fas fa-ambulance" aria-hidden="true"></i>
                    Rujukan Berjenjang Ke Rumah Sakit
                </h2>
                <p>Pahami alur rujukan pelayanan kesehatan dari faskes tingkat pertama hingga rumah sakit rujukan<p>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <article id="1" class="select-none">
                <iframe src="https://drive.google.com/file/d/1hM6Ln3phLD5pF5_37BLNv7Xo2rnz9duI/preview" width="670" height="800"></iframe>
            </article>
        </div>
    </section>
</main>