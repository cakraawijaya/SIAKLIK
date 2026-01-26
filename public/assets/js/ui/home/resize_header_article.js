// Jalankan script setelah seluruh DOM selesai dimuat
document.addEventListener("DOMContentLoaded", function() {

  // ===========================================================================================
  // FUNGSI SET EQUAL HEADER HEIGHT
  // ===========================================================================================
  // Fungsi untuk menyamakan tinggi semua header kartu di slide carousel yang aktif
  function setEqualHeaderHeight() {

    // Reset dulu agar bisa hitung ulang tinggi alami
    document.querySelectorAll('.carousel-item.active .card-header').forEach(h => {
      h.style.height = 'auto';
    });

    // Ambil semua elemen card-header di slide aktif
    const headers = document.querySelectorAll('.carousel-item.active .card-header');

    let maxHeight = 0; // variabel untuk menyimpan tinggi maksimum

    // Loop setiap header untuk mencari tinggi maksimum
    headers.forEach(h => {
      const height = h.offsetHeight;                // Dapatkan tinggi elemen
      if (height > maxHeight) maxHeight = height;   // Update maxHeight jika lebih tinggi
    });

    // Terapkan tinggi maksimum ke semua header di slide aktif
    headers.forEach(h => {
      h.style.height = maxHeight + 'px';
    });
  }

  // Jalankan fungsi saat halaman pertama kali dimuat
  setEqualHeaderHeight();

  // Jalankan fungsi setiap kali carousel berpindah slide
  $('#carousel-indicators2').on('slid.bs.carousel', function () {
    setEqualHeaderHeight();
  });

  // Jalankan fungsi saat ukuran jendela diubah (resize) untuk responsif
  window.addEventListener('resize', setEqualHeaderHeight);

});