$(document).ready(function() {

    // Modal init, tidak otomatis tampil saat load
    $('.modal').modal({
        backdrop: 'static',
        keyboard: true,
        show: false
    });

    // Switch Registration
    $('#switchToRegistration').click(function(e) {
        e.preventDefault();
        $('#modalLoginPasien').modal('hide');
        $('#modalLoginPasien').one('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            $('#modalRegistration').modal({backdrop: 'static', keyboard: true, show: true});
        });
    });

    // Switch Registration -> Login Pasien
    $('#switchToPasienFromRegistration').click(function(e) {
        e.preventDefault();
        $('#modalRegistration').modal('hide');
        $('#modalRegistration').one('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            $('#modalLoginPasien').modal({backdrop: 'static', keyboard: true, show: true});
        });
    });
    
});