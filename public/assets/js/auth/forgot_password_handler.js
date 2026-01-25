// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function() {

    /* ================================== MODAL INIT ================================= */
    $('.modal').modal({
        backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
        keyboard: true,      // Modal dapat ditutup dengan tombol ESC
        show: false          // Modal tidak otomatis tampil saat load
    });


    /* ====================== SWITCH LOGIN PASIEN -> LUPA PASSWORD =================== */
    $('#switchToForgotPassword').click(function(e) {
        e.preventDefault(); // Mencegah aksi default

        // Sembunyikan modal login pasien
        $('#modalLoginPasien').modal('hide');

        // Jalankan fungsi hanya sekali, setelah modal login pasien benar-benar tertutup
        $('#modalLoginPasien').one('hidden.bs.modal', function() {

            // Hapus backdrop (overlay gelap) modal secara manual
            $('.modal-backdrop').remove();

            // Hapus class modal-open dan reset padding body (menghindari bug scroll)
            $('body').removeClass('modal-open').css('padding-right', '');

            // Tampilkan modal lupa password
            $('#modalForgotPassword').modal({
                backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
                keyboard: true,      // Modal dapat ditutup dengan tombol ESC
                show: true           // Langsung tampilkan modal
            });
        });
    });


    /* ====================== SWITCH LUPA PASSWORD -> LOGIN PASIEN =================== */
    $('#switchToPasienFromForgotPassword').click(function(e) {
        e.preventDefault(); // Mencegah aksi default

        // Sembunyikan modal lupa password
        $('#modalForgotPassword').modal('hide');

        // Jalankan fungsi hanya sekali, setelah modal lupa password benar-benar tertutup
        $('#modalForgotPassword').one('hidden.bs.modal', function() {

            // Hapus backdrop (overlay gelap) modal secara manual
            $('.modal-backdrop').remove();

            // Hapus class modal-open dan reset padding body (menghindari bug scroll)
            $('body').removeClass('modal-open').css('padding-right', '');

            // Tampilkan modal login pasien
            $('#modalLoginPasien').modal({
                backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
                keyboard: true,      // Modal dapat ditutup dengan tombol ESC
                show: true           // Langsung tampilkan modal
            });
        });
    });

});