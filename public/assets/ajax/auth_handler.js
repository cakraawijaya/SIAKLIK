// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function () {

    /* ============================ STATUS SESSION GLOBAL ============================ */

    // Flag global untuk menandai bahwa sesi atau otorisasi user sudah tidak valid
    // Bisa disebabkan oleh: belum login atau tidak punya hak akses
    // Default: false (session & akses masih valid)
    window.SESSION_EXPIRED = false;

    // Variabel global untuk menyimpan alasan dari backend (PHP)
    // Misalnya: "UNAUTHORIZED" atau "FORBIDDEN"
    window.SESSION_REASON  = null;


    /* ============================= AJAX ERROR HANDLING ============================= */
    // Listener global yang akan terpanggil SETIAP ada AJAX error
    $(document).ajaxError(function (event, xhr) {

        // Jika response bukan JSON atau tidak memiliki properti "code", maka :
        // Hentikan eksekusi (bukan error auth/session)
        if (!xhr.responseJSON || !xhr.responseJSON.code) return;

        // Jika sesi atau otorisasi user sudah ditandai tidak valid sebelumnya, maka :
        // Jangan set ulang agar tidak dobel eksekusi
        if (window.SESSION_EXPIRED) return;

        // Tandai bahwa sesi atau otorisasi user sudah tidak valid
        window.SESSION_EXPIRED = true;

        // Simpan kode alasan error dari backend
        window.SESSION_REASON  = xhr.responseJSON.code;

        // Tampilkan peringatan ke console
        console.warn('Session flag set:', window.SESSION_REASON);

    });


    /* ========================= INISIALISASI & VALIDASI LOGIN ======================= */
    const loggedIn = document.body.dataset.loggedin === "true"; // Cek apakah user sedang login

    if (!loggedIn) { // Jika user tidak login, maka :

        console.log("[Auth] Polling dimatikan!"); // Tampilkan informasi ke console
        return; // Stop eksekusi script agar tidak lanjut ke proses polling
    }

    // Menyimpan status login user di sessionStorage browser
    sessionStorage.setItem("userLoggedIn", "true");


    /* ========================= VARIABEL STATUS & KONFIGURASI ======================= */
    let lastActivity = Date.now(); // Inisialisasi timestamp aktivitas terakhir user

    // Penanda agar proses logout tidak dijalankan berkali-kali
    let redirected = false;

    // Mengambil nilai timeout (detik) dari <body> lalu dikonversi ke milidetik
    const IDLE_TIMEOUT = parseInt(document.body.dataset.timeout) * 1000;

    // Mengambil interval polling AJAX dari <body>
    const CHECK_INTERVAL = parseInt(document.body.dataset.pollInterval);

    // Lokasi halaman yang dituju saat terjadi error pada database
    const PAGE_DB_ERROR = "components/pages/system/error/database_notification.php";

    // Variabel untuk menyimpan interval AJAX polling
    let ajaxInterval;

    // Flag agar log timeout hanya muncul satu kali
    let timeoutLogged = false;


    /* ======================= POLLING STATUS SESSION KE SERVER ====================== */
    // Fungsi untuk memulai polling ke server
    function startPolling() {

        // Jika polling sebelumnya masih berjalan, maka hentikan dulu (reset)
        if (ajaxInterval) clearInterval(ajaxInterval);

        // Menjalankan polling AJAX secara berkala
        ajaxInterval = setInterval(() => {

            // Mengirimkan request ke server untuk mengecek status session
            fetch(BASE_URL + "components/data/ajax_auth_check.php", {
                credentials: 'same-origin'
            }).then(res => res.json()).then(res => {

                // Menangani respon status dari server
                switch (res.status) {

                    // Jika respon statusnya antara lain sebagai berikut :
                    // akun terhapus, timeout, atau error database, maka :
                    case 'auto_deleted':
                    case 'auto_timeout':
                    case 'auto_db_error':
                        forceLogout(res.status); // Lakukan proses logout otomatis
                        break; // Keluar dari switch

                    // Jika status normal, maka :
                    case 'ok':
                        break; // Keluar dari switch (tidak perlu melakukan suatu tindakan)

                    // Jika status tidak dikenal, maka :
                    default:
                        console.warn("[Auth] Status tidak dikenali:", res); // Tampilkan peringatan ke console
                }
            })

            // Menangani error jika request gagal
            .catch(err => console.warn("[Auth] AJAX error:", err)); // Tampilkan error AJAX ke console

        }, CHECK_INTERVAL); // Menentukan interval polling ke server

        console.log("[Auth] Polling baru dimulai!"); // Tampilkan informasi ke console
    }

    // Menjalankan polling pertama kali saat halaman dibuka
    startPolling();


    /* ======================== LOGOUT OTOMATIS / LOGOUT PAKSA ======================= */
    // Fungsi untuk logout paksa user
    function forceLogout(type) {

        // Mencegah logout dijalankan lebih dari sekali
        if (redirected) return; redirected = true;

        // Menghentikan semua interval yang berjalan
        clearInterval(ajaxInterval); clearInterval(idleCheck); clearInterval(minuteCountdown);

        // Tampilkan informasi ke console
        console.log("[Auth] Polling dihentikan karena:", type);

        // Jika error berasal dari database, maka :
        if (type === 'auto_db_error') {

            // Redirect ke halaman notifikasi error database
            window.location.href = BASE_URL + PAGE_DB_ERROR;
            return; // Stop eksekusi script
        }

        // Menandai bahwa user sudah logout di sessionStorage
        sessionStorage.setItem("userLoggedOut", "true");

        // Memberitahu server untuk menghapus session
        fetch(BASE_URL + "components/data/ajax_auth_check.php?action=force_logout", {
            credentials: 'same-origin'
        })

        // Setelah selesai, maka :
        .finally(() => {

            // Redirect ke halaman utama dengan pesan
            window.location.href = BASE_URL + "index.php?pesan=" + type;
        });
    }


    /* ============================= DETEKSI AKTIVITAS USER ========================== */
    // Digunakan untuk mendeteksi apakah user masih aktif

    let activityTimeout;    // Untuk debounce aktivitas
    let lastEvent = null;   // Menyimpan jenis event terakhir

    // Daftar aktivitas yang dianggap sebagai interaksi user
    ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evt => {

        // Menangkap event user untuk memperbarui status keaktifan user
        document.addEventListener(evt, e => {

            // Menyimpan waktu saat event terjadi
            const now = Date.now();

            // Mencegah event yang terlalu sering diproses
            if (lastEvent === evt && now - lastActivity < 200) return;

            // Memperbarui waktu aktivitas terakhir
            lastActivity = now; lastEvent = evt;

            // Reset flag timeout saat user kembali aktif
            timeoutLogged = false;

            // Tampilkan informasi ke console
            console.log(`[Auth] Terdeteksi aktivitas: ${evt}`);

            // Membatalkan timer polling sebelumnya (jika masih ada)
            clearTimeout(activityTimeout);

            // Menjadwalkan ulang polling agar dijalankan setelah jeda singkat
            activityTimeout = setTimeout(startPolling, 50);

        }, { passive: true }); // passive agar lebih ringan untuk performa
    });


    /* ========================== CEK USER DIAM (IDLE TIMEOUT) ======================= */
    // Mengecek apakah user sedang tidak aktif dalam waktu yang lama
    const idleCheck = setInterval(() => {

        // Menghitung berapa lama user tidak beraktivitas
        const idleTime = Date.now() - lastActivity;

        // Memberi jeda sebelum benar-benar logout
        setTimeout(() => {

            // Jika waktu diam melebihi batas timeout, maka :
            if (idleTime > IDLE_TIMEOUT) {
                forceLogout("auto_timeout"); // Lakukan proses logout otomatis
            }

        }, 5000); // Delay tambahan (5 detik) sebelum logout
    }, 1000); // Dicek setiap 1 detik


    /* ======================= LOG DEBUG BERDASARKAN WAKTU NYATA ===================== */
    // Digunakan untuk debugging atau monitoring

    const startLogTime = Date.now();    // waktu awal hitung menit
    let lastMinuteLog = startLogTime;   // waktu terakhir log muncul

    // Fungsi untuk menghitung & menampilkan log waktu yang telah berlalu (termasuk durasi idle user & status timeout)
    function logElapsed() {

        const now      = Date.now();          // Menyimpan waktu saat fungsi ini dipanggil
        const idleTime = now - lastActivity;  // Menghitung berapa lama user tidak beraktivitas (dalam milidetik)

        /* LOG MENIT */
        // Menghitung jumlah menit penuh yang telah berlalu sejak terakhir kali log menit ditampilkan
        const elapsedMinutes = Math.floor((now - startLogTime) / 60_000);

        // Jika sudah lewat minimal 1 menit sejak log terakhir, maka :
        if (now - lastMinuteLog >= 60_000) {

            // Tampilkan informasi ke console
            console.log(`[Auth] ${elapsedMinutes} menit telah berlalu ⏱ | Idle: ${Math.floor(idleTime / 1000)} detik`);

            // Menandai bahwa satu menit sudah tercatat
            // Jadi sistem menunggu 1 menit berikutnya sebelum mencetak log lagi
            lastMinuteLog += 60_000;
        }

        /* LOG TIMEOUT */
        // Jika timeout belum pernah dicatat sebelumnya dan
        // Waktu idle user sudah melebihi batas timeout, maka :
        if (!timeoutLogged && idleTime >= IDLE_TIMEOUT) {

            // Tampilkan informasi ke console
            console.log("[Auth] Timeout sudah tercapai!");

            // Tandai bahwa log timeout sudah ditampilkan agar tidak muncul berkali-kali
            timeoutLogged = true;
        }
    }


    /* ============================ INTERVAL PEMANTAUAN WAKTU ======================== */
    // Interval ini digunakan untuk memicu pengecekan waktu secara berkala

    // Menjalankan proses pengecekan setiap interval
    const minuteCountdown = setInterval(() => {
        logElapsed();   // Memanggil fungsi untuk mengecek dan menampilkan log waktu
    }, 1000);           // Interval dijalankan setiap 1 detik


    /* ========================= TAB VISIBILITY & FOCUS HANDLER ====================== */
    // Bagian ini menangani kondisi saat user kembali ke halaman (dari tab atau window lain)

    // Event ini terpanggil saat status visibilitas tab berubah
    document.addEventListener('visibilitychange', () => {

        // Jika tab sekarang dalam keadaan aktif (tidak tersembunyi), maka :
        if (!document.hidden) {
            logElapsed(); // Perbarui dan tampilkan log waktu terbaru
        }
    });

    // Event ini terpanggil saat window browser kembali mendapatkan fokus
    window.addEventListener('focus', () => {
        logElapsed(); // Perbarui dan tampilkan log waktu terbaru
    });

});