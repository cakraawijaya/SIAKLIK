$(document).ready(function() {

    // Modal init, tidak otomatis tampil saat load
    $('.modal').modal({
        backdrop: 'static',
        keyboard: true,
        show: false
    });

    // Switch Pasien -> Forgot Password
    $('#switchToForgotPassword').click(function(e) {
        e.preventDefault();
        $('#modalLoginPasien').modal('hide');
        $('#modalLoginPasien').one('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            $('#modalForgotPassword').modal({backdrop: 'static', keyboard: true, show: true});
        });
    });

    // Switch Forgot Password -> Login Pasien
    $('#switchToPasienFromForgotPassword').click(function(e) {
        e.preventDefault();
        $('#modalForgotPassword').modal('hide');
        $('#modalForgotPassword').one('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            $('#modalLoginPasien').modal({backdrop: 'static', keyboard: true, show: true});
        });
    });

});