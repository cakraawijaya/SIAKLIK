<?php

    session_start();
    include __DIR__ . '/../../../../config/config.php';
    require_once __DIR__ . '/../../../../vendor/autoload.php';
    use Dompdf\Dompdf;

    $dompdf = new Dompdf();
    $query = mysqli_query($koneksi, "SELECT * FROM riwayat_pasien") or die(mysqli_error($koneksi));

    $logoPath = __DIR__ . '/../../../../public/assets/img/favicon/logo.png';
    $logoData = base64_encode(file_get_contents($logoPath));

    $html = '<html><head>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 20px; }
        /* Header utama */
        .header { display: flex; align-items: center; margin-bottom: 20px; }
        /* Logo */
        .header img { height: 80px; width: 80px; margin-right: 15px; }
        /* Grup teks judul dan subjudul */
        .header .text-group { display: flex; flex-direction: column; justify-content: center; }
        .header .text-group h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header .text-group p { margin: 2px 0 0 0; font-size: 14px; }
        /* Tabel data pasien */
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; font-size: 11px; }
        table th { background-color: #639c1f; color: white; text-transform: uppercase; }
        table tr:nth-child(even){background-color: #f2f2f2;}
        table td { text-align: left; }
        /* Footer */
        .footer { width: 100%; margin-top: 20px; font-size: 12px; }
        .footer p { margin: 5px 0; }
        .right { text-align: right; }
    </style>
    </head><body>';

    // Header: logo + judul + subjudul di kiri, vertical center
    $html .= '<div class="header">
        <img src="data:image/png;base64,' . $logoData . '" alt="Logo">
        <div class="text-group">
            <h1>SIAKLIK</h1>
            <p>Laporan Data Pasien Poliklinik</p>
        </div>
    </div>';

    $html .= '<table>
        <tr>
            <th>ID</th>
            <th>NAMA</th>
            <th>UMUR</th>
            <th>ALAMAT</th>
            <th>PEKERJAAN</th>
            <th>STATUS</th>
            <th>JK</th>
            <th>NIM/NIP</th>
            <th>NO BPJS</th>
            <th>LAYANAN</th>
            <th>KET</th>
            <th>WAKTU PENCATATAN</th>
        </tr>';

    while ($row = mysqli_fetch_array($query)) {
        $html .= "<tr>
            <td>".$row['id']."</td>
            <td>".$row['nama']."</td>
            <td>".$row['umur']."</td>
            <td>".$row['alamat']."</td>
            <td>".$row['pekerjaan']."</td>
            <td>".$row['status']."</td>
            <td>".$row['jenis_kelamin']."</td>
            <td>".$row['nim_nip']."</td>
            <td>".$row['no_bpjs']."</td>
            <td>".$row['layanan']."</td>
            <td>".$row['keterangan']."</td>
            <td>".$row['waktu']."</td>
        </tr>";
    }

    $count = mysqli_num_rows($query);

    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $tgl = date('d');
    $bln = $bulan[date('m')-1];
    $thn = date('Y');
    $hr  = $hari[date('w')];

    $html .= '</table>';

    $html .= '<div class="footer">
        <p class="right">Jumlah data pasien : <b>'.$count.'</b></p>
        <p class="right">Tanggal : <b>'.$hr.', '.$tgl.' '.$bln.' '.$thn.'</b></p>
    </div>';

    $html .= '</body></html>';

    // Render PDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('data_pasien_poliklinik.pdf');

?>