Highcharts.chart('container', {
  chart: {
    type: 'column',
    events: {
      render: function () {
        var watcher = setInterval(function () {
          var table = document.querySelector('.highcharts-data-table table');
          if (table) {
            // Mengubah header tabel (Satker & Jumlah)
            var thead = table.querySelector('thead tr');
            if (thead && thead.cells.length >= 2) {
              thead.cells[0].textContent = 'Satker';   // Header kolom pertama
              thead.cells[1].textContent = 'Jumlah';   // Header kolom kedua
            }
            // Menambahkan class ke kolom Satker
            var tbody = table.querySelector('tbody');
            if (tbody) {
              tbody.querySelectorAll('tr').forEach(function(row) {
                var firstCell = row.cells[0];
                if (firstCell) {
                  firstCell.classList.add('highcharts-label');
                }
              });
            }
            clearInterval(watcher);
          }
        }, 100);
      }
    }
  },
  title: {
    text: ''
  },
  subtitle: {
    text: ''
  },
  xAxis: {
    type: 'category'
  },
  yAxis: {
    title: {
      text: ''
    }
  },
  legend: {
    enabled: false
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        allowOverlap: true,
        crop: false,
        overflow: 'allow',
        format: '{point.y}'
      }
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:18px;">{series.name}</span><br>',
    pointFormat: '<span style="color:black;">{point.name}</span>: Total (<b>{point.y}</b>)<br/>'
  },
  series: [
    {
      name: "Satker",
      colorByPoint: true,
      data: [
        {
          name: "FAD",
          y: 20
        },
        {
          name: "FH",
          y: 10
        },
        {
          name: "PASCA",
          y: 4
        },
        {
          name: "FISIP",
          y: 74
        },
        {
          name: "FEB",
          y: 112
        },
        {
          name: "FT",
          y: 85
        },
        {
          name: "Rektorat",
          y: 96
        },
        {
          name: "Koperasi",
          y: 3
        },
        {
          name: "FP",
          y: 76
        }
      ]
    }
  ],
  exporting: {
    enabled: true,
    showTable: true,
    tableCaption: 'Kunjungan Pasien Berdasarkan Satker — 2014',
    csv: {
      columnHeaderFormatter: function(item) {
        if (!item) return 'Satker';  // header pertama
        return 'Jumlah';             // header kedua
      }
    }
  }
});