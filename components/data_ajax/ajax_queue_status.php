<?php
// Otentikasi
$require_login = true;
include __DIR__ . '/../features/patient_auth_check.php';
include __DIR__ . '/../../config/config.php';

$per_page = 6;
$search = $_GET['search'] ?? '';
$active_tab = $_GET['tab'] ?? 'internal';

$pageParams = [
    'internal' => 'link_internal',
    'bpjs'     => 'link_bpjs',
    'umum'     => 'link_umum',
    'selesai'  => 'link_selesai'
];

function get_paginated_data($kategori, $per_page, $page_param = 'link', $search = '') {
    global $koneksi;

    $page = isset($_GET[$page_param]) && $_GET[$page_param] > 1 ? (int)$_GET[$page_param] : 1;
    $offset = ($page - 1) * $per_page;

    $where = "1";
    if ($search !== '') {
        $s = mysqli_real_escape_string($koneksi, $search);
        $where .= " AND a.kode_antrean LIKE '%$s%'";
    }

    if (strtoupper($kategori) === 'SELESAI') {
        $table = 'riwayat_antrean';
    } else {
        $table = 'antrean';
        $where .= " AND a.kategori='$kategori'";
    }

    $data_sql = "
        SELECT a.*, COALESCE(p.nama, w.nama, a.nama) AS nama_user, a.layanan AS layanan_terkini
        FROM $table a
        LEFT JOIN akun_pasien p ON a.username = p.username
        LEFT JOIN akun_pekerja w ON a.username = w.username
        WHERE $where
        ORDER BY a.kode_antrean ASC
        LIMIT $per_page OFFSET $offset
    ";
    $query = mysqli_query($koneksi, $data_sql) or die(mysqli_error($koneksi));

    $count_sql = "SELECT COUNT(*) AS cnt FROM $table a WHERE $where";
    $count_res = mysqli_query($koneksi, $count_sql);
    $count_row = mysqli_fetch_assoc($count_res);
    $total_data = (int)$count_row['cnt'];
    $total_page = ceil($total_data / $per_page);

    $rows = [];
    while($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }

    return [
        'data' => $rows,
        'total_page' => $total_page,
        'current_page' => $page,
        'total_data' => $total_data
    ];
}

// Ambil data semua tab
$queues = [
    'internal' => get_paginated_data('INTERNAL', $per_page, 'link_internal', $search),
    'bpjs'     => get_paginated_data('BPJS', $per_page, 'link_bpjs', $search),
    'umum'     => get_paginated_data('UMUM', $per_page, 'link_umum', $search),
    'selesai'  => get_paginated_data('SELESAI', $per_page, 'link_selesai', $search)
];

// Return JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['queues' => $queues]);

?>