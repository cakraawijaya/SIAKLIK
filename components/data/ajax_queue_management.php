<?php
// ======================== AUTH & CONFIG ========================
$require_login = true;
include __DIR__ . '/../features/auth/authorization/worker.php';
include __DIR__ . '/../../config/config.php';

$per_page = 4;

// ======================== FUNCTION HELPER ========================
function get_paginated_data($kategori, $per_page, $page_param, $search = '') {
    global $koneksi;
    $page = isset($_GET[$page_param]) && $_GET[$page_param] > 1 ? (int)$_GET[$page_param] : 1;
    $offset = ($page - 1) * $per_page;

    $s = mysqli_real_escape_string($koneksi, $search);
    $where_search = $search !== '' ? "AND kode_antrean LIKE '%$s%'" : '';

    // Query untuk pagination
    $union_sql = "
        SELECT 
            a.kode_antrean, 
            a.username, 
            COALESCE(p.nama, w.nama, a.nama) AS nama_user, 
            a.layanan, 
            a.kategori, 
            a.status_antrean, 
            a.waktu_daftar,
            NULL AS waktu_selesai
        FROM antrean a
        LEFT JOIN akun_pasien p ON a.username = p.username
        LEFT JOIN akun_pekerja w ON a.username = w.username
        WHERE a.kategori = '$kategori' $where_search

        UNION ALL

        SELECT 
            r.kode_antrean, 
            r.username, 
            COALESCE(p2.nama, w2.nama, r.nama) AS nama_user,
            r.layanan, 
            r.kategori, 
            r.status_antrean, 
            r.waktu_daftar,
            r.waktu_selesai
        FROM riwayat_antrean r
        LEFT JOIN akun_pasien p2 ON r.username = p2.username
        LEFT JOIN akun_pekerja w2 ON r.username = w2.username
        WHERE r.kategori = '$kategori' $where_search

        ORDER BY kode_antrean ASC
        LIMIT $per_page OFFSET $offset
    ";

    $query = mysqli_query($koneksi, $union_sql) or die(mysqli_error($koneksi));

    $rows = [];
    while($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }

    // Hitung total semua data
    $count_sql = "
        SELECT COUNT(*) AS cnt FROM (
            SELECT kode_antrean FROM antrean WHERE kategori='$kategori' $where_search
            UNION ALL
            SELECT kode_antrean FROM riwayat_antrean WHERE kategori='$kategori' $where_search
        ) AS total
    ";
    $count_res = mysqli_query($koneksi, $count_sql);
    $count_row = mysqli_fetch_assoc($count_res);
    $total_data = (int)$count_row['cnt'];

    // Hitung total status Menunggu + Dilayani
    $count_active_sql = "
        SELECT COUNT(*) AS cnt FROM (
            SELECT kode_antrean, status_antrean FROM antrean WHERE kategori='$kategori' $where_search AND status_antrean IN ('Menunggu','Dilayani')
            UNION ALL
            SELECT kode_antrean, status_antrean FROM riwayat_antrean WHERE kategori='$kategori' $where_search AND status_antrean IN ('Menunggu','Dilayani')
        ) AS total_active
    ";
    $count_active_res = mysqli_query($koneksi, $count_active_sql);
    $count_active_row = mysqli_fetch_assoc($count_active_res);
    $total_active = (int)$count_active_row['cnt'];

    $total_page = ceil($total_data / $per_page);

    return [
        'data' => $rows,
        'total_page' => $total_page,
        'current_page' => $page,
        'total_data' => $total_data,
        'total_active' => $total_active
    ];
}

// ======================== HANDLE AKSI (UPDATE STATUS) ========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = mysqli_real_escape_string($koneksi, $_POST['kode_antrean'] ?? '');

    if ($action === 'to_dilayani') {
        mysqli_query($koneksi, "UPDATE antrean SET status_antrean='Dilayani' WHERE kode_antrean='$id'");
        $updated = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM antrean WHERE kode_antrean='$id'"));

        echo json_encode([
            'success' => true,
            'message' => 'Status antrean diubah menjadi Dilayani',
            'updated_queue' => [
                'kode_antrean' => $updated['kode_antrean'],
                'status_antrean' => $updated['status_antrean'],
                'waktu' => $updated['waktu_daftar']
            ]
        ]);
        exit;
    }

    if ($action === 'to_selesai') {
        $cek = mysqli_query($koneksi, "SELECT * FROM antrean WHERE kode_antrean='$id'");
        $data = mysqli_fetch_assoc($cek);
        if ($data) {
            mysqli_begin_transaction($koneksi);
            try {
                // Masukkan ke riwayat_antrean
                mysqli_query($koneksi, "
                    INSERT INTO riwayat_antrean 
                    (kode_antrean, username, nama, layanan, kategori, status_antrean, waktu_daftar, waktu_selesai)
                    VALUES 
                    ('{$data['kode_antrean']}', '{$data['username']}', '{$data['nama']}', '{$data['layanan']}', '{$data['kategori']}', 'Selesai', '{$data['waktu_daftar']}', NOW())
                ");

                mysqli_query($koneksi, "DELETE FROM antrean WHERE kode_antrean='$id'");
                mysqli_commit($koneksi);

                // Ambil data terbaru dari riwayat_antrean untuk highlight
                $updated = mysqli_fetch_assoc(mysqli_query($koneksi, "
                    SELECT * FROM riwayat_antrean 
                    WHERE kode_antrean='{$data['kode_antrean']}' AND status_antrean='Selesai' 
                    ORDER BY waktu_selesai DESC LIMIT 1
                "));

                echo json_encode([
                    'success' => true,
                    'message' => 'Status antrean diubah menjadi Selesai',
                    'updated_queue' => [
                        'kode_antrean' => $updated['kode_antrean'],
                        'status_antrean' => $updated['status_antrean'],
                        'waktu' => $updated['waktu_selesai'] // highlight pakai waktu_selesai
                    ]
                ]);

            } catch (Exception $e) {
                mysqli_rollback($koneksi);
                echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
            }
        }
        exit;
    }
}

// ======================== DATA UTAMA ========================
$search = $_GET['search'] ?? '';
$queues = [
    'internal' => get_paginated_data('INTERNAL', $per_page, 'link_internal', $search),
    'bpjs'     => get_paginated_data('BPJS', $per_page, 'link_bpjs', $search),
    'umum'     => get_paginated_data('UMUM', $per_page, 'link_umum', $search),
];

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['queues' => $queues]);

?>