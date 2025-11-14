document.addEventListener('DOMContentLoaded', () => {
  const namaBulan_Element = document.getElementById('namaBulan');
  const namaHari_Element = document.getElementById('namaHari');
  const tanggal_Element = document.getElementById('tanggal');
  const tahun_Element = document.getElementById('tahun');

  // Jika elemen-elemen ini tidak ada, langsung hentikan tanpa error
  if (!namaBulan_Element || !namaHari_Element || !tanggal_Element || !tahun_Element) return;

  const lang = navigator.language;
  const date = new Date();

  const tanggal = date.getDate();
  const namaHari = date.toLocaleString(lang, { weekday: 'long' });
  const namaBulan = date.toLocaleString(lang, { month: 'long' });
  const tahun = date.getFullYear();

  namaBulan_Element.textContent = namaBulan;
  namaHari_Element.textContent = namaHari;
  tanggal_Element.textContent = tanggal;
  tahun_Element.textContent = tahun;
});