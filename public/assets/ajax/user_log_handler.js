$(document).ready(function () {

    // ======================== LOAD DATA ========================
    function loadLogData(searchOnly = false) {
        // Jika searchOnly true, ambil value dari input search
        var search = searchOnly ? $('input[name="search"]').val() : '';

        $.ajax({
            url: BASE_URL + "components/data/ajax_user_log.php",
            type: "GET",
            data: {
                tab: activeTab,
                search: search,
                ['link_' + activeTab]: currentPage[activeTab]
            },
            dataType: "json",
            success: function (res) {
                var data = res.logs[activeTab];
                var tbody = $('#' + activeTab + ' tbody');

                // Jika halaman kosong dan ada halaman lain, pindah otomatis
                if(data.data.length === 0){
                    if(currentPage[activeTab] < (data.total_page || 1)){
                        // Naik ke halaman berikutnya
                        currentPage[activeTab]++;
                        loadLogData(searchOnly);
                        return;
                    } else if(currentPage[activeTab] > 1){
                        // Turun ke halaman sebelumnya
                        currentPage[activeTab]--;
                        loadLogData(searchOnly);
                        return;
                    }
                }

                tbody.empty();

                if(!data || data.data.length === 0){
                    tbody.append('<tr><td colspan="5" class="text-center align-middle" data-header="Pemberitahuan Sistem"><div class="td-value">Data tidak ditemukan</div></td></tr>');
                } else {
                    data.data.forEach(function(row){
                        tbody.append(
                            `<tr>
                                <td class="text-center align-middle" data-header="Waktu">
                                    <div class="td-value">
                                        ${row.created_at}
                                    </div>
                                </td>

                                <td class="text-center align-middle" data-header="Username">
                                    <div class="td-value">
                                        ${row.username || '-'}
                                    </div>
                                </td>

                                <td class="text-center align-middle" data-header="Role">
                                    <div class="td-value">
                                        ${labelMap[row.role] || row.role}
                                    </div>
                                </td>

                                <td class="text-center align-middle" data-header="Aktivitas">
                                    <div class="td-value">
                                        ${row.aksi || '-'}
                                    </div>
                                </td>

                                <td class="text-center align-middle" data-header="Detail">
                                    <div class="td-value">
                                        ${row.detail || '-'}
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                }

                // ======================== INFO TEXT ========================
                var labelText = '(' + activeTab.toUpperCase() + ')';
                var infoText = '';
                var countText = data.total_data || 0;

                if (search === '') {
                    infoText = '';
                } else {
                    infoText = 'Hasil pencarian log aktivitas';
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
            error: function (xhr, status, err) {
                console.error('Error loadLogData:', status, err);
                var tbody = $('#' + activeTab + ' tbody');
                tbody.empty();
                tbody.append('<tr><td colspan="5" class="text-center align-middle" data-header="Pemberitahuan Sistem"><div class="td-value">Gagal memuat data (lihat console)</div></td></tr>');
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

        // Load data
        loadLogData();
    });

    // Search form submit (hanya tombol search)
    $('#searchForm').on('submit', function(e){
        e.preventDefault();
        currentPage[activeTab] = 1;
        loadLogData(true); // true = ambil value search
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
            loadLogData();
        }
    });
    $('a[id$="-next"]').on('click', function(){
        var tab = $(this).attr('id').replace('-next','');
        if(currentPage[tab] < totalPage[tab]){
            currentPage[tab]++;
            loadLogData();
        }
    });

    // Initial load tanpa search
    loadLogData();

    // Auto refresh setiap 10 detik, tapi hanya jika search kosong
    setInterval(function () {
        if ($('input[name="search"]').val() === '') {
            loadLogData();
        }
    }, 10000);

});