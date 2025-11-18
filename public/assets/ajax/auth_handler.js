document.addEventListener("DOMContentLoaded", function() {
    const loggedIn = document.body.dataset.loggedin === "true";
    if(!loggedIn){
        console.log("[Auth] Polling dimatikan!");
        return;
    }

    sessionStorage.setItem("userLoggedIn","true");

    let lastActivity = Date.now();
    let redirected = false;

    const CHECK_INTERVAL = 5000;
    const IDLE_TIMEOUT = 5*60*1000; // 5 menit

    let ajaxInterval;

    function startPolling(){
        if(ajaxInterval) clearInterval(ajaxInterval); // reset polling lama
        ajaxInterval = setInterval(()=>{
            fetch(BASE_URL+"components/data/ajax_auth_check.php",{credentials:'same-origin'})
                .then(res=>res.json())
                .then(res=>{
                    if(res.status==='auto_deleted') forceLogout("auto_deleted");
                    else if(res.status==='auto_timeout') forceLogout("auto_timeout");
                })
                .catch(err=>console.warn("[Auth] AJAX error:",err));
        }, CHECK_INTERVAL);

        console.log("[Auth] Polling baru dimulai!");
    }

    function forceLogout(type){
        if(redirected) return;
        redirected = true;

        clearInterval(ajaxInterval);
        clearInterval(idleCheck);
        clearInterval(minuteCountdown);

        sessionStorage.setItem("userLoggedOut","true");

        console.log("[Auth] Polling dinonaktifkan!");

        fetch(BASE_URL+"components/data/ajax_auth_check.php?action=force_logout",{credentials:'same-origin'})
            .then(res=>res.json())
            .finally(()=> window.location.href=BASE_URL+"index.php?pesan="+type);
    }

    // --- Event listener untuk aktivitas pengguna dengan debounce ---
    let activityTimeout;
    let lastEvent = null;

    ['click','mousemove','keydown','scroll','touchstart'].forEach(evt=>{
        document.addEventListener(evt, e => {
            const now = Date.now();

            // Debounce & deduplicate event
            if(lastEvent === evt && now - lastActivity < 200) return;

            lastActivity = now;
            lastEvent = evt;

            console.log(`[Auth] Terdeteksi aktivitas: ${evt}`);

            // Reset polling dengan delay kecil agar tidak menumpuk interval
            clearTimeout(activityTimeout);
            activityTimeout = setTimeout(() => {
                startPolling();
            }, 50);

        }, {passive:true});
    });

    startPolling(); // mulai polling pertama kali

    const idleCheck = setInterval(()=>{
        const idleTime = Date.now() - lastActivity;
        setTimeout(()=>{
            if(idleTime > IDLE_TIMEOUT){ 
                forceLogout("auto_timeout"); 
            }
        }, 5000);
    },1000);

    // Countdown setiap 1 menit
    let countdown = 60;
    const minuteCountdown = setInterval(()=>{
        countdown--;
        if(countdown <= 0){
            const idleTime = Date.now() - lastActivity;
            console.log(`[Auth] 1 menit telah berlalu ⏱ | Idle: ${Math.floor(idleTime/1000)} detik`);

            if(idleTime >= IDLE_TIMEOUT){
                console.log("[Auth] Timeout sudah tercapai!");
            }

            countdown = 60; // reset countdown
        }
    },1000);
});