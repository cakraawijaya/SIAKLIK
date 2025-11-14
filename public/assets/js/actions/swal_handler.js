document.addEventListener("DOMContentLoaded", function() {
    const swalEl = document.getElementById("swal-data");
    if (!swalEl) return;

    const icon = swalEl.dataset.icon;
    const title = swalEl.dataset.title;
    const html = swalEl.dataset.html;
    const timer = swalEl.dataset.timer ? parseInt(swalEl.dataset.timer) : null;
    const redirect = swalEl.dataset.redirect || null;

    if (icon) {
        Swal.fire({
            icon,
            title,
            html,
            timer,
            timerProgressBar: !!timer,
            showConfirmButton: !timer,
            didClose: () => {
                if (redirect) {
                    window.location.href = redirect;
                }
            }
        });
    }
});