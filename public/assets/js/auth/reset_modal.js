// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function() {

    // ===========================================================================================
    // FUNGSI RESET INPUT FORM
    // ===========================================================================================
    function resetInputs($form, exceptions = []) {

        // Cari semua input, select, dan textarea di dalam form
        $form.find('input, select, textarea').each(function() {

            // Elemen input atau select atau textarea yang sedang diproses (dibungkus jQuery)
            const $el = $(this);

            // Ambil tipe input (checkbox, radio, text, dll)
            const type = ($el.attr('type') || '').toLowerCase();

            // Jika elemen cocok dengan salah satu selector di exceptions maka lewati (tidak di-reset)
            if (exceptions.some(sel => $el.is(sel))) return;

            // Reset berdasarkan jenis input
            if (type === 'checkbox' || type === 'radio') {
                $el.prop('checked', false); // Checkbox atau radio -> uncheck
            } else {
                $el.val(''); // Input lain -> kosongkan nilai
            }
        });
    }


    // ===========================================================================================
    // EVENT SAAT MODAL DITUTUP
    // ===========================================================================================
    $(document).on('hidden.bs.modal', '.modal', function () {

        // Modal yang sedang diproses (jQuery object)
        const $modal = $(this);


        /* ================= MENENTUKAN INPUT YANG DIKECUALIKAN DARI RESET =============== */
        let exceptions = [];

        if ($modal.is('#modalAddPasien')) {
            exceptions = [
                'input[name="jenis_kelamin"]',
                'input[name="kategori"]'
            ];
        }


        /* ======================== RESET SEMUA FORM DI DALAM MODAL ====================== */
        $modal.find('form').each(function() {

            // Form yang sedang diproses (jQuery object)
            const $form = $(this);

            // Reset semua input form "Tambah Riwayat Pasien" kecuali jenis kelamin dan kategori
            resetInputs($form, exceptions);

            // Reset bagian select
            $form.find('select').each(function() {

                // Elemen select yang sedang diproses (jQuery object)
                const $select = $(this);

                // Khusus form "Tambah Riwayat Pasien" -> reset pilihan status ke awal (placeholder)
                if ($modal.is('#modalAddPasien') && $select.attr('name') === 'status') {

                    // Jika fungsi dan data tersedia
                    if (typeof setStatusOptions === 'function' && typeof allStatusAdd !== 'undefined') {

                        // Reset pada bagian placeholder saja
                        setStatusOptions(this, [], allStatusAdd);

                    } else { // Fallback jika fungsi dan data tidak ada
                        this.selectedIndex = 0;
                    }
                } 

                // Dropdown lain yang tidak dikecualikan -> reset ke pilihan awal
                else if (!exceptions.includes(`#${this.id}`) && !exceptions.includes(`[name="${this.name}"]`)) {
                    this.selectedIndex = 0;
                }
            });
        });


        /* ================================= RESET CAPTCHA =============================== */
        // Kosongkan input captcha
        $modal.find('input.input-captcha').val('');

        // Reload semua gambar captcha
        $modal.find('img[id^="captcha"]').each(function() {
            reloadCaptcha(this.id);
        });


        /* =========================== RESET FILE INPUT & PREVIEW ======================== */
        // Sembunyikan preview gambar
        $modal.find('img[id^="previewFoto"]').attr('src', '').hide();

        // Reset nama file
        $modal.find('span[id^="file-name"]').text('Belum ada berkas');

        // Kosongkan input file
        $modal.find('input[type="file"]').val('');
    });


    // ===========================================================================================
    // EVENT SAAT MODAL DIBUKA
    // ===========================================================================================
    $(document).on('show.bs.modal', '.modal', function () {

        // Modal yang sedang diproses (jQuery object)
        const $modal = $(this);

        // Reload captcha setiap modal dibuka
        $modal.find('img[id^="captcha"]').each(function() {
            reloadCaptcha(this.id);
        });
    });

});