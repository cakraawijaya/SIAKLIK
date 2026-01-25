// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function() {

    // Tampilkan modal reset password
    $('#modalResetPassword').modal({
        backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
        keyboard: true,      // Modal dapat ditutup dengan tombol ESC
        show: true           // Langsung tampilkan modal
    });

});