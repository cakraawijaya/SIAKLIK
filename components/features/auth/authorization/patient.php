<?php

    // ===========================================================================================
    // CEK SESSION
    // ===========================================================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }


    // ===========================================================================================
    // HELPER AJAX REQUEST
    // ===========================================================================================
    // Fungsi untuk mengecek apakah request yang masuk adalah AJAX
    function isAjaxRequest() {

        // Mengecek apakah header HTTP_X_REQUESTED_WITH ada dan tidak kosong
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&

            // Membandingkan nilai header tersebut (dijadikan huruf kecil)
            // dengan string 'xmlhttprequest' yang merupakan ciri khas request AJAX
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }


    // ===========================================================================================
    // HELPER AJAX AUTH RESPONSE
    // ===========================================================================================
    // Fungsi untuk mengirim response autentikasi atau otorisasi khusus request AJAX
    function ajaxAuthResponse($code, $reason) {

        // Set HTTP response code sesuai konteks (401 / 403)
        http_response_code($code);

        // Set response ke format JSON
        header('Content-Type: application/json');

        // Mengirim response JSON ke client dengan kode status yang sudah ditetapkan
        echo json_encode(['code' => $reason]);
        exit; // Menghentikan eksekusi script
    }


    // ===========================================================================================
    // CEK LOGIN & ROLE KALAU BELUM TIMEOUT
    // ===========================================================================================
    if (isset($require_login) && $require_login === true && empty($_GET['pesan'])) {

        // Jika session hilang (user tidak login), maka :
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

            // Jika request berasal dari AJAX, maka berikan respon 401 dan hentikan eksekusi
            if (isAjaxRequest()) { ajaxAuthResponse(401, 'NOT_LOGGED_IN'); }

            // Redirect ke modal login pasien
            // Hal ini disertai dengan pesan = Mohon masuk terlebih dahulu!
            header("location: " . BASE_URL . "index.php?pesan=belum_login&modal=pasien");
            exit; // Menghentikan eksekusi script
        }

        // Jika variabel $allowed_levels belum didefinisikan di halaman pemanggil, maka gunakan :
        if (!isset($allowed_levels)) {

            // Default: Semua role (pasien, pekerja, admin) boleh akses
            $allowed_levels = ['pasien', 'pekerja', 'admin'];
        }

        // Jika role user tidak memiliki izin ke halaman ini, maka :
        if (!in_array($_SESSION['level'], $allowed_levels)) {

            // Jika request berasal dari AJAX, maka berikan respon 403 dan hentikan eksekusi
            if (isAjaxRequest()) { ajaxAuthResponse(403, 'FORBIDDEN'); }

            // Redirect ke modal login pasien
            // Hal ini disertai dengan pesan = Akses ditolak!
            header("location: " . BASE_URL . "index.php?pesan=error");
            exit; // Menghentikan eksekusi script
        }
    }

?>