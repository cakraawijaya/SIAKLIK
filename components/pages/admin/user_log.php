<?php
    // pengecekan otentikasi
    $require_login = true; // harus login
    include __DIR__ . '/../../features/auth/authorization/admin.php';
?>

<main>
    <section class="user-log-section w-100">
        <!-- <div class="custom-header text-center user-log-text select-none">
            <h2>
                <i class="fas fa-folder-open mr-1" aria-hidden="true"></i>
                Catatan Aktivitas Poliklinik
            </h2>
            <p>Riwayat aktivitas dan pelayanan yang ada di Poliklinik</p>
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