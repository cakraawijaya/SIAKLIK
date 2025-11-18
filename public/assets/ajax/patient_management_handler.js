$(document).ready(function(){

    // ==============================================
    // Fungsi Load Data Pasien
    // ==============================================
    function loadPatients(searchOnly = false){
        var search = $('input[name="search"]').val();

        $.ajax({
            url: BASE_URL + "components/data/ajax_patient_management.php",
            type: "GET",
            data: { 
                action: 'list',
                page: currentPage[activeTab],
                search: search
            },
            dataType: "json",
            success: function(res){
                var tbody = $('#patientTableBody');

                // Urutkan data berdasarkan angka terakhir ID
                if(res.data && res.data.length > 0){
                    res.data.sort((a, b) => {
                        const getNum = id => {
                            if(!id) return 0;
                            const parts = id.trim().split('-');
                            const last = parts.pop();
                            const n = parseInt(last, 10);
                            return isNaN(n) ? 0 : n;
                        };
                        return getNum(a.id) - getNum(b.id);
                    });
                }

                // Jika halaman kosong dan ada halaman lain, pindah otomatis
                if(res.data.length === 0){
                    if(currentPage[activeTab] < (res.totalPage || 1)){
                        currentPage[activeTab]++;
                        loadPatients(searchOnly);
                        return;
                    } else if(currentPage[activeTab] > 1){
                        currentPage[activeTab]--;
                        loadPatients(searchOnly);
                        return;
                    }
                }

                tbody.empty();

                if(!res.data || res.data.length === 0){
                    $('th:last-child').hide(); // sembunyikan header aksi
                    tbody.append('<tr><td colspan="13" class="text-center align-middle">Data tidak ditemukan</td></tr>');
                } else {
                    $('th:last-child').show(); // tampilkan header aksi jika ada data
                    res.data.forEach(function(p){
                        var highlightClass = (lastUpdatedPatient.id === p.id) ? 'table-success' : '';
                        tbody.append(
                            `<tr class="${highlightClass}">
                                <td class="text-center align-middle">${p.id}</td>
                                <td class="text-center align-middle">${p.nama}</td>
                                <td class="text-center align-middle">${p.umur}</td>
                                <td class="text-center align-middle">${p.alamat}</td>
                                <td class="text-center align-middle">${p.pekerjaan}</td>
                                <td class="text-center align-middle">${p.status}</td>
                                <td class="text-center align-middle">${p.jenis_kelamin}</td>
                                <td class="text-center align-middle">${p.nim_nip || '-'}</td>
                                <td class="text-center align-middle">${p.no_bpjs || '-'}</td>
                                <td class="text-center align-middle">${p.layanan}</td>
                                <td class="text-center align-middle">${p.keterangan}</td>
                                <td class="text-center align-middle">${p.waktu}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button class="btn btn-warning-custom text-white btn-sm edit-btn" data-id="${p.id}"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="${p.id}" data-nama="${p.nama}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>`
                        );
                    });
                }

                // Scroll ke row baru jika ada highlight
                setTimeout(() => {
                    const newRow = $('#patientTableBody tr.table-success');
                    if(newRow.length){
                        $('html, body').animate({ scrollTop: newRow.offset().top - 100 }, 300);
                    }
                }, 100);

                // Hapus highlight otomatis setelah 5 detik
                setTimeout(() => {
                    $('#patientTableBody tr.table-success').removeClass('table-success');
                    lastUpdatedPatient = { id: null };
                }, 5000);

                // ======================== INFO TEXT ========================
                var infoText = '';
                var countText = res.total || 0;

                if (search === '') {
                    infoText = 'Jumlah data pasien';
                } else {
                    infoText = 'Hasil pencarian data pasien';
                }

                $('#patient-info').text(infoText + ' ');
                $('#patient-count').text(' ' + countText);

                totalPage[activeTab] = res.totalPage || 1;

                // Pagination
                if(currentPage[activeTab] <= 1){
                    $('#patient-prev').hide();
                } else {
                    $('#patient-prev').show();
                }

                if(currentPage[activeTab] >= totalPage[activeTab]){
                    $('#patient-next').hide();
                    $('#patient-prev').removeClass('mr-3');
                } else {
                    $('#patient-next').show();
                    if(currentPage[activeTab] > 1){
                        $('#patient-prev').addClass('mr-3');
                    }
                }
            },
            error: function(xhr, status, err){
                console.error('Error loadPatients:', status, err);
                $('#patientTableBody').html('<tr><td colspan="13" class="text-center align-middle">Gagal memuat data (lihat console)</td></tr>');
            }
        });
    }

    // =======================
    // Load awal
    // =======================
    loadPatients();

    // =======================
    // Pencarian
    // =======================
    $('#searchForm').on('submit', function(e){
        e.preventDefault();
        currentPage[activeTab] = 1;
        lastUpdatedPatient = { id: null };
        loadPatients(true);
    });

    $('#searchForm input[name="search"]').on('keypress', function(e){
        if(e.which === 13) e.preventDefault();
    });

    // =======================
    // Pagination
    // =======================
    $('#patient-prev').on('click', function(){
        if(currentPage[activeTab] > 1){
            currentPage[activeTab]--;
            loadPatients();
        }
    });

    $('#patient-next').on('click', function(){
        if(currentPage[activeTab] < totalPage[activeTab]){
            currentPage[activeTab]++;
            loadPatients();
        }
    });

    // =======================
    // Auto Refresh
    // =======================
    setInterval(function(){
        if($('input[name="search"]').val() === ''){
            loadPatients();
        }
    }, 10000);

    // ===================================================
    // MODAL ADD, EDIT, DELETE Pasien (AJAX CRUD)
    // ===================================================
    $('#formAddPasien').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.post(BASE_URL + "components/data/ajax_patient_management.php", $(this).serialize() + '&action=create', function(res){
            setTimeout(() => {
                Swal.close();

                if(res.success){
                    $('#modalAddPasien').modal('hide');

                    lastUpdatedPatient = { id: res.inserted_id };

                    // Pindah ke halaman terakhir agar data baru terlihat
                    $.get(BASE_URL + "components/data/ajax_patient_management.php", { action: 'list', page: 1 }, function(listRes){
                        totalPage[activeTab] = listRes.totalPage || 1;
                        currentPage[activeTab] = totalPage[activeTab];
                        loadPatients();
                    }, 'json');

                    $('#formAddPasien')[0].reset();

                    setTimeout(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            html: res.message || 'Data pasien berhasil ditambahkan',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                    }, 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: res.message || 'Gagal menambahkan pasien.'
                    });
                }
            }, 300);
        }, 'json').fail(function(){
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: 'Terjadi kesalahan saat menambah pasien.'
            });
        });
    });

    $(document).on('click', '.edit-btn', function(){
        const id = $(this).data('id');
        $.get(BASE_URL + "components/data/ajax_patient_management.php", { action: 'get', id }, function(res){
            if(res.success){
                const p = res.data;
                $('#edit_id_display').text(p.id);
                $('#edit_id').val(p.id);
                $('#edit_nama').val(p.nama);
                $('#edit_umur').val(p.umur);
                $('#edit_alamat').val(p.alamat);
                $('#edit_pekerjaan').val(p.pekerjaan);
                $('#edit_status').val(p.status);
                $('#edit_layanan').val(p.layanan);                

                const jk = (p.jenis_kelamin || '').toString().trim().toUpperCase();
                if (jk === 'L' || jk === 'LAKI-LAKI') {
                    $('#edit_laki').prop('checked', true);
                } else if (jk === 'P' || jk === 'PEREMPUAN') {
                    $('#edit_perempuan').prop('checked', true);
                }

                $('#edit_nim_nip').val(p.nim_nip);
                $('#edit_no_bpjs').val(p.no_bpjs);

                const ket = (p.keterangan || '').toString().trim().toLowerCase();
                if (ket.includes('eksternal')) {
                    $('#edit_keterangan_eksternal').prop('checked', true);
                } else if (ket.includes('internal')) {
                    $('#edit_keterangan_internal').prop('checked', true);
                }

                $('#modalEditPasien').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    html: 'Gagal mengambil data pasien.'
                });
            }
        }, 'json').fail(function(){
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: 'Terjadi kesalahan saat mengambil data.'
            });
        });
    });

    $('#formEditPasien').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.post(BASE_URL + "components/data/ajax_patient_management.php", $(this).serialize() + '&action=update', function(res){
            setTimeout(() => {
                Swal.close();

                if(res.success){
                    $('#modalEditPasien').modal('hide');

                    lastUpdatedPatient = { id: res.updated_id };

                    loadPatients();

                    setTimeout(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            html: res.message || 'Data pasien berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                    }, 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: res.message || 'Gagal memperbarui data.'
                    });
                }
            }, 300);
        }, 'json').fail(function(){
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: 'Terjadi kesalahan saat memperbarui data.'
            });
        });
    });

    $(document).on('click', '.delete-btn', function(){
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        const tampilNamaLengkap = `<strong>${nama}</strong>`;
        const tampilID = `(<strong>ID:</strong> ${id})`;

        $('#delete_id').val(id);
        $('#delete_show_nama').html(tampilNamaLengkap);
        $('#delete_show_id').html(tampilID);
        $('#modalDeletePasien').modal('show');
    });

    $('#formDeletePasien').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.post(BASE_URL + "components/data/ajax_patient_management.php", $(this).serialize() + '&action=delete', function(res){
            setTimeout(() => {
                Swal.close();

                if(res.success){
                    $('#modalDeletePasien').modal('hide');
                    loadPatients();

                    setTimeout(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            html: res.message || 'Data pasien berhasil dihapus',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                    }, 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: res.message || 'Gagal menghapus data.'
                    });
                }
            }, 300);
        }, 'json').fail(function(){
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: 'Terjadi kesalahan saat menghapus data.'
            });
        });
    });

    // ===================================================
    // FUNGSI OPSI STATUS vs LAYANAN
    // ===================================================
    function setSelectOptions(selectElem, allowedValues, allOptions, placeholderText = "Pilih") {
        const currentVal = selectElem.value;
        selectElem.innerHTML = "";

        // Tambahkan placeholder
        const option = document.createElement("option");
        option.value = "";
        option.textContent = placeholderText;
        option.disabled = true;
        option.selected = !allowedValues.includes(currentVal) || currentVal === "";
        selectElem.appendChild(option);

        // Tambahkan opsi yang diizinkan
        allOptions.forEach(opt => {
            if (allowedValues.includes(opt.value)) {
                const newOpt = document.createElement("option");
                newOpt.value = opt.value;
                newOpt.textContent = opt.text;
                selectElem.appendChild(newOpt);
            }
        });

        // Set value kembali jika masih valid
        if (allowedValues.includes(currentVal)) {
            selectElem.value = currentVal;
        }
    }

    // ======================
    // ADD MODAL
    // ======================
    const layananAdd = document.querySelector("select[name='layanan']");
    const statusAdd = document.querySelector("select[name='status']");
    const allStatusAdd = Array.from(statusAdd.options).map(opt => ({ value: opt.value, text: opt.text }));

    layananAdd.addEventListener("change", function() {
        if (this.value === "Poli Gigi") {
            setSelectOptions(statusAdd, ["Rawat Jalan", "Observasi"], allStatusAdd, "Pilih Status");
        } else if (this.value === "Poli Umum") {
            setSelectOptions(statusAdd, ["Rawat Inap", "Rawat Jalan", "Observasi", "Pasca Rawat Inap"], allStatusAdd, "Pilih Status");
        } else {
            // Jika belum memilih
            setSelectOptions(statusAdd, [], allStatusAdd, "Pilih Status");
        }
    });

    // ======================
    // EDIT MODAL
    // ======================
    const layananEdit = document.getElementById("edit_layanan");
    const statusEdit = document.getElementById("edit_status");
    const allStatusEdit = Array.from(statusEdit.options).map(opt => ({ value: opt.value, text: opt.text }));

    layananEdit.addEventListener("change", function() {
        if (this.value === "Poli Gigi") {
            setSelectOptions(statusEdit, ["Rawat Jalan", "Observasi"], allStatusEdit, "Pilih Status");
        } else if (this.value === "Poli Umum") {
            setSelectOptions(statusEdit, ["Rawat Inap", "Rawat Jalan", "Observasi", "Pasca Rawat Inap"], allStatusEdit, "Pilih Status");
        } else {
            setSelectOptions(statusEdit, [], allStatusEdit, "Pilih Status");
        }
    });

    $('#modalEditPasien').on('shown.bs.modal', function() {
        const currentLayanan = layananEdit.value;
        const currentStatus = statusEdit.value;

        if (currentLayanan === "Poli Gigi") {
            setSelectOptions(statusEdit, ["Rawat Jalan", "Observasi"], allStatusEdit, "Pilih Status");
        } else if (currentLayanan === "Poli Umum") {
            setSelectOptions(statusEdit, ["Rawat Inap", "Rawat Jalan", "Observasi", "Pasca Rawat Inap"], allStatusEdit, "Pilih Status");
        } else {
            setSelectOptions(statusEdit, [], allStatusEdit, "Pilih Status");
        }

        statusEdit.value = currentStatus || "";
    });

    // Validasi sebelum submit
    const formAdd = document.querySelector("#formAddPasien");
    const formEdit = document.querySelector("#formEditPasien");

    function validateSelects(event) {
        const selects = event.target.querySelectorAll("select[required]");
        for (const sel of selects) {
            if (!sel.value) {
                sel.focus();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    html: `Harap pilih ${sel.previousElementSibling.textContent}`
                });
                event.preventDefault();
                return false;
            }
        }
    }

    formAdd.addEventListener("submit", validateSelects);
    formEdit.addEventListener("submit", validateSelects);

});