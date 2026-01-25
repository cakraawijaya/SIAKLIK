<!-- 
===========================================================================================
Pesan ada, maka :
Tentukan isi alert dan aksi lanjutannya berdasarkan parameter "pesan" dan "modal"
===========================================================================================
-->

<?php
    // Jika ada parameter "pesan" di URL, maka :
    if (isset($_GET['pesan'])):
?>


    <?php

        // Ambil nilai "pesan" dari URL
        $pesan = $_GET['pesan'];

        // Ambil parameter "modal" jika ada
        // Default: "pasien" jika tidak ada
        $modal = isset($_GET['modal']) ? $_GET['modal'] : 'pasien';

        $alertMessage = ""; // Inisialisasi variabel untuk Judul pesan
        $subtitle = ""; // Inisialisasi variabel untuk Subjudul pesan

        // Bagian ini mengatur Judul pesan berdasarkan kode "pesan"
        switch ($pesan) {
            case "akses_terbatas": $alertMessage = "Hak akses terbatas!"; break;
            case "gagal": $alertMessage = "Captcha salah!"; break;
            case "email_salah": $alertMessage = "Email tidak ditemukan!"; break;
            case "password_salah": $alertMessage = "Password salah!"; break;
            case "belum_login": $alertMessage = "Mohon masuk terlebih dahulu!"; break;
            case "error": $alertMessage = "Akses ditolak!"; break;
            case "registration_sukses": $alertMessage = "Pendaftaran akun berhasil!"; break;
            case "login_sukses": $alertMessage = "Anda berhasil login!"; break;
            case "logout": $alertMessage = "Anda telah logout!"; break;
            case "timeout": $alertMessage = "Waktu Sesi Habis!"; break;
            case "auto_timeout": $alertMessage = "Waktu Sesi Habis!"; break;
            case "email_terdaftar": $alertMessage = "Email sudah terdaftar!"; break;
            case "username_terdaftar": $alertMessage = "Username sudah terdaftar!"; break;
            case "password_tidak_sesuai": $alertMessage = "Password tidak sesuai!"; break;
            case 'password_singkat': $alertMessage = 'Password terlalu singkat!'; break;
            case 'password_lemah': $alertMessage = 'Password kurang kuat!'; break;
            case "reset_terkirim": $alertMessage = "Link reset password dikirim!"; break;
            case "gagal_email": $alertMessage = "Gagal mengirim email!"; break;
            case "token_invalid": $alertMessage = "Token invalid atau kadaluarsa!"; break;
            case "password_sudah_ada": $alertMessage = "Password sudah terpakai!"; break;
            case "reset_sukses": $alertMessage = "Password berhasil direset!"; break;
            case "deleted": $alertMessage = "Akun Anda Dihapus!"; break;
            case "auto_deleted": $alertMessage = "Akun Anda Dihapus!"; break;
        }

        // Bagian ini mengatur Subjudul pesan berdasarkan kode "pesan"
        switch($pesan){
            case "akses_terbatas": $subtitle = "Fitur ini hanya bisa diakses oleh admin."; break;
            case 'gagal': $subtitle = 'Silakan coba lagi.'; break;
            case 'email_salah': $subtitle = 'Periksa kembali email Anda. Pastikan email sudah pernah Anda daftarkan di SIAKLIK.'; break;
            case 'password_salah': $subtitle = 'Gunakan password yang benar.'; break;
            case 'belum_login': $subtitle = 'Login untuk melanjutkan.'; break;
            case 'error': $subtitle = 'Anda tidak memiliki akses ke halaman ini.'; break;
            case 'registration_sukses': $subtitle = 'Silakan login untuk masuk.'; break;
            case 'login_sukses': $subtitle = 'Selamat datang kembali.'; break;
            case 'logout': $subtitle = 'Sampai jumpa lagi.'; break;
            case 'timeout': $subtitle = 'Silakan login kembali.'; break;
            case 'auto_timeout': $subtitle = 'Silakan login kembali.'; break;
            case 'email_terdaftar': $subtitle = 'Email tidak boleh sama.'; break;
            case 'username_terdaftar': $subtitle = 'Username tidak boleh sama.'; break;
            case 'password_tidak_sesuai': $subtitle = 'Pastikan kedua password sama.'; break;
            case 'password_singkat': $subtitle = 'Password harus minimal 8 karakter.'; break;
            case 'password_lemah': $subtitle = 'Password harus mengandung minimal 1 karakter khusus (!@#$%^&* dll).'; break;
            case "reset_terkirim": $subtitle = "Silakan cek email Anda."; break;
            case "gagal_email": $subtitle = isset($_GET['subtitle']) ? urldecode($_GET['subtitle']) : "Terjadi kesalahan."; break;
            case "token_invalid": $subtitle = "Silakan minta link reset password baru."; break;
            case "password_sudah_ada": $subtitle = "Gunakan password terbaru agar reset berhasil."; break;
            case "reset_sukses": $subtitle = "Sekarang Anda bisa login dengan password baru."; break;
            case "deleted": $subtitle = "Anda telah melanggar ketentuan yang berlaku."; break;
            case "auto_deleted": $subtitle = "Anda telah melanggar ketentuan yang berlaku."; break;
        }

        // Daftar pesan sukses
        $successMessages = ['login_sukses', 'registration_sukses', 'reset_terkirim', 'reset_sukses'];

        $iconType = in_array($pesan, $successMessages) ? 'success' : 'error';     // Jenis ikon Swal
        $iconColor = in_array($pesan, $successMessages) ? '#28a745' : '#dc3545';  // Warna ikon Swal

    ?>


    <script>
        // Jalankan kode setelah DOM (struktur HTML) siap
        $(document).ready(function() {

            // Delay beberapa saat
            setTimeout(function() {

                const specialAlerts = ['auto_timeout', 'auto_deleted']; // Pesan khusus

                // Cek apakah pesan termasuk special
                const isSpecial = specialAlerts.includes("<?= $pesan ?>");

                // Cek logout sebelumnya
                const userJustLoggedOut = sessionStorage.getItem("userLoggedOut") === "true";

                // Jika pesan termasuk special dan user baru logout, maka :
                if (isSpecial && userJustLoggedOut) {

                    // Tampilkan alert
                    Swal.fire({
                        icon: "<?= $iconType ?>",                   // Ikon sukses atau error
                        title: <?= json_encode($alertMessage) ?>,   // Judul alert
                        html: <?= json_encode($subtitle) ?>,        // Subjudul alert
                        timer: 5000,                                // Waktu alert: 5 detik
                        timerProgressBar: true,                     // Tampilkan progress bar
                        showConfirmButton: false,                   // Tidak ada tombol confirm
                        customClass: { popup: 'swal2-card' },       // Class khusus styling
                        buttonsStyling: false,                      // Mematikan style bawaan plugin
                        allowOutsideClick: false,                   // Tidak bisa klik di luar
                        allowEscapeKey: false,                      // Tidak bisa ESC
                        iconColor: "<?= $iconColor ?>"              // Warna ikon

                    }).then(() => {

                        // Hapus flag logout
                        sessionStorage.removeItem('userLoggedOut');

                        // Hapus parameter "pesan" dan "modal" dari URL tanpa me-refresh halaman
                        const url = new URL(window.location);
                        url.searchParams.delete('pesan');
                        url.searchParams.delete('modal');
                        window.history.replaceState({}, document.title, url);

                        // Redirect ke halaman beranda
                        window.location.replace("<?= BASE_URL ?>");
                    });
                }

                // Jika tidak termasuk special dan pesan ada, maka :
                else if (!isSpecial && "<?= $alertMessage ?>" !== "") {

                    // Tampilkan alert
                    Swal.fire({
                        icon: "<?= $iconType ?>",                   // Ikon sukses atau error
                        title: <?= json_encode($alertMessage) ?>,   // Judul alert
                        html: <?= json_encode($subtitle) ?>,        // Subjudul alert
                        timer: 5000,                                // Waktu alert: 5 detik
                        timerProgressBar: true,                     // Tampilkan progress bar
                        showConfirmButton: false,                   // Tidak ada tombol confirm
                        customClass: { popup: 'swal2-card' },       // Class khusus styling
                        buttonsStyling: false,                      // Mematikan style bawaan plugin
                        allowOutsideClick: false,                   // Tidak bisa klik di luar
                        allowEscapeKey: false,                      // Tidak bisa ESC
                        iconColor: "<?= $iconColor ?>"              // Warna ikon

                    }).then(() => {

                        // Hapus flag logout
                        sessionStorage.removeItem('userLoggedOut');

                        // Hapus parameter "pesan" dan "modal" dari URL tanpa me-refresh halaman
                        const url = new URL(window.location);
                        url.searchParams.delete('pesan');
                        url.searchParams.delete('modal');
                        window.history.replaceState({}, document.title, url);

                        // Jika pesan yang diterima itu "login_sukses", maka :
                        <?php if ($pesan == 'login_sukses'): ?>

                            // Cek modal apakah sama dengan "pasien", jika iya maka :
                            <?php if ($modal == 'pasien'): ?>

                                // Redirect ke halaman registrasi antrean
                                window.location.href = "<?= BASE_URL . 'index.php?page=patient/clinic/queue_registration' ?>";

                            // Cek modal apakah sama dengan "pekerja_admin", jika iya maka :
                            <?php elseif ($modal == 'pekerja_admin'): ?>

                                // Redirect ke halaman dashboard
                                window.location.href = "<?= BASE_URL . 'index.php?page=worker/dashboard' ?>";
                            <?php endif; ?>

                        // Jika pesan yang diterima itu antara lain "logout, reset_terkirim, timeout, deleted", maka :
                        <?php elseif ($pesan == 'logout' || $pesan == 'reset_terkirim' || $pesan == 'timeout' || $pesan == 'deleted'): ?>

                            // Redirect ke halaman beranda
                            window.location.href = "<?= BASE_URL ?>";
                        <?php endif; ?>
                    });
                }

                // Jika pesan bukan "logout, timeout, auto_timeout, deleted, auto_deleted, login_sukses, reset_terkirim", maka :
                <?php if (!in_array($pesan, ['logout','timeout','auto_timeout','deleted','auto_deleted','login_sukses','reset_terkirim'])): ?>

                    // Inisialisasi target modal
                    let targetModal = null;

                    // Jika pesan yang diterima itu "token_invalid" dan
                    // Jika modal sama dengan "reset_password", maka :
                    if ("<?= $pesan ?>" === 'token_invalid' && "<?= $modal ?>" === 'reset_password') {

                        // Target modalnya adalah forgot password
                        targetModal = '#modalForgotPassword';
                    }

                    // Tampilkan modal jika ada
                    if (targetModal) {

                        // Memanggil modal Bootstrap berdasarkan targetModal
                        $(targetModal).modal({
                            backdrop:'static',  // Modal tidak tertutup saat klik di luar area modal
                            keyboard:true,      // Modal dapat ditutup dengan tombol ESC
                            show:true           // Langsung tampilkan modal
                        });

                    }
                <?php endif; ?>

            }, 300);  // Delay 300 ms = 0,3 detik
        });

    </script>


<!--
===========================================================================================
Pesan tidak ada, maka :
Tentukan modal yang akan dibuka berdasarkan parameter "modal"
===========================================================================================
-->

<?php
    // Jika tidak ada parameter "pesan" di URL dan
    // Hanya ada parameter "modal" di URL, maka :
    elseif (!isset($_GET['pesan']) && isset($_GET['modal'])):
?>

    <script>
        // Jalankan kode setelah seluruh halaman dan semua asset selesai dimuat
        $(window).on('load', function() {

            const modal = "<?= $_GET['modal'] ?>"; // Ambil parameter "modal"
            let targetModal = null; // Inisialisasi target modal

            // Jika modal sama dengan "pasien", maka :
            if (modal === 'pasien') {

                // Target modalnya adalah login pasien
                targetModal = '#modalLoginPasien';
            }

            // Jika modal sama dengan "pekerja_admin", maka :
            else if (modal === 'pekerja_admin') {

                // Target modalnya adalah login pekerja atau admin
                targetModal = '#modalLoginPekerjaAdmin';
            }

            // Jika modal sama dengan "registration", maka :
            else if (modal === 'registration') {

                // Target modalnya adalah registrasi akun pasien
                targetModal = '#modalRegistration';
            }

            // Jika modal sama dengan "forgot_password", maka :
            else if (modal === 'forgot_password') {

                // Target modalnya adalah lupa password
                targetModal = '#modalForgotPassword';
            }

            // Jika modal sama dengan "reset_password", maka :
            else if (modal === 'reset_password') {

                // Target modalnya adalah reset password
                targetModal = '#modalResetPassword';
            }

            // Tampilkan modal jika ada
            if (targetModal) {

                // Delay beberapa saat
                setTimeout(() => {

                    // Memanggil modal Bootstrap berdasarkan targetModal
                    $(targetModal).modal({
                        backdrop:'static',  // Modal tidak tertutup saat klik di luar area modal
                        keyboard:true,      // Modal dapat ditutup dengan tombol ESC
                        show:true           // Langsung tampilkan modal
                    });

                }, 300); // Delay 300 ms = 0,3 detik

                // Hapus parameter "modal" dari URL tanpa me-refresh halaman
                const url = new URL(window.location);
                url.searchParams.delete('modal');
                window.history.replaceState({}, document.title, url);
            }
        });

    </script>
<?php endif; ?>


<style>
    /* ===================================================================================== */
    /* ===                              SWEETALERT2 STYLE                                === */
    /* ===================================================================================== */

    /* ==================================== GLOBAL =================================== */
    /* Custom card untuk SweetAlert2 */
    .swal2-card {
        padding: 1rem 2rem 3rem 2rem !important;
        width: 480px !important;
        min-height: 240px !important;
        border-radius: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    /* Subtitle (deskripsi pesan) pada SweetAlert2 */
    .swal2-html-container {
        margin-top: 0.5rem;
        font-size: 1rem;
        color: #6c757d;
    }

    /* Kontainer progress bar timer SweetAlert2 */
    .swal2-timer-progress-bar-container { 
        padding: 0 1.5rem !important;
    }

    /* Progress bar timer SweetAlert2 */
    .swal2-timer-progress-bar { 
        height: 6px !important;
        border-radius: 10px !important;
        background-color: rgba(0,0,0,.1) !important;
    }
</style>