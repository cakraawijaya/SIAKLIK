<?php 
    if (isset($_GET['pesan'])): 
        $pesan = $_GET['pesan'];
        $modal = isset($_GET['modal']) ? $_GET['modal'] : 'pasien';
        $alertMessage = "";

        // Pesan utama
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

        // Subtitle
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

        // Tentukan icon dan warna
        $successMessages = ['login_sukses', 'registration_sukses', 'reset_terkirim', 'reset_sukses'];
        $iconType = in_array($pesan, $successMessages) ? 'success' : 'error';
        $iconColor = in_array($pesan, $successMessages) ? '#28a745' : '#dc3545';
?>

<script>
    $(document).ready(function(){
        setTimeout(function(){

            const specialAlerts = ['auto_timeout', 'auto_deleted'];
            const isSpecial = specialAlerts.includes("<?= $pesan ?>");

            // SweetAlert untuk special alerts hanya sekali
            if (isSpecial && !sessionStorage.getItem("timeoutAlertShown")) {
                Swal.fire({
                    icon: "<?= $iconType ?>",
                    title: <?= json_encode($alertMessage) ?>,
                    html: <?= json_encode($subtitle) ?>,
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: { popup: 'swal2-card' },
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    iconColor: "<?= $iconColor ?>"
                }).then(() => {
                    sessionStorage.setItem("timeoutAlertShown","true");
                    window.location.replace("<?= BASE_URL ?>");
                });
            }
            else if (!isSpecial) {
                <?php if(!empty($alertMessage)): ?>
                    // Pesan normal (login/logout/registration/forgot password dsb)
                    Swal.fire({
                        icon: "<?= $iconType ?>",
                        title: <?= json_encode($alertMessage) ?>,
                        html: <?= json_encode($subtitle) ?>,
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        customClass: { popup: 'swal2-card' },
                        buttonsStyling: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        iconColor: "<?= $iconColor ?>"
                    }).then(() => {
                        
                        // Hapus query params agar SweetAlert hanya muncul sekali
                        const url = new URL(window.location); 
                        url.searchParams.delete('pesan'); 
                        url.searchParams.delete('modal'); 
                        window.history.replaceState({}, document.title, url);

                        <?php if($pesan == 'login_sukses'): ?>
                            <?php if($modal == 'pasien'): ?>
                                sessionStorage.removeItem('userLoggedOut');
                                sessionStorage.removeItem('timeoutAlertShown');
                                window.location.href = "<?= BASE_URL . 'index.php?page=patient/clinic/queue_registration' ?>";
                            <?php elseif($modal == 'pekerja_admin'): ?>
                                sessionStorage.removeItem('userLoggedOut');
                                sessionStorage.removeItem('timeoutAlertShown');
                                window.location.href = "<?= BASE_URL . 'index.php?page=worker/dashboard' ?>";
                            <?php endif; ?>
                        <?php elseif($pesan == 'logout' || $pesan == 'reset_terkirim' || $pesan == 'timeout' || $pesan == 'deleted'): ?>
                            sessionStorage.removeItem('userLoggedOut');
                            sessionStorage.removeItem('timeoutAlertShown');
                            window.location.href = "<?= BASE_URL ?>";
                        <?php else: ?>
                            sessionStorage.removeItem('userLoggedOut');
                            sessionStorage.removeItem('timeoutAlertShown');
                        <?php endif; ?>
                    });
                <?php endif; ?>

                // Tampilan Modal
                <?php if(!in_array($pesan, ['logout', 'timeout', 'auto_timeout', 'deleted', 'auto_deleted', 'login_sukses', 'reset_terkirim'])): ?>
                    let targetModal = null;

                    if ("<?= $pesan ?>" === 'token_invalid' && "<?= $modal ?>" === 'reset_password') {
                        targetModal = '#modalForgotPassword';
                    } else {
                        if("<?= $modal ?>" === 'pasien') targetModal = '#modalLoginPasien';
                        else if("<?= $modal ?>" === 'pekerja_admin') targetModal = '#modalLoginPekerjaAdmin';
                        else if("<?= $modal ?>" === 'registration') targetModal = '#modalRegistration';
                        else if("<?= $modal ?>" === 'forgot_password') targetModal = '#modalForgotPassword';
                        else if("<?= $modal ?>" === 'reset_password') targetModal = '#modalResetPassword';
                    }

                    if(targetModal){
                        $(targetModal).modal({ backdrop: 'static', keyboard: true, show: true });
                    }
                <?php endif; ?>
            }
        }, 300);
    });
</script>

<style>
    .swal2-card {
        padding-left: 2rem !important;
        padding-right: 2rem !important;
        padding-top: 1rem !important;
        padding-bottom: 3rem !important;
        width: 480px !important;
        min-height: 240px !important;
        border-radius: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .swal2-html-container {
        margin-top: 0.5rem;
        font-size: 1rem;
        color: #6c757d;
    }
    .swal2-timer-progress-bar-container {
        padding: 0rem 1.5rem !important;
    }
    .swal2-timer-progress-bar {
        height: 6px !important;
        border-radius: 10px !important;
        background-color: rgba(0, 0, 0, 0.1) !important;
    }
</style>
<?php endif; ?>



<!-- Bagian ini hanya aktif jika TIDAK ADA parameter "pesan" -->
<?php if (!isset($_GET['pesan']) && isset($_GET['modal'])): ?>
<script>
    // Hapus query params agar SweetAlert hanya muncul sekali
    const url = new URL(window.location); 
    url.searchParams.delete('pesan'); 
    url.searchParams.delete('modal'); 
    window.history.replaceState({}, document.title, url);

    $(window).on('load', function() {
        const modal = "<?= $_GET['modal'] ?>";
        let targetModal = null;

        if (modal === 'pasien') targetModal = '#modalLoginPasien';
        else if (modal === 'pekerja_admin') targetModal = '#modalLoginPekerjaAdmin';
        else if (modal === 'registration') targetModal = '#modalRegistration';
        else if (modal === 'forgot_password') targetModal = '#modalForgotPassword';

        if (targetModal) {
            setTimeout(() => {
                $(targetModal).modal({ backdrop: 'static', keyboard: true, show: true });
            }, 300);
        }
    });
</script>
<?php endif; ?>