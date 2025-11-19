$(document).ready(function() {    

    // Fungsi untuk reset input kecuali pengecualian
    function resetInputs($form, exceptions = []) {
        $form.find('input, select, textarea').each(function() {
            const $el = $(this);
            const type = ($el.attr('type') || '').toLowerCase();

            // Lewati input yang ada di daftar pengecualian
            if (exceptions.some(sel => $el.is(sel))) return;

            if (type === 'checkbox' || type === 'radio') {
                $el.prop('checked', false);
            } else {
                $el.val('');
            }
        });
    }

    // Saat modal ditutup → reset semua input dan file preview
    $(document).on('hidden.bs.modal', '.modal', function () {
        const $modal = $(this);

        // Tentukan pengecualian untuk modal add pasien
        let exceptions = [];
        if ($modal.is('#modalAddPasien')) {
            exceptions = [
                'input[name="jenis_kelamin"]',
                'input[name="kategori"]'
            ];
        }

        // Reset semua form di modal
        $modal.find('form').each(function() {
            const $form = $(this);

            resetInputs($form, exceptions);

            // Reset select
            $form.find('select').each(function() {
                const $select = $(this);

                // Khusus modal Add pasien → status kembali ke placeholder
                if ($modal.is('#modalAddPasien') && $select.attr('name') === 'status') {
                    if (typeof setStatusOptions === 'function' && typeof allStatusAdd !== 'undefined') {
                        setStatusOptions(this, [], allStatusAdd); // hanya placeholder
                    } else {
                        this.selectedIndex = 0; // fallback
                    }
                } 
                // Select lain → reset normal jika bukan pengecualian
                else if (!exceptions.includes(`#${this.id}`) && !exceptions.includes(`[name="${this.name}"]`)) {
                    this.selectedIndex = 0;
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