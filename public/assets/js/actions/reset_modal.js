$(document).ready(function() {    

    // Saat modal ditutup → reset semua input dan file preview
    $(document).on('hidden.bs.modal', '.modal', function () {
        const $modal = $(this);

        // Reset semua form
        $modal.find('form').each(function() {
            this.reset();
            $(this).find('input, select, textarea').each(function() {
                const type = ($(this).attr('type') || '').toLowerCase();
                if (type !== 'hidden') { // jangan reset input hidden (CSRF, dsb)
                    if (type === 'checkbox' || type === 'radio') {
                        $(this).prop('checked', false);
                    } else {
                        $(this).val('');
                    }
                }
            });
        });

        // Reset captcha input & reload captcha
        $modal.find('input.input-captcha').val('');
        $modal.find('img[id^="captcha"]').each(function() {
            reloadCaptcha(this.id);
        });

        // Reset file input & preview
        $modal.find('img[id^="previewFoto"]').attr('src', '').hide();
        $modal.find('span[id^="file-name"]').text('Belum ada berkas');
        $modal.find('input[type="file"]').val('');
    });

    // Saat modal dibuka → reload captcha
    $(document).on('show.bs.modal', '.modal', function () {
        const $modal = $(this);

        $modal.find('img[id^="captcha"]').each(function() {
            reloadCaptcha(this.id);
        });
    });

});