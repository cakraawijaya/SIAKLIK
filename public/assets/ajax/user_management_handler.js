$(document).ready(function () {

    // ======================== LOAD DATA ========================
    function loadUserData(searchOnly = false, highlightPage = null) {
        var search = searchOnly ? $('input[name="search"]').val() : '';
        if (highlightPage) currentPage[activeTab] = highlightPage;

        $.ajax({
            url: BASE_URL + "components/data/ajax_user_management.php",
            type: "GET",
            data: {
                tab: activeTab,
                search: search,
                ['link_' + activeTab]: currentPage[activeTab]
            },
            dataType: "json",
            success: function (res) {
                var data = res.users[activeTab];
                var tbody = $('#' + activeTab + ' tbody');
                tbody.empty();

                var aksiColumn = $('#' + activeTab + ' table th:contains("Aksi"), #' + activeTab + ' table th:contains("AKSI")').closest('th');

                if (!data || data.data.length === 0) {
                    aksiColumn.hide();
                    tbody.append('<tr><td colspan="5" class="text-center align-middle">Data tidak ditemukan</td></tr>');
                } else {
                    aksiColumn.show();

                    // ===== NATURAL SORT EMAIL =====
                    function naturalSortEmail(a, b) {
                        var emailA = a.email.toLowerCase();
                        var emailB = b.email.toLowerCase();

                        function splitEmailBlocks(str) {
                            return str.match(/\d+|\D+/g).map(function(block) {
                                return /^\d+$/.test(block) ? parseInt(block, 10) : block;
                            });
                        }

                        var blocksA = splitEmailBlocks(emailA);
                        var blocksB = splitEmailBlocks(emailB);

                        var len = Math.min(blocksA.length, blocksB.length);
                        for (var i = 0; i < len; i++) {
                            if (blocksA[i] === blocksB[i]) continue;
                            if (typeof blocksA[i] === 'number' && typeof blocksB[i] === 'number') {
                                return blocksA[i] - blocksB[i];
                            }
                            return String(blocksA[i]).localeCompare(String(blocksB[i]));
                        }
                        return blocksA.length - blocksB.length;
                    }

                    data.data.sort(naturalSortEmail);

                    // ===== Tampilkan data ke tabel =====
                    data.data.forEach(function (row) {
                        var foto = row.foto || 'default.png';
                        var fotoSrc = BASE_URL + 'public/assets/img/photo/' + foto;
                        var highlightClass = (lastEditedUser.username === row.username) ? 'table-success' : '';
                        var disableDelete = (row.username === CURRENT_USER_USERNAME) ? 'disabled' : '';

                        var actionBtns = `
                            <div class="btn-group">
                                <button class="btn btn-warning-custom text-white btn-sm edit-btn"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm delete-btn" ${disableDelete}><i class="fa fa-trash"></i></button>
                            </div>`;

                        tbody.append(`
                            <tr class="${highlightClass}">
                                <td class="text-center align-middle" style="width:120px;">
                                    <img src="${fotoSrc}" alt="foto" data-username="${row.username}" style="width:64px;height:64px;object-fit:cover;border-radius:6px;">
                                </td>
                                <td class="text-center align-middle email" data-email="${row.email || ''}">${row.email || '-'}</td>
                                <td class="text-center align-middle" data-username="${row.username || ''}">${row.username || '-'}</td>
                                <td class="text-center align-middle">${row.nama || '-'}</td>
                                <td class="text-center align-middle">${actionBtns}</td>
                            </tr>
                        `);
                    });
                }

                // ======================== INFO TEXT ========================
                var labelText = '(' + activeTab.toUpperCase() + ')';
                var infoText = search === '' ? 'Jumlah data pengguna' : 'Hasil pencarian data pengguna';
                var countText = data.total_data || 0;

                $('#' + activeTab + '-info').text(infoText + ' ');
                $('#' + activeTab + '-category').text(labelText + ' ');
                $('#' + activeTab + '-count').text(countText);

                totalPage[activeTab] = data.total_page || 1;

                // ======================== PAGINATION ========================
                if (data.current_page <= 1) $('#' + activeTab + '-prev').hide();
                else $('#' + activeTab + '-prev').show();
                if (data.current_page >= data.total_page) $('#' + activeTab + '-next').hide();
                else $('#' + activeTab + '-next').show();

                // SESUAIKAN MARGIN OTOMATIS
                updatePaginationMarginsAuto(activeTab);

                // ======================== HIGHLIGHT & SCROLL ========================
                if (lastEditedUser.username) {
                    var rowToHighlight = $('#' + activeTab + ' tbody tr').filter(function () {
                        return $(this).find('td:nth-child(3)').text().trim() === lastEditedUser.username;
                    });

                    if (rowToHighlight.length > 0) {
                        rowToHighlight.addClass('table-success');
                        $('html, body').animate({ scrollTop: rowToHighlight.offset().top - 100 }, 400);

                        // Hapus highlight setelah 4 detik (4000 ms)
                        setTimeout(function() {
                            rowToHighlight.removeClass('table-success');
                        }, 4000);
                    }

                    lastEditedUser.username = null;
                }
            },
            error: function (xhr, status, err) {
                console.error('Error loadUserData:', status, err);
                var tbody = $('#' + activeTab + ' tbody');
                tbody.empty().append('<tr><td colspan="5" class="text-center align-middle">Gagal memuat data (lihat console)</td></tr>');
            }
        });
    }

    // ======================== PAGINATION MARGIN OTOMATIS ========================
    function updatePaginationMarginsAuto(tab) {
        var prevBtn = $('#' + tab + '-prev');
        var nextBtn = $('#' + tab + '-next');

        // Reset semua margin
        prevBtn.removeClass('mr-3');
        nextBtn.removeClass('mr-3');

        var visibleBtns = [prevBtn, nextBtn].filter(btn => btn.is(':visible'));

        if (visibleBtns.length === 2) {
            // Dua tombol tampil → beri margin kanan hanya pada tombol pertama (prev)
            visibleBtns[0].addClass('mr-3');
        }
    }

    // ======================== TAB SWITCH ========================
    $('a[data-tab]').on('click', function (e) {
        e.preventDefault();
        var clickedTab = $(this).data('tab');

        if (clickedTab === activeTab) {
            currentPage[activeTab] = 1;
            lastEditedUser.username = null;
            loadUserData();
            return;
        }

        activeTab = clickedTab;
        $('a[data-tab]').removeClass('active');
        $(this).addClass('active');
        $('.tab-pane').removeClass('show active');
        $('#' + activeTab).addClass('show active');

        currentPage[activeTab] = 1;
        lastEditedUser.username = null;
        loadUserData();
        $('#btnAddText').text('Data ' + labelMap[activeTab]);
        $('#btnExportText').html('Export ' + labelMap[activeTab]);
    });

    // ======================== SEARCH ========================
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        currentPage[activeTab] = 1;
        lastEditedUser.username = null;
        loadUserData(true);
    });

    $('#searchForm input[name="search"]').on('keypress', function (e) {
        if (e.which === 13) e.preventDefault();
    });

    // ======================== PAGINATION BUTTONS ========================
    $('a[id$="-prev"]').on('click', function () {
        var tab = $(this).attr('id').replace('-prev', '');
        if (currentPage[tab] > 1) {
            currentPage[tab]--;
            lastEditedUser.username = null;
            loadUserData();
        }
    });

    $('a[id$="-next"]').on('click', function () {
        var tab = $(this).attr('id').replace('-next', '');
        if (currentPage[tab] < totalPage[tab]) {
            currentPage[tab]++;
            lastEditedUser.username = null;
            loadUserData();
        }
    });

    // ======================== EXPORT ========================
    $('#btnExport').on('click', function () {
        let exportUrl = '';
        switch (activeTab) {
            case 'pasien': exportUrl = BASE_URL + 'components/features/export/user_data/patient.php'; break;
            case 'pekerja': exportUrl = BASE_URL + 'components/features/export/user_data/worker.php'; break;
            case 'admin': exportUrl = BASE_URL + 'components/features/export/user_data/admin.php'; break;
            default: Swal.fire('Oops!', 'Kategori tidak dikenal untuk export.', 'warning'); return;
        }
        const search = $('input[name="search"]').val();
        window.location.href = exportUrl + (search ? '?search=' + encodeURIComponent(search) : '');
    });

    // ======================== FILE INPUT ========================
    function setupFileInput(inputId, previewId, fileNameId) {
        $(inputId).on('change', function () {
            const file = this.files[0];
            const preview = $(previewId);
            const fileName = $(fileNameId);

            if (!file) {
                preview.hide();
                fileName.text(preview.data('old-file') || 'Belum ada berkas');
                return;
            }

            fileName.text(file.name);
            const reader = new FileReader();
            reader.onload = e => preview.attr('src', e.target.result).show();
            reader.readAsDataURL(file);
        });
    }

    const categoryList = Object.keys(labelMap); // ['pasien','pekerja','admin']

    categoryList.forEach(category => {
        const Caption = category.charAt(0).toUpperCase() + category.slice(1);

        // ADD
        setupFileInput(
            `#fileInputAdd${Caption}`,
            `#previewFotoAdd${Caption}`,
            `#file-name-add-${category}`
        );

        // EDIT
        setupFileInput(
            `#fileInputEdit${Caption}`,
            `#previewFotoEdit${Caption}`,
            `#file-name-edit-${category}`
        );
    });

    // ======================== CRUD AJAX ========================
    function crudAjax(formSelector, modalSelector) {
        $(formSelector).off('submit').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            var submitInput = $(this).find('button[type="submit"], input[type="submit"]');
            if (submitInput.length > 0) {
                var submitName = submitInput.attr('name');
                var submitValue = submitInput.val() || '1';
                if (submitName && !formData.has(submitName)) formData.append(submitName, submitValue);
            }

            $.ajax({
                url: BASE_URL + "components/data/ajax_user_management.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    if (res.success) $(modalSelector).modal('hide');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: res.success ? 'success' : 'error',
                        html: res.msg,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    if (!res.success) {
                        $(modalSelector).find('img[id^="captcha"]').each(function () {
                            reloadCaptcha(this.id);
                        });
                        $(modalSelector).find('.input-captcha').val('');
                    }

                    if (res.success && res.highlight_username) {
                        lastEditedUser.username = res.highlight_username;
                        var highlightPage = res.highlight_page || 1;
                        loadUserData(false, highlightPage);
                    }
                },
                error: function(xhr,status,err){
                    console.error('Ajax Error:', xhr.responseText);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        html: 'Terjadi kesalahan server',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
        });
    }

    const crudForms = [];

    categoryList.forEach(category => {
        const Caption = category.charAt(0).toUpperCase() + category.slice(1);

        crudForms.push(
            { form: `#formAddPengguna${Caption}`,    modal: `#modalAddPengguna${Caption}` },
            { form: `#formEditPengguna${Caption}`,   modal: `#modalEditPengguna${Caption}` },
            { form: `#formDeletePengguna${Caption}`, modal: `#modalDeletePengguna${Caption}` }
        );
    });

    crudForms.forEach(item => {
        crudAjax(item.form, item.modal);
    });

    // ======================== OPEN MODAL ========================
    // Tampilkan modal add
    $(document).on('click', '.add-btn', function () {
        const modalId = {
            pasien: '#modalAddPenggunaPasien',
            pekerja: '#modalAddPenggunaPekerja',
            admin:  '#modalAddPenggunaAdmin'
        }[activeTab];

        const modal = $(modalId);

        // Reset input di setiap modal sebelum dibuka
        modal.find('form')[0].reset();
        modal.find('input[type="file"]').val('');
        modal.find('img[id^="previewFotoAdd"]').attr('src', '').hide();
        modal.find('span[id^="file-name-add"]').text('Belum ada berkas');

        // Set kategori ke hidden input
        modal.find('input[name="kategori"]').val(activeTab);

        // Reload captcha khusus modal add
        const captcha = modal.find('img[id^="captchaAddPengguna"]');
        const baseUrl = captcha.data('base');
        captcha.attr('src', baseUrl + '&' + new Date().getTime());

        modal.modal('show');
    });

    // Tampilkan modal edit
    $(document).on('click', '.edit-btn', function () {
        var row = $(this).closest('tr');
        var fotoSrc = row.find('img').attr('src');
        var email = row.find('td.email').data('email') || '';
        var username = row.find('td:nth-child(3)').text().trim();
        var nama = row.find('td:nth-child(4)').text().trim();

        // Tentukan modal sesuai kategori
        var modalId = {
            admin: '#modalEditPenggunaAdmin',
            pekerja: '#modalEditPenggunaPekerja',
            pasien: '#modalEditPenggunaPasien'
        }[activeTab];

        var modal = $(modalId);

        // Isi input field
        modal.find('input[name="edit-email"]').val(email);
        modal.find('input[name="edit-email-lama"]').val(email);
        modal.find('input[name="edit-username"]').val(username);
        modal.find('textarea[name="edit-name"]').val(nama);

        // Foto preview
        modal.find('img[id^="previewFotoEdit"]').attr('src', fotoSrc).data('old-file', fotoSrc.split('/').pop()).show();

        // Nama file
        modal.find('span[id^="file-name-edit"]').text(fotoSrc.split('/').pop());

        // Reset input file
        modal.find('input[type="file"]').val('');

        // Set kategori (admin/pekerja/pasien)
        modal.find('input[name="kategori"]').val(activeTab);

        // Reload captcha khusus modal edit
        var captcha = modal.find('img[id^="captchaEditPengguna"]');
        var baseUrl = captcha.data('base');
        captcha.attr('src', baseUrl + '&' + new Date().getTime());

        // Tampilkan modal
        modal.modal('show');
    });

    // Tampilkan modal delete
    $(document).on('click', '.delete-btn', function () {
        var row = $(this).closest('tr');
        var email = row.find('td.email').data('email');
        var nama = row.find('td:nth-child(4)').text().trim();

        // Tentukan modal sesuai tab
        var modalId = {
            admin: '#modalDeletePenggunaAdmin',
            pekerja: '#modalDeletePenggunaPekerja',
            pasien: '#modalDeletePenggunaPasien'
        }[activeTab];

        var modal = $(modalId);

        // Isi data ke dalam modal
        modal.find('input[name="delete-email"]').val(email);
        modal.find('#delete_show_nama').html('<strong>' + nama + '</strong>');
        modal.find('#delete_show_email').html(' (<strong>Email:</strong> ' + email + ')');
        modal.find('input[name="kategori"]').val(activeTab);

        // Tampilkan modal
        modal.modal('show');
    });

    // ======================== AUTO REFRESH ========================
    loadUserData();
    setInterval(function () {
        if ($('input[name="search"]').val() === '') loadUserData();
    }, 10000);

    $('#btnAddText').text('Data ' + labelMap[activeTab]);
    $('#btnExportText').html('Export ' + labelMap[activeTab]);

});