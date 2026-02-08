// Membuat grafik Highcharts pada elemen dengan id "container"
Highcharts.chart('container', {

  /* =========================== KONFIGURASI UTAMA GRAFIK ========================== */
  chart: {
    type: 'column', // Tipe grafik -> berbentuk batang vertikal

    events: { // Event-event yang berkaitan dengan grafik :
      render: function () { // Event yang dijalankan setiap grafik selesai dirender

        // Interval untuk menunggu sampai tabel data Highcharts tersedia di DOM
        var watcher = setInterval(function () {

          // Mengambil tabel data Highcharts
          var table = document.querySelector('.highcharts-data-table table');

          if (table) { // Jika tabel sudah ada, maka :

            // Mengambil baris header tabel
            var thead = table.querySelector('thead tr');

            // Jika header ada dan memiliki minimal 2 kolom, maka :
            if (thead && thead.cells.length >= 2) {
              thead.cells[0].textContent = 'Satker';   // Mengubah header kolom pertama (Satker)
              thead.cells[1].textContent = 'Jumlah';   // Mengubah header kolom kedua (Jumlah)
            }

            // Mengambil body tabel
            var tbody = table.querySelector('tbody');

            // Jika body tabel ada, maka :
            if (tbody) {

              // Loop setiap baris tabel
              tbody.querySelectorAll('tr').forEach(function(row) {

                // Mengambil kolom pertama di setiap baris
                var firstCell = row.cells[0];

                if (firstCell) { // Jika kolom pertama ada, maka :

                  // Menambahkan class CSS ke kolom Satker
                  firstCell.classList.add('highcharts-label');
                }
              });
            }

            // Menghentikan interval setelah tabel ditemukan dan dimodifikasi
            clearInterval(watcher);
          }

        }, 100); // Mengecek setiap 100 ms
      }
    }
  },


  /* ======================== JUDUL, SUBJUDUL, AXIS, & LEGEND ====================== */
  title: { text: '' },                // Judul utama grafik (kosong)
  subtitle: { text: '' },             // Subjudul grafik (kosong)

  // Konfigurasi sumbu X
  xAxis: { type: 'category' },        // Sumbu X berbasis kategori

  // Konfigurasi sumbu Y
  yAxis: { title: { text: '' } },     // Judul sumbu Y dikosongkan

  // Konfigurasi legend
  legend: { enabled: false },         // Legend dimatikan


  /* ============================= OPSI TAMPILAN SERIES ============================ */
  plotOptions: {
    series: {
      borderWidth: 0,                 // Ketebalan border bar
      dataLabels: {
        enabled: true,                // Menampilkan label data
        allowOverlap: true,           // Mengizinkan label bertumpuk
        crop: false,                  // Tidak memotong label
        overflow: 'allow',            // Mengizinkan label keluar area grafik
        format: '{point.y}'           // Format label menampilkan nilai Y
      }
    }
  },


  /* ============================= KONFIGURASI TOOLTIP ============================= */
  tooltip: {
    headerFormat: '<span style="font-size:18px;">{series.name}</span><br>', // Header tooltip
    pointFormat: '<span style="color:black;">{point.name}</span>: Total (<b>{point.y}</b>)<br/>' // Isi tooltip
  },


  /* ============================= DATA SERIES GRAFIK ============================== */
  series: [{
    name: "Satker",        // Nama series
    colorByPoint: true,    // Warna berbeda tiap bar
    data: [
      { name: "FTI"     , y: 43  },   // Data Satker FTI
      { name: "FAD"     , y: 52  },   // Data Satker FAD
      { name: "FH"      , y: 137 },   // Data Satker FH
      { name: "PASCA"   , y: 11  },   // Data Satker PASCA
      { name: "FE"      , y: 37  },   // Data Satker FE
      { name: "FISIP"   , y: 163 },   // Data Satker FISIP
      { name: "FIK"     , y: 41  },   // Data Satker FIK
      { name: "FTSP"    , y: 3   },   // Data Satker FTSP
      { name: "FEB"     , y: 150 },   // Data Satker FEB
      { name: "Anak"    , y: 1   },   // Data Satker Anak
      { name: "FT"      , y: 103 },   // Data Satker FT
      { name: "Rektorat", y: 479 },   // Data Satker Rektorat
      { name: "Koperasi", y: 10  },   // Data Satker Koperasi
      { name: "FP"      , y: 108 }    // Data Satker FP
    ]
  }],


  /* =========================== KONFIGURASI FITUR EXPORT ========================== */
  exporting: {
    enabled: true,    // Mengaktifkan export
    showTable: true,  // Menampilkan tabel data
    tableCaption: 'Kunjungan Pasien Berdasarkan Satker — 2019', // Caption tabel

    csv: {
      columnHeaderFormatter: function(item) {
        if (!item) return 'Satker';  // Header kolom pertama CSV
        return 'Jumlah';             // Header kolom kedua CSV
      }
    }
  }

});