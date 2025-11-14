document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const pesan = urlParams.get("pesan");
    let lastActivity = Date.now();
    let redirected = false;

    const CHECK_INTERVAL = 5000; // polling tiap 5 detik
    const IDLE_TIMEOUT = 5 * 60 * 1000; // 5 menit

    // Reset alert flag saat login sukses
    if (sessionStorage.getItem("userLoggedIn") === "true") {
        sessionStorage.removeItem("timeoutAlertShown");
        sessionStorage.setItem("userLoggedOut", "false");
    }

    // Hentikan polling jika user sudah logout
    if (sessionStorage.getItem("userLoggedOut") === "true") return;

    // Update aktivitas user
    ['click','mousemove','keydown','scroll','touchstart'].forEach(evt => {
        document.addEventListener(evt, () => {
            lastActivity = Date.now();
            console.log(`[Auth] Aktivitas terdeteksi (${evt}) → reset waktu dari awal`);
        }, { passive: true });
    });

    // Force logout
    function forceLogout(type) {
        if (redirected) return;
        redirected = true;

        clearInterval(ajaxInterval);
        clearInterval(idleCheck);

        sessionStorage.setItem("userLoggedOut","true");

        console.log(`[Auth] FORCE LOGOUT triggered → type: ${type}`);

        fetch(BASE_URL + "components/data_ajax/ajax_auth_check.php?action=force_logout", { credentials: 'same-origin' })
            .then(res => res.json())
            .finally(() => {
                window.location.href = BASE_URL + "index.php?pesan=" + type;
            });
    }

    // Polling session check
    const ajaxInterval = setInterval(() => {
        const idleSeconds = Math.floor((Date.now() - lastActivity) / 1000);
        const remainingSeconds = Math.max(0, Math.ceil((IDLE_TIMEOUT - (Date.now() - lastActivity)) / 1000));

        fetch(BASE_URL + "components/data_ajax/ajax_auth_check.php", { credentials: 'same-origin' })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'auto_deleted') forceLogout("auto_deleted");
                else if(res.status === 'auto_timeout') forceLogout("auto_timeout");
            })
            .catch(err => console.warn("[Auth] AJAX error:", err));
    }, CHECK_INTERVAL);

    // Idle auto timeout
    const idleCheck = setInterval(() => {
        const idleTime = Date.now() - lastActivity;
        const remainingSeconds = Math.max(0, Math.ceil((IDLE_TIMEOUT - idleTime) / 1000));
        console.log(`[Auth] Hitung mundur timeout: ${remainingSeconds}s`);

        if(idleTime > IDLE_TIMEOUT) {
            console.log("[Auth] Auto Timeout tercapai → Keluarkan paksa");
            forceLogout("auto_timeout");
        }
    }, 1000);
});