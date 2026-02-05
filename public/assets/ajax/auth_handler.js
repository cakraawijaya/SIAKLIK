$(document).ready(function () {

    // MANUAL
    // ======================= SESSION FLAG ======================
    window.SESSION_EXPIRED = false;
    window.SESSION_REASON  = null;

    // ================== GLOBAL AJAX AUTH GUARD =================
    $(document).ajaxError(function (event, xhr) {

        if (!xhr.responseJSON || !xhr.responseJSON.code) return;

        // Jangan overwrite kalau sudah expired
        if (window.SESSION_EXPIRED) return;

        window.SESSION_EXPIRED = true;
        window.SESSION_REASON  = xhr.responseJSON.code;

        console.warn('Session flag set:', window.SESSION_REASON);

    });


    // OTOMATIS
    const loggedIn = document.body.dataset.loggedin === "true";
    if (!loggedIn) {
        console.log("[Auth] Polling dimatikan!");
        return;
    }

    sessionStorage.setItem("userLoggedIn", "true");

    let lastActivity = Date.now();
    let redirected = false;

    const CHECK_INTERVAL = 5000;
    const IDLE_TIMEOUT = 5 * 60 * 1000; // 5 menit

    let ajaxInterval;

    function startPolling() {
        if (ajaxInterval) clearInterval(ajaxInterval);

        ajaxInterval = setInterval(() => {
            fetch(BASE_URL + "components/data/ajax_auth_check.php", {
                credentials: 'same-origin'
            })
            .then(res => res.json())
            .then(res => {
                switch (res.status) {
                    case 'auto_deleted':
                    case 'auto_timeout':
                    case 'auto_db_error':
                        forceLogout(res.status);
                        break;
                    case 'ok':
                        break;
                    default:
                        console.warn("[Auth] Status tidak dikenali:", res);
                }
            })
            .catch(err => console.warn("[Auth] AJAX error:", err));
        }, CHECK_INTERVAL);

        console.log("[Auth] Polling baru dimulai!");
    }

    function forceLogout(type) {
        if (redirected) return;
        redirected = true;

        clearInterval(ajaxInterval);
        clearInterval(idleCheck);
        clearInterval(minuteCountdown);

        sessionStorage.setItem("userLoggedOut", "true");
        console.log("[Auth] Polling dinonaktifkan!");

        fetch(BASE_URL + "components/data/ajax_auth_check.php?action=force_logout", {
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'auto_db_error' || type === 'auto_db_error') {
                window.location.href = BASE_URL + "components/pages/error/database_notification.php";
            } else if (res.status === 'auto_deleted' || type === 'auto_deleted') {
                window.location.href = BASE_URL + "index.php?pesan=auto_deleted";
            } else {
                window.location.href = BASE_URL + "index.php?pesan=" + type;
            }
        });
    }

    // ===== Aktivitas user (debounced) =====
    let activityTimeout;
    let lastEvent = null;

    ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evt => {
        document.addEventListener(evt, e => {
            const now = Date.now();
            if (lastEvent === evt && now - lastActivity < 200) return;

            lastActivity = now;
            lastEvent = evt;

            console.log(`[Auth] Terdeteksi aktivitas: ${evt}`);

            clearTimeout(activityTimeout);
            activityTimeout = setTimeout(startPolling, 50);

        }, { passive: true });
    });

    startPolling();

    const idleCheck = setInterval(() => {
        const idleTime = Date.now() - lastActivity;
        setTimeout(() => {
            if (idleTime > IDLE_TIMEOUT) {
                forceLogout("auto_timeout");
            }
        }, 5000);
    }, 1000);

    // Countdown tiap 1 menit (debug)
    let countdown = 60;
    const minuteCountdown = setInterval(() => {
        countdown--;
        if (countdown <= 0) {
            const idleTime = Date.now() - lastActivity;
            console.log(`[Auth] 1 menit berlalu ⏱ | Idle: ${Math.floor(idleTime / 1000)} detik`);
            countdown = 60;
        }
    }, 1000);

    // Saat halaman selesai load (F5 / refresh)
    $(window).on('load', function () {
        const dbError = sessionStorage.getItem("dbErrorOccurred") === "true";
        if (dbError) {
            sessionStorage.removeItem("dbErrorOccurred");
            window.location.href = BASE_URL + "index.php?pesan=auto_timeout";
        }
    });

});