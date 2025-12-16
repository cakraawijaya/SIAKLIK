<?php
    // pengecekan otentikasi
    $require_login = true; // harus login
    include __DIR__ . '/../../features/auth/authorization/worker.php';
?>

<main>
    <section class="profile-section px-4 w-100">
        <div class="custom-header text-center profile-text select-none">
            <h2>
                <i class="fas fa-user-cog mr-1" aria-hidden="true"></i>
                Profil Pengguna
            </h2>
            <p>Informasi akun dan data pribadi pengguna</p>
        </div><hr>

        <h4 class="text-center mt-5 pt-5"><i class="fas fa-exclamation-triangle"></i> Sedang Dalam Pengembangan !</h4>
        <p class="text-center">Halaman ini sedang kami siapkan. Silakan kembali lagi nanti.</p>
    </section>
</main>