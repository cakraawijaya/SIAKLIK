// ===========================================================================================
// FUNGSI RELOAD CAPTCHA
// ===========================================================================================
function reloadCaptcha(imgId) {

    // Mengambil elemen <img> berdasarkan id yang dikirim
    const img = document.getElementById(imgId);

    if (!img) return; // Jika elemen tidak ditemukan, hentikan fungsi

    // Mengambil nilai atribut data-base (URL asli captcha)
    const base = img.getAttribute('data-base');

    if (!base) return; // Jika data-base tidak ada, hentikan fungsi

    // Menentukan pemisah URL
    // '&' jika sudah ada query
    // '?' jika belum
    const separator = base.includes('?') ? '&' : '?';

    // Mengubah src gambar dengan parameter dummy timestamp
    // Tujuannya untuk bypass cache browser tanpa mengubah id captcha
    img.src = base + separator + '_=' + new Date().getTime();

}