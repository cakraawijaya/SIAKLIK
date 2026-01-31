<?php

    // ===========================================================================================
    // KONEKSI DATABASE
    // ===========================================================================================
    include __DIR__ . '/../../../../config/config.php';


    // ===========================================================================================
    // LOAD LIBRARY Dompdf
    // ===========================================================================================
    // Memanggil autoload Composer untuk mengakses library eksternal
    require_once __DIR__ . '/../../../../vendor/autoload.php';

    // Menggunakan namespace Dompdf agar class bisa dipanggil langsung
    use Dompdf\Dompdf;

    $dompdf = new Dompdf(); // Membuat objek baru dari class Dompdf


    // ===========================================================================================
    // PENGAMBILAN DATA DARI DATABASE
    // ===========================================================================================
    // Query ini digunakan untuk mengambil seluruh data dari tabel riwayat_pasien
    $query = mysqli_query($koneksi, "SELECT * FROM riwayat_pasien") or die(mysqli_error($koneksi));


    // ===========================================================================================
    // PENGOLAHAN LOGO SIAKLIK
    // ===========================================================================================
    // Menentukan path logo SIAKLIK yang akan digunakan di PDF
    $logoPath = __DIR__ . '/../../../../public/assets/img/favicon/logo.png';

    // Membaca file logo dan mengubahnya menjadi format base64 agar bisa ditampilkan di PDF
    $logoData = base64_encode(file_get_contents($logoPath));


    // ===========================================================================================
    // FUNGSI ANTI NULL & ANTI DATA KOSONG
    // ===========================================================================================
    function safe($value) {

        // Jika NULL, maka fungsi langsung mengembalikan tanda '-'
        if (is_null($value)) return '-';

        // Jika string kosong, maka fungsi mengembalikan tanda '-'
        if (trim($value) === '') return '-';

        // Jika nilai tidak NULL & tidak kosong, maka :
        // Fungsi mengembalikan nilai sebenarnya
        return $value;
    }


    // ===========================================================================================
    // INISIALISASI STRUKTUR HTML & STYLE PDF
    // ===========================================================================================
    $html = '<html><head>
    <style>
        /* Style dasar halaman */
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 20px; }
        /* Header utama */
        .header { display: flex; align-items: center; margin-bottom: 20px; }
        /* Logo */
        .header img { height: 80px; width: 80px; margin-right: 15px; }
        /* Grup teks judul dan subjudul */
        .header .text-group { display: flex; flex-direction: column; justify-content: center; }
        .header .text-group h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header .text-group p { margin: 2px 0 0 0; font-size: 14px; }
        /* Tabel data riwayat pasien */
        thead { display: table-header-group; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; font-size: 11px; }
        table th { background-color: #639c1f; color: white; text-transform: uppercase; }
        table tr:nth-child(even) { background-color: #f2f2f2; }
        table td { text-align: left; vertical-align: middle; }
        tfoot { display: table-footer-group; }
        /* Footer */
        .footer { width: 100%; margin-top: 20px; font-size: 12px; }
        .footer p { margin: 5px 0; }
        .right { text-align: right; }
    </style>
    </head><body>';


    // ===========================================================================================
    // HEADER LAPORAN (LOGO, JUDUL, SUBJUDUL)
    // ===========================================================================================
    $html .= '<div class="header">
        <img src="data:image/png;base64,' . $logoData . '" alt="Logo">
        <div class="text-group">
            <h1>SIAKLIK</h1>
            <p>Laporan Data Riwayat Pasien Poliklinik</p>
        </div>
    </div>';


    // ===========================================================================================
    // STRUKTUR TABEL LAPORAN
    // ===========================================================================================
    $html .= '<table>
        <thead>
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
                <th>KATEGORI</th>
                <th>KET</th>
                <th>WAKTU PENCATATAN</th>
            </tr>
        </thead>
        <tbody>
    ';


    // ===========================================================================================
    // DATA TABEL LAPORAN
    // ===========================================================================================
    while ($row = mysqli_fetch_array($query)) {
        $html .= "
            <tr>
                <td>".$row['id']."</td>
                <td>".$row['nama']."</td>
                <td>".$row['umur']."</td>
                <td>".$row['alamat']."</td>
                <td>".$row['pekerjaan']."</td>
                <td>".$row['status']."</td>
                <td>".$row['jenis_kelamin']."</td>
                <td>".safe($row['nim_nip'])."</td>
                <td>".safe($row['no_bpjs'])."</td>
                <td>".$row['layanan']."</td>
                <td>".$row['kategori']."</td>
                <td>".safe($row['keterangan'])."</td>
                <td>".$row['waktu']."</td>
            </tr>
        ";
    }


    // ===========================================================================================
    // PENGOLAHAN INFORMASI TAMBAHAN
    // ===========================================================================================
    $count = mysqli_num_rows($query); // Menghitung total jumlah data riwayat pasien

    // Mengatur tanggal cetak
    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $tgl = date('d');
    $bln = $bulan[date('m')-1];
    $thn = date('Y');
    $hr  = $hari[date('w')];

    $html .= '</tbody></table>';


    // ===========================================================================================
    // FOOTER LAPORAN
    // ===========================================================================================
    $html .= '<div class="footer">
        <p class="right">Jumlah data riwayat pasien : <b>'.$count.'</b></p>
        <p class="right">Hari: <b>'.$hr.'</b>, Tanggal: <b>'.$tgl.' '.$bln.' '.$thn.'</b></p>
    </div>';

    $html .= '</body></html>';


    // ===========================================================================================
    // GENERATE & OUTPUT PDF
    // ===========================================================================================
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('riwayat_pasien_poliklinik.pdf');

?>