// Jalankan script setelah seluruh DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function() {

    // Ambil semua wrapper tabel yang bisa di-scroll
    const tables = document.querySelectorAll('.table-responsive');

    // Loop setiap wrapper tabel (jika ada lebih dari satu)
    tables.forEach(wrapper => {

        // Variabel untuk menyimpan timer setTimeout
        let timer;

        // Tampilkan scrollbar sementara
        const showScrollbar = () => {

            // Tambahkan class 'show-scrollbar' untuk menampilkan scrollbar
            wrapper.classList.add('show-scrollbar');

            // Hapus timer sebelumnya jika masih berjalan, agar tidak konflik
            clearTimeout(timer);
            
            // Sembunyikan lagi scrollbar setelah 1.5 detik tanpa aktivitas
            timer = setTimeout(() => {

                // Hapus class untuk menyembunyikan scrollbar
                wrapper.classList.remove('show-scrollbar');

            }, 1500); // 1500ms = 1.5 detik
        };

        // Trigger aktivitas
        wrapper.addEventListener('mousedown', showScrollbar);   // Saat mouse ditekan
        wrapper.addEventListener('touchstart', showScrollbar);  // Saat layar disentuh
        wrapper.addEventListener('wheel', showScrollbar);       // Saat scroll wheel digunakan
        wrapper.addEventListener('scroll', showScrollbar);      // Saat wrapper di-scroll
    });
});
