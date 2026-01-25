function reloadCaptcha(imgId) {

    const img = document.getElementById(imgId);
    if (!img) return;

    const base = img.getAttribute('data-base');
    if (!base) return;

    // Tambahkan param dummy _ untuk bypass cache, jangan ubah id
    const separator = base.includes('?') ? '&' : '?';
    img.src = base + separator + '_=' + new Date().getTime();

}