// Jalankan script setelah seluruh DOM selesai dimuat
document.addEventListener("DOMContentLoaded", function() {

  // Ambil elemen-elemen DOM berdasarkan ID
  const namaBulan_Element = document.getElementById('namaBulan');
  const namaHari_Element = document.getElementById('namaHari');
  const tanggal_Element = document.getElementById('tanggal');
  const tahun_Element = document.getElementById('tahun');

  // Jika elemen-elemen ini tidak ada, hentikan eksekusi script untuk mencegah error
  if (!namaBulan_Element || !namaHari_Element || !tanggal_Element || !tahun_Element) return;

  // Ambil bahasa dari browser pengguna
  const lang = navigator.language;

  // Buat objek Date untuk mendapatkan tanggal saat ini
  const date = new Date();

  // Ambil tanggal (angka)
  const tanggal = date.getDate();

  // Ambil nama hari dalam format panjang sesuai bahasa pengguna
  const namaHari = date.toLocaleString(lang, { weekday: 'long' });

  // Ambil nama bulan dalam format panjang sesuai bahasa pengguna
  const namaBulan = date.toLocaleString(lang, { month: 'long' });

  // Ambil tahun saat ini
  const tahun = date.getFullYear();

  // Tampilkan nama bulan di elemen yang sesuai
  namaBulan_Element.textContent = namaBulan;

  // Tampilkan nama hari di elemen yang sesuai
  namaHari_Element.textContent = namaHari;

  // Tampilkan tanggal di elemen yang sesuai
  tanggal_Element.textContent = tanggal;

  // Tampilkan tahun di elemen yang sesuai
  tahun_Element.textContent = tahun;

});