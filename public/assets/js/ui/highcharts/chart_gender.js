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
                    thead.cells[0].textContent = 'Jenis Kelamin';   // kolom kategori
                    thead.cells[1].textContent = 'Jumlah';  // kolom data
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
      name: "Pasien",
      colorByPoint: true,
      data: [
        {
          name: "Laki-Laki",
          y: 3968
        },
        {
          name: "Perempuan",
          y: 2546
        }
      ]
    }
  ],
  exporting: {
    enabled: true,
    showTable: true,
    tableCaption: 'Kunjungan Pasien Berdasarkan Jenis Kelamin',
    csv: {
      columnHeaderFormatter: function(item) {
        if (!item) return 'Jenis Kelamin';  // header pertama
        return 'Jumlah';                    // header kedua
      }
    }
  }
});