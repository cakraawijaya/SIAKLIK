$(document).ready(function() {

    // Inisialisasi modal tanpa auto show
    $('.modal').modal({
        backdrop: 'static',
        keyboard: true,
        show: false
    });

    // Switch Login Pasien -> Login Pekerja
    $('#switchToPekerjaFromPasien').click(function(e) {
        e.preventDefault();
        $('#modalLoginPasien').modal('hide');
        $('#modalLoginPasien').one('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            $('#modalLoginPekerjaAdmin').modal({backdrop: 'static', keyboard: true, show: true});
        });
    });

    // Switch Login Pekerja -> Login Pasien
    $('#switchToPasienFromPekerja').click(function(e) {
        e.preventDefault();
        $('#modalLoginPekerjaAdmin').modal('hide');
        $('#modalLoginPekerjaAdmin').one('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            $('#modalLoginPasien').modal({backdrop: 'static', keyboard: true, show: true});
        });
    });

});