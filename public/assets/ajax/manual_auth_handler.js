// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function () {

    /* ============================ STATUS SESSION GLOBAL ============================ */

    // Flag global untuk menandai apakah session sudah expired
    // Default: false (session masih aktif)
    window.SESSION_EXPIRED = false;

    // Variabel global untuk menyimpan alasan session expired
    // Misalnya: "SESSION_EXPIRED", "UNAUTHORIZED", dll
    window.SESSION_REASON  = null;



    /* ============================= AJAX ERROR HANDLING ============================= */

    // Listener global yang akan terpanggil SETIAP ada AJAX error
    $(document).ajaxError(function (event, xhr) {

        // Jika response bukan JSON atau tidak memiliki properti "code", maka :
        // Hentikan eksekusi (bukan error auth/session)
        if (!xhr.responseJSON || !xhr.responseJSON.code) return;

        // Jika session sudah ditandai expired sebelumnya, maka :
        // Jangan set ulang agar tidak dobel eksekusi
        if (window.SESSION_EXPIRED) return;

        // Tandai bahwa session sudah expired
        window.SESSION_EXPIRED = true;

        // Simpan kode alasan error dari backend
        window.SESSION_REASON  = xhr.responseJSON.code;

        // Tampilkan peringatan di console (untuk debugging)
        console.warn('Session flag set:', window.SESSION_REASON);

    });

});