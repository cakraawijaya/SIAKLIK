<?php

    // ===========================================================================================
    // KONFIGURASI TIMEOUT & POLLING AJAX
    // ===========================================================================================

    // Waktu timeout user dalam detik (misal: 5 menit = 300 detik)
    define('AUTH_TIMEOUT', 300);

    // Interval polling AJAX di sisi client (dalam milidetik)
    define('AUTH_POLL_INTERVAL', 5000);



    // ===========================================================================================
    // FUNGSI KONVERSI TIMEOUT
    // ===========================================================================================

    // Digunakan untuk mengubah detik menjadi milidetik (dipakai di JavaScript)
    function getTimeoutMs() {
        return AUTH_TIMEOUT * 1000;
    }

?>