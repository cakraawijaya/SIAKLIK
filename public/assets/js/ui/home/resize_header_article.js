document.addEventListener("DOMContentLoaded", function() {
  function setEqualHeaderHeight() {
    // Reset dulu agar bisa hitung ulang tinggi alami
    document.querySelectorAll('.carousel-item.active .card-header').forEach(h => {
      h.style.height = 'auto';
    });

    // Loop semua card-header di slide aktif
    const headers = document.querySelectorAll('.carousel-item.active .card-header');
    let maxHeight = 0;

    headers.forEach(h => {
      const height = h.offsetHeight;
      if (height > maxHeight) maxHeight = height;
    });

    // Terapkan tinggi maksimum ke semua header dalam slide aktif
    headers.forEach(h => {
      h.style.height = maxHeight + 'px';
    });
  }

  // Jalankan saat awal load
  setEqualHeaderHeight();

  // Jalankan setiap kali slide berubah
  $('#carousel-indicators2').on('slid.bs.carousel', function () {
    setEqualHeaderHeight();
  });

  // Jalankan saat resize (responsif)
  window.addEventListener('resize', setEqualHeaderHeight);
});