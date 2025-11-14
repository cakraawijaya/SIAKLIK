<?php

    session_start();
    include __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../../vendor/autoload.php';

    use Dompdf\Dompdf;

    $dompdf = new Dompdf();

    // Ambil data semua admin
    $query = mysqli_query($koneksi, "SELECT * FROM akun_pekerja WHERE role_id = 1") or die(mysqli_error($koneksi));

    $dataUsers = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $dataUsers[] = $row;
    }

    // ===== NATURAL SORT EMAIL =====
    function naturalSortEmail($a, $b) {
        $emailA = strtolower($a['email']);
        $emailB = strtolower($b['email']);

        preg_match_all('/\d+|\D+/', $emailA, $matchesA);
        preg_match_all('/\d+|\D+/', $emailB, $matchesB);

        $blocksA = array_map(function($block) {
            return is_numeric($block) ? (int)$block : $block;
        }, $matchesA[0]);

        $blocksB = array_map(function($block) {
            return is_numeric($block) ? (int)$block : $block;
        }, $matchesB[0]);

        $len = min(count($blocksA), count($blocksB));
        for ($i = 0; $i < $len; $i++) {
            if ($blocksA[$i] === $blocksB[$i]) continue;
            if (is_int($blocksA[$i]) && is_int($blocksB[$i])) return $blocksA[$i] - $blocksB[$i];
            return strcmp($blocksA[$i], $blocksB[$i]);
        }
        return count($blocksA) - count($blocksB);
    }

    usort($dataUsers, 'naturalSortEmail');

    // ===== Logo =====
    $logoPath = __DIR__ . '/../../public/assets/img/brand/logo.png';
    $logoData = base64_encode(file_get_contents($logoPath));

    // ===== HTML =====
    $html = '<html><head>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 20px; }
        .header { display: flex; align-items: center; margin-bottom: 20px; }
        .header img { height: 80px; width: 80px; margin-right: 15px; }
        .header .text-group { display: flex; flex-direction: column; justify-content: center; }
        .header .text-group h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header .text-group p { margin: 2px 0 0 0; font-size: 14px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; font-size: 11px; }
        table th { background-color: #639c1f; color: white; text-transform: uppercase; }
        table tr:nth-child(even){background-color: #f2f2f2;}
        table td { text-align: left; vertical-align: middle; }
        .footer { width: 100%; margin-top: 20px; font-size: 12px; }
        .footer p { margin: 5px 0; }
        .right { text-align: right; }
        img.user-photo { border-radius: 6px; object-fit: cover; }
    </style>
    </head><body>';

    $html .= '<div class="header">
        <img src="data:image/png;base64,' . $logoData . '" alt="Logo">
        <div class="text-group">
            <h1>SIAKLIK</h1>
            <p>Laporan Data Pengguna SIAKLIK Kategori <strong>Admin</strong></p>
        </div>
    </div>';

    $html .= '<table>
        <tr>
            <th style="width:5%;">FOTO</th>
            <th style="width:25%;">EMAIL</th>
            <th style="width:20%;">USERNAME</th>
            <th style="width:50%;">NAMA</th>
        </tr>';

    $basePath = __DIR__ . '/../../public/assets/img/user_photo/';
    $defaultPath = $basePath . 'default.png';

    foreach ($dataUsers as $row) {
        $fotoFile = $row['foto'] ?: 'default.png';
        $fotoPath = $basePath . $fotoFile;

        if (file_exists($fotoPath)) {
            $fotoData = base64_encode(file_get_contents($fotoPath));
            $fotoType = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoSrc = 'data:image/' . $fotoType . ';base64,' . $fotoData;
        } else {
            $fotoData = base64_encode(file_get_contents($defaultPath));
            $fotoType = pathinfo($defaultPath, PATHINFO_EXTENSION);
            $fotoSrc = 'data:image/' . $fotoType . ';base64,' . $fotoData;
        }

        $html .= "
            <tr>
                <td><img class='user-photo' src='$fotoSrc' width='60' height='60'></td>
                <td>{$row['email']}</td>
                <td>{$row['username']}</td>
                <td>{$row['nama']}</td>
            </tr>";
    }

    $count = count($dataUsers);

    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $tgl = date('d');
    $bln = $bulan[date('m')-1];
    $thn = date('Y');
    $hr  = $hari[date('w')];

    $html .= '</table>
    <div class="footer">
        <p class="right">Jumlah data user (Admin): <b>' . $count . '</b></p>
        <p class="right">Tanggal: <b>' . $hr . ', ' . $tgl . ' ' . $bln . ' ' . $thn . '</b></p>
    </div>
    </body></html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('data_user_admin.pdf');

?>