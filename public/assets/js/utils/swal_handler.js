// Jalankan script setelah seluruh DOM selesai dimuat
document.addEventListener("DOMContentLoaded", function() {

    // Ambil elemen SweetAlert dari HTML
    const swalEl = document.getElementById("swal-data");
    if (!swalEl) return; // Hentikan jika tidak ada data alert

    // Ambil konfigurasi alert dari data-attribute
    const icon = swalEl.dataset.icon;
    const title = swalEl.dataset.title;
    const html = swalEl.dataset.html;
    const timer = swalEl.dataset.timer ? parseInt(swalEl.dataset.timer) : null;
    const redirect = swalEl.dataset.redirect || null;

    // Tampilkan SweetAlert jika icon tersedia
    if (icon) {
        Swal.fire({
            icon,
            title,
            html,
            timer,
            timerProgressBar: !!timer,
            showConfirmButton: !timer,

            // Redirect setelah alert ditutup (jika ada)
            didClose: () => {
                if (redirect) {
                    window.location.href = redirect;
                }
            }
        });
    }
});