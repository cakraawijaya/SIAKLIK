<?php

    // ======================== AUTH & CONFIG ========================
    $require_login = true; // harus login
    include __DIR__ . '/../../features/auth/authorization/admin.php';

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../../config/config.php';

?>

<main>
    <section class="profile-section w-100">
        <!-- <div class="custom-header text-center profile-text select-none">
            <h2>
                <i class="fas fa-user-cog mr-1" aria-hidden="true"></i>
                Profil Pengguna
            </h2>
            <p>Informasi akun dan data pribadi pengguna</p>
        </div><hr> -->

        <div class="uc-wrapper">
            <div class="uc-content">
                <div class="uc-image">
                    <img src="<?= BASE_URL ?>public/assets/img/others/under_construction.png" alt="Under Construction" />    
                </div>
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