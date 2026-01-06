<?php

    // ======================== CONFIG & AUTH ========================
    $require_login = true;
    include __DIR__ . '/../features/auth/authorization/admin.php';

    // muat konfigurasi BASE_URL & koneksi
    include __DIR__ . '/../../config/config.php';


    // ======================== DATA PER PAGE ========================
    $per_page = 10;


    // ========================== HELPERS ============================
    function send_json($arr) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($arr);
        exit;
    }

    function clean($s) {
        global $koneksi;
        return mysqli_real_escape_string($koneksi, trim($s));
    }


    // ===================== PAGINATE LOG ============================
    function get_paginated_logs($role, $per_page, $page_param, $search = '') {
        global $koneksi;

        $page = isset($_GET[$page_param]) && $_GET[$page_param] > 1
            ? (int)$_GET[$page_param]
            : 1;

        $offset = ($page - 1) * $per_page;
        $s = clean($search);

        $where = "WHERE role='$role'";
        if ($search !== '') {
            $where .= " AND (
                username LIKE '%$s%' OR
                aksi LIKE '%$s%' OR
                detail LIKE '%$s%'
            )";
        }

        // ================= HITUNG TOTAL =================
        $cnt_sql = "SELECT COUNT(*) AS cnt FROM riwayat_aktivitas $where";
        $cnt_q = mysqli_query($koneksi, $cnt_sql);
        $cnt_row = mysqli_fetch_assoc($cnt_q);
        $total_data = (int)$cnt_row['cnt'];

        // ================= DATA =================
        $sql = "
            SELECT created_at, username, role, aksi, detail
            FROM riwayat_aktivitas
            $where
            ORDER BY created_at DESC
            LIMIT $per_page OFFSET $offset
        ";

        $rows = [];
        $q = mysqli_query($koneksi, $sql);
        while ($r = mysqli_fetch_assoc($q)) {
            $rows[] = $r;
        }

        $total_page = $per_page > 0 ? ceil($total_data / $per_page) : 1;

        return [
            'data' => $rows,
            'total_data' => $total_data,
            'current_page' => $page,
            'total_page' => $total_page
        ];
    }


    // ============================ READ =============================
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search = $_GET['search'] ?? '';

        $logs = [
            'pasien'  => get_paginated_logs('pasien',  $per_page, 'link_pasien',  $search),
            'pekerja' => get_paginated_logs('pekerja', $per_page, 'link_pekerja', $search),
            'admin'   => get_paginated_logs('admin',   $per_page, 'link_admin',   $search),
        ];

        send_json(['logs' => $logs]);
    }


    // ========================== DEFAULT ============================
    send_json([
        'logs' => [
            'pasien'  => ['data' => [], 'total_data' => 0, 'current_page' => 1, 'total_page' => 1],
            'pekerja' => ['data' => [], 'total_data' => 0, 'current_page' => 1, 'total_page' => 1],
            'admin'   => ['data' => [], 'total_data' => 0, 'current_page' => 1, 'total_page' => 1],
        ]
    ]);

?>