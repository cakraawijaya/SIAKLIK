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
            success: function(res) {
                var logs = res.logs[activeTab];
                var tbody = $('#' + activeTab + ' tbody');
                tbody.empty();

                if (!logs.data || logs.data.length === 0) {
                    tbody.append('<tr><td colspan="5" class="text-center align-middle" data-header="Pemberitahuan Sistem"><div class="td-value">Data tidak ditemukan</div></td></tr>');
                } else {
                    logs.data.forEach(function(row) {
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
                                        ${row.role}
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


                // ======================== PAGINATION =======================
                totalPage[activeTab] = logs.total_page || 1;

                if (logs.current_page <= 1) {
                    $('#' + activeTab + '-prev').hide();
                } else {
                    $('#' + activeTab + '-prev').show();
                }

                if (logs.current_page >= logs.total_page) {
                    $('#' + activeTab + '-next').hide();
                    $('#' + activeTab + '-prev').removeClass('mr-3');
                } else {
                    $('#' + activeTab + '-next').show();
                    if (logs.current_page > 1) {
                        $('#' + activeTab + '-prev').addClass('mr-3');
                    }
                }
            },
            error: function (xhr, status, err) {
                console.error('Error loadLogData:', status, err);
                var tbody = $('#' + activeTab + ' tbody');
                tbody.empty().append('<tr><td colspan="5" class="text-center align-middle" data-header="Pemberitahuan Sistem"><div class="td-value">Gagal memuat data (lihat console)</div></td></tr>');
            }
        });
    }


    // ======================== TAB SWITCH =======================
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


    // ======================= AUTO REFRESH ======================
    setInterval(function () {
        if ($('input[name="search"]').val() === '') {
            loadLogData();
        }
    }, 10000);

});