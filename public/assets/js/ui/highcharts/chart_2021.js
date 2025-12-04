// Create the chart
Highcharts.chart('container', {
  chart: {
    type: 'column',
    events: {
      load: function() {
        var chart = this;
        setTimeout(function() {
            var table = document.querySelector('.highcharts-data-table table');
            if (table) {
                var thead = table.querySelector('thead tr');
                if (thead && thead.cells.length >= 2) {
                    thead.cells[0].textContent = 'Satker';   // kolom kategori
                    thead.cells[1].textContent = 'Jumlah';   // kolom data
                }
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
          name: "FTI",
          y: 3
        },
        {
          name: "FAD",
          y: 12
        },
        {
          name: "FH",
          y: 13
        },
        {
          name: "FE",
          y: 1
        },
        {
          name: "PASCA",
          y: 4
        },
        {
          name: "FISIP",
          y: 14
        },
        {
          name: "FIK",
          y: 12
        },
        {
          name: "FTSP",
          y: 1
        },
        {
          name: "FEB",
          y: 28
        },
        {
          name: "Anak",
          y: 1
        },
        {
          name: "FT",
          y: 10
        },
        {
          name: "Rektorat",
          y: 114
        },
        {
          name: "Koperasi",
          y: 5
        },
        {
          name: "FP",
          y: 24
        }
      ]
    }
  ],
  exporting: {
    enabled: true,
    showTable: true,
    tableCaption: 'Kunjungan Pasien Berdasarkan Satker — 2021',
    csv: {
      columnHeaderFormatter: function(item) {
        if (!item) return 'Satker';  // header pertama
        return 'Jumlah';             // header kedua
      }
    }
  }
});