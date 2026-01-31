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
    // Query ini digunakan untuk mengambil seluruh data user (pekerja) dari tabel akun_pekerja
    $query = mysqli_query($koneksi, "
        SELECT * FROM akun_pekerja WHERE role_id = 2 ORDER BY
        REGEXP_REPLACE(email, '[0-9]', '') ASC,
        CAST(REGEXP_SUBSTR(email, '[0-9]+') AS UNSIGNED) ASC, email ASC
    ") or die(mysqli_error($koneksi));


    // ===========================================================================================
    // PENGOLAHAN LOGO SIAKLIK
    // ===========================================================================================
    // Menentukan path logo SIAKLIK yang akan digunakan di PDF
    $logoPath = __DIR__ . '/../../../../public/assets/img/favicon/logo.png';

    // Membaca file logo dan mengubahnya menjadi format base64 agar bisa ditampilkan di PDF
    $logoData = base64_encode(file_get_contents($logoPath));


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
        /* Tabel data user (pekerja) */
        thead { display: table-header-group; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; font-size: 11px; }
        table th { background-color: #639c1f; color: white; text-transform: uppercase; }
        table tr:nth-child(even) { background-color: #f2f2f2; }
        table td { text-align: left; vertical-align: middle; }
        tfoot { display: table-footer-group; }
        img.user-photo { border-radius: 6px; object-fit: cover; }
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
            <p>Laporan Data User (Pekerja) Poliklinik</p>
        </div>
    </div>';


    // ===========================================================================================
    // STRUKTUR TABEL LAPORAN
    // ===========================================================================================
    $html .= '<table>
        <thead>
            <tr>
                <th style="width:5%;">FOTO</th>
                <th style="width:25%;">EMAIL</th>
                <th style="width:20%;">USERNAME</th>
                <th style="width:50%;">NAMA</th>
            </tr>
        </thead>
        <tbody>
    ';


    // ===========================================================================================
    // DATA TABEL LAPORAN
    // ===========================================================================================
    $basePath = __DIR__ . '/../../../../public/assets/img/photo/'; // Path dasar folder foto user

    // Path foto default jika foto user tidak ada atau tidak ditemukan
    $defaultPath = $basePath . 'default.png';

    // Loop data hasil query satu per satu
    while ($row = mysqli_fetch_array($query)) {

        // Ambil nama file foto dari database, jika kosong maka gunakan "default.png"
        $fotoFile = $row['foto'] ?: 'default.png';

        // Gabungkan base path dengan nama file foto
        $fotoPath = $basePath . $fotoFile;

        // Cek apakah file foto benar-benar ada di folder
        if (file_exists($fotoPath)) {

            // Baca file foto dan encode ke base64
            $fotoData = base64_encode(file_get_contents($fotoPath));

            // Ambil ekstensi file (jpg, png, dll)
            $fotoType = pathinfo($fotoPath, PATHINFO_EXTENSION);

            // Susun src gambar dengan format data URI
            $fotoSrc = 'data:image/' . $fotoType . ';base64,' . $fotoData;

        } else { // Jika foto user tidak ada, maka :

            // Gunakan foto default
            $fotoData = base64_encode(file_get_contents($defaultPath));

            // Ambil ekstensi foto default
            $fotoType = pathinfo($defaultPath, PATHINFO_EXTENSION);

            // Susun src gambar default dengan format data URI
            $fotoSrc = 'data:image/' . $fotoType . ';base64,' . $fotoData;
        }

        $html .= "
            <tr>
                <td><img class='user-photo' src='$fotoSrc' width='60' height='60'></td>
                <td>".$row['email']."</td>
                <td>".$row['username']."</td>
                <td>".$row['nama']."</td>
            </tr>
        ";
    }


    // ===========================================================================================
    // PENGOLAHAN INFORMASI TAMBAHAN
    // ===========================================================================================
    $count = mysqli_num_rows($query); // Menghitung total jumlah data user (pekerja)

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
        <p class="right">Jumlah data user (Pekerja): <b>'.$count.'</b></p>
        <p class="right">Hari: <b>'.$hr.'</b>, Tanggal: <b>'.$tgl.' '.$bln.' '.$thn.'</b></p>
    </div>';

    $html .= '</body></html>';


    // ===========================================================================================
    // GENERATE & OUTPUT PDF
    // ===========================================================================================
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('user_pekerja_poliklinik.pdf');

?>