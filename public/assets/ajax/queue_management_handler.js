$(document).ready(function(){

    function loadQueueData(searchOnly = false){
        // Jika searchOnly true, ambil value dari input search
        var search = searchOnly ? $('input[name="search"]').val() : '';
        
        $.ajax({
            url: BASE_URL + "components/data/ajax_queue_management.php",
            type: "GET",
            data: {
                tab: activeTab,
                search: search,
                ['link_'+activeTab]: currentPage[activeTab]
            },
            dataType: "json",
            success: function(res){
                var data = res.queues[activeTab];
                var tbody = $('#' + activeTab + ' tbody');
                tbody.empty();

                if(!data || data.data.length === 0){
                    tbody.append('<tr><td colspan="7" class="text-center align-middle">Data tidak ditemukan</td></tr>'); 
                    // Sembunyikan kolom aksi (opsional: hapus atau sembunyikan header)
                    $('#' + activeTab + ' thead th:last').hide(); 
                } else {
                    // Tampilkan kolom aksi kembali jika ada data
                    $('#' + activeTab + ' thead th:last').show();

                    data.data.forEach(function(row){
                        var status = row.status_antrean || '';
                        var statusLower = (typeof status === 'string') ? status.toLowerCase() : '';

                        let actionBtns = '';
                        if (statusLower === 'selesai') {
                            actionBtns = '<span class="badge badge-danger text-white" style="font-size: 16px;padding: 8px 8.2px;">Selesai</span>';
                        } else {
                            var disabledDilayani = (status !== 'Menunggu') ? 'disabled' : '';
                            var disabledSelesai  = (status !== 'Dilayani') ? 'disabled' : '';

                            actionBtns = ''
                                + '<div class="btn-group">'
                                + '  <button class="btn btn-success btn-sm btn-dilayani" data-id="' + row.kode_antrean + '" ' + disabledDilayani + ' title="Ubah status ke Dilayani"><i class="fa fa-user-check" aria-hidden="true"></i></button>'
                                + '  <button class="btn btn-danger btn-sm btn-selesai" data-id="' + row.kode_antrean + '" ' + disabledSelesai + ' title="Pindahkan ke Selesai"><i class="fa fa-user-slash" aria-hidden="true"></i></button>'
                                + '</div>';
                        }

                        var highlightClass = '';
                        if(lastUpdatedQueue.kode === row.kode_antrean &&
                        lastUpdatedQueue.status === row.status_antrean &&
                        lastUpdatedQueue.waktu === (row.waktu_selesai || row.waktu_daftar)){
                            highlightClass = 'table-success';
                        }

                        tbody.append(
                            '<tr class="' + highlightClass + '">' +

                                '<td class="text-center align-middle" data-header="Kode Antrean">' +
                                    '<div class="td-value">' + (row.kode_antrean || '-') + '</div>' +
                                '</td>' +

                                '<td class="text-center align-middle" data-header="Username">' +
                                    '<div class="td-value">' + (row.username || '-') + '</div>' +
                                '</td>' +

                                '<td class="text-center align-middle" data-header="Nama">' +
                                    '<div class="td-value">' + (row.nama_user || '-') + '</div>' +
                                '</td>' +

                                '<td class="text-center align-middle" data-header="Layanan">' +
                                    '<div class="td-value">' + (row.layanan || '-') + '</div>' +
                                '</td>' +

                                '<td class="text-center align-middle" data-header="Jenis Antrean">' +
                                    '<div class="td-value">' + (row.kategori || '-') + '</div>' +
                                '</td>' +

                                '<td class="text-center align-middle" data-header="Status">' +
                                    '<div class="td-value">' + (row.status_antrean || 'Menunggu') + '</div>' +
                                '</td>' +

                                '<td class="text-center align-middle" data-header="Aksi">' +
                                    '<div class="td-value">' + actionBtns + '</div>' +
                                '</td>' +
                            '</tr>'
                        );
                    });
                }

                // ======================== INFO TEXT ========================
                var labelText = '(' + activeTab.toUpperCase() + ')';
                var infoText = '';
                var countText = data.total_active || 0;

                if (search === '') {
                    infoText = 'Jumlah data antrean aktif pasien';
                } else {
                    infoText = 'Hasil pencarian data pada antrean aktif';
                }

                $('#' + activeTab + '-info').text(infoText + ' ');
                $('#' + activeTab + '-category').text(labelText + ' ');
                $('#' + activeTab + '-count').text(countText);

                totalPage[activeTab] = data.total_page || 1;

                // Pagination
                if(data.current_page <= 1){
                    $('#' + activeTab + '-prev').hide();
                } else {
                    $('#' + activeTab + '-prev').show();
                }

                if(data.current_page >= data.total_page){
                    $('#' + activeTab + '-next').hide();
                    $('#' + activeTab + '-prev').removeClass('mr-3');
                } else {
                    $('#' + activeTab + '-next').show();
                    if(data.current_page > 1){
                        $('#' + activeTab + '-prev').addClass('mr-3');
                    }
                }
            },
            error: function(xhr, status, err){
                console.error('Error loadQueueData:', status, err);
                var tbody = $('#' + activeTab + ' tbody');
                tbody.empty();
                tbody.append('<tr><td colspan="8" class="text-center align-middle">Gagal memuat data (lihat console)</td></tr>');
            }
        });
    }

    // Tab switch
    $('a[data-tab]').on('click', function(e){
        e.preventDefault();
        var clickedTab = $(this).data('tab');

        // Jika tab yang diklik sama dengan activeTab atau berbeda, reset page
        currentPage[clickedTab] = 1;

        // Update activeTab
        activeTab = clickedTab;

        // Update tampilan tab
        $('a[data-tab]').removeClass('active');
        $(this).addClass('active');
        $('.tab-pane').removeClass('show active');
        $('#' + clickedTab).addClass('show active');

        lastUpdatedQueue = { kode: null, status: null, waktu: null };

        // Load data
        loadQueueData();
    });

    // Search form submit (hanya tombol search)
    $('#searchForm').on('submit', function(e){
        e.preventDefault();
        currentPage[activeTab] = 1;
        lastUpdatedQueue = { kode: null, status: null, waktu: null };
        loadQueueData(true); // true = ambil value search
    });

    // Cegah submit form saat tekan Enter di input search
    $('#searchForm input[name="search"]').on('keypress', function(e){
        if(e.which === 13){ // Enter
            e.preventDefault();
        }
    });

    // Pagination
    $('a[id$="-prev"]').on('click', function(){
        var tab = $(this).attr('id').replace('-prev','');
        if(currentPage[tab] > 1){
            currentPage[tab]--;
            lastUpdatedQueue = { kode: null, status: null, waktu: null };
            loadQueueData();
        }
    });
    $('a[id$="-next"]').on('click', function(){
        var tab = $(this).attr('id').replace('-next','');
        if(currentPage[tab] < totalPage[tab]){
            currentPage[tab]++;
            lastUpdatedQueue = { kode: null, status: null, waktu: null };
            loadQueueData();
        }
    });

    // Update status
    $(document).on('click', '.btn-dilayani, .btn-selesai', function(){
        var id = $(this).data('id');
        var isDilayani = $(this).hasClass('btn-dilayani');
        var action = isDilayani ? 'to_dilayani' : 'to_selesai';

        if(!id){
            Swal.fire('Data tidak valid', 'Kode antrean tidak ditemukan.', 'warning');
            return;
        }

        var iconColor = isDilayani ? '#28a745' : '#dc3545';
        var confirmText = isDilayani 
            ? '<strong><i class="fa fa-user-check mr-2" aria-hidden="true"></i>Ya, Lakukan</strong>'
            : '<strong><i class="fa fa-user-slash mr-2" aria-hidden="true"></i>Ya, Lakukan</strong>';
        var infoText = isDilayani 
            ? `Apakah Anda yakin ingin mengubah status antrean <strong>${id}</strong> ini menjadi <b class="text-success">DILAYANI</b> ?`
            : `Apakah Anda yakin ingin mengubah status antrean <strong>${id}</strong> ini menjadi <b class="text-danger">SELESAI</b> ?`;

        Swal.fire({
            title: 'Konfirmasi Aksi',
            html: infoText,
            icon: 'warning',
            iconColor: iconColor,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: '<strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>',
            reverseButtons: true,
            buttonsStyling: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'swal2-card',
                confirmButton: isDilayani 
                    ? 'swal2-confirm-button swal2-success-confirm' 
                    : 'swal2-confirm-button swal2-danger-confirm',
                cancelButton: 'swal2-cancel-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: BASE_URL + "components/data/ajax_queue_management.php",
                    type: "POST",
                    data: { action: action, kode_antrean: id },
                    dataType: "json",
                    success: function(res){
                        Swal.close();

                        if(res.success && res.updated_queue){
                            lastUpdatedQueue = {
                                kode: res.updated_queue.kode_antrean,
                                status: res.updated_queue.status_antrean,
                                waktu: res.updated_queue.waktu
                            };
                        }

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: res.success ? 'success' : 'error',
                            html: res.message,
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });

                        loadQueueData();
                    },
                    error: function(){
                        Swal.close();
                        Swal.fire('Gagal', 'Terjadi kesalahan saat mengirim aksi.', 'error');
                    }
                });
            }
        });
    });


    // Initial load tanpa search
    loadQueueData();

    // Auto refresh setiap 10 detik, tapi hanya jika search kosong
    setInterval(function(){
        if($('input[name="search"]').val() === ''){
            loadQueueData();
        }
    }, 10000);
});