// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function() {

    /* ================================== MODAL INIT ================================= */
    $('.modal').modal({
        backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
        keyboard: true,      // Modal dapat ditutup dengan tombol ESC
        show: false          // Modal tidak otomatis tampil saat load
    });


    /* ================== SWITCH LOGIN PASIEN -> LOGIN PEKERJA/ADMIN ================= */
    $('#switchToPekerjaFromPasien').click(function(e) {
        e.preventDefault(); // Mencegah aksi default

        // Sembunyikan modal login pasien
        $('#modalLoginPasien').modal('hide');

        // Jalankan fungsi hanya sekali, setelah modal login pasien benar-benar tertutup
        $('#modalLoginPasien').one('hidden.bs.modal', function() {

            // Hapus backdrop (overlay gelap) modal secara manual
            $('.modal-backdrop').remove();

            // Hapus class modal-open dan reset padding body (menghindari bug scroll)
            $('body').removeClass('modal-open').css('padding-right', '');

            // Tampilkan modal login pekerja atau admin
            $('#modalLoginPekerjaAdmin').modal({
                backdrop: 'static',  // Modal tidak tertutup saat klik di luar area modal
                keyboard: true,      // Modal dapat ditutup dengan tombol ESC
                show: true           // Langsung tampilkan modal
            });
        });
    });


    /* ================== SWITCH LOGIN PEKERJA/ADMIN -> LOGIN PASIEN ================= */
    $('#switchToPasienFromPekerja').click(function(e) {
        e.preventDefault(); // Mencegah aksi default

        // Sembunyikan modal login pekerja atau admin
        $('#modalLoginPekerjaAdmin').modal('hide');

        // Jalankan fungsi hanya sekali, setelah modal login pekerja atau admin benar-benar tertutup
        $('#modalLoginPekerjaAdmin').one('hidden.bs.modal', function() {

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