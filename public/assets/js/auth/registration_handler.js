// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function() {

    /* ================================== MODAL INIT ================================= */
    $('.modal').modal({
        backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
        keyboard: true,      // Modal dapat ditutup dengan tombol ESC
        show: false          // Modal tidak otomatis tampil saat load
    });


    /* =================== SWITCH LOGIN PASIEN -> REGISTRASI PASIEN ================== */
    $('#switchToRegistration').click(function(e) {
        e.preventDefault(); // Mencegah aksi default

        // Sembunyikan modal login pasien
        $('#modalLoginPasien').modal('hide');

        // Jalankan fungsi hanya sekali, setelah modal login pasien benar-benar tertutup
        $('#modalLoginPasien').one('hidden.bs.modal', function() {

            // Hapus backdrop (overlay gelap) modal secara manual
            $('.modal-backdrop').remove();

            // Hapus class modal-open dan reset padding body (menghindari bug scroll)
            $('body').removeClass('modal-open').css('padding-right', '');

            // Tampilkan modal registrasi pasien
            $('#modalRegistration').modal({
                backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
                keyboard: true,      // Modal dapat ditutup dengan tombol ESC
                show: true           // Langsung tampilkan modal
            });
        });
    });


    /* =================== SWITCH REGISTRASI PASIEN -> LOGIN PASIEN ================== */
    $('#switchToPasienFromRegistration').click(function(e) {
        e.preventDefault(); // Mencegah aksi default

        // Sembunyikan modal registrasi pasien
        $('#modalRegistration').modal('hide');

        // Jalankan fungsi hanya sekali, setelah modal registrasi pasien benar-benar tertutup
        $('#modalRegistration').one('hidden.bs.modal', function() {

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