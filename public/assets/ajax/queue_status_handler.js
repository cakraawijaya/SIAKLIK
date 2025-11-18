$(document).ready(function(){
    function loadQueueData(searchOnly = false){
        // Jika searchOnly true, ambil value dari input search
        var search = searchOnly ? $('input[name="search"]').val() : '';
        
        $.ajax({
            url: BASE_URL + "components/data/ajax_queue_status.php",
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

                // Jika halaman kosong dan ada halaman lain, pindah otomatis
                if(data.data.length === 0){
                    if(currentPage[activeTab] < (data.total_page || 1)){
                        // Naik ke halaman berikutnya
                        currentPage[activeTab]++;
                        loadQueueData(searchOnly);
                        return;
                    } else if(currentPage[activeTab] > 1){
                        // Turun ke halaman sebelumnya
                        currentPage[activeTab]--;
                        loadQueueData(searchOnly);
                        return;
                    }
                }

                tbody.empty();

                if(!data || data.data.length === 0){
                    tbody.append('<tr><td colspan="8" class="text-center align-middle">Data tidak ditemukan</td></tr>');
                } else {
                    data.data.forEach(function(row){
                        tbody.append(
                            '<tr>'+
                                '<td class="text-center align-middle">'+(row.kode_antrean||'-')+'</td>' +
                                '<td class="text-center align-middle">'+(row.nama_user||'-')+'</td>'+
                                '<td class="text-center align-middle">'+(row.layanan_terkini||'-')+'</td>' +
                                '<td class="text-center align-middle">'+(row.kategori||'-')+'</td>' +
                                '<td class="text-center align-middle">'+(row.status_antrean||'Menunggu')+'</td>' +
                            '</tr>'
                        );
                    });
                }

                // ======================== INFO TEXT ========================
                var labelText = '(' + activeTab.toUpperCase() + ')';
                var infoText = '';
                var countText = data.total_data || 0;

                if (search === '') {
                    infoText = 'Jumlah data antrean pasien';
                } else {
                    infoText = 'Hasil pencarian data antrean pasien';
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

        // Load data
        loadQueueData();
    });

    // Search form submit (hanya tombol search)
    $('#searchForm').on('submit', function(e){
        e.preventDefault();
        currentPage[activeTab] = 1;
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
            loadQueueData();
        }
    });
    $('a[id$="-next"]').on('click', function(){
        var tab = $(this).attr('id').replace('-next','');
        if(currentPage[tab] < totalPage[tab]){
            currentPage[tab]++;
            loadQueueData();
        }
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