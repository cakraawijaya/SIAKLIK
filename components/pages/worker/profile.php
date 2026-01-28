<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    $require_login = true; // harus login
    $allowed_levels = ['pekerja']; // akses yang diberikan
    require_once __DIR__ . '/../../features/auth/authorization/worker.php';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- PROFILE SECTION                                                                             -->
    <!-- =========================================================================================== -->
    <section class="profile-section w-100">

        <!-- Header profil pengguna -->
        <!-- <div class="custom-header text-center profile-text select-none">
            <h2>
                <i class="fas fa-user-cog mr-1" aria-hidden="true"></i>
                Profil Pengguna
            </h2>
            <p>Informasi akun dan data pribadi pengguna</p>
        </div> -->

        <!-- Garis pemisah di bawah header -->
        <!-- <hr> -->


        <!-- Pembungkus utama -->
        <div class="uc-wrapper">
            <div class="uc-content">

                <!-- Gambar sebagai penanda bahwa halaman belum tersedia -->
                <div class="uc-image">
                    <img src="<?= BASE_URL ?>public/assets/img/others/under_construction.png" alt="Under Construction" />    
                </div>

                <!-- Teks penjelasan kepada pengguna -->
                <div class="uc-text">
                    <h1>
                        <i class="fas fa-exclamation-triangle"></i> Sedang Dalam Pengembangan
                    </h1>
                    <p>Harap bersabar, Halaman ini sedang kami siapkan.</p>
                    <p>Silakan kembali lagi nanti !</p>
                </div>
            </div>
        </div>

    </section>
</main>