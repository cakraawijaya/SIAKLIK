// Jalankan script setelah seluruh DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function () {

    // Ambil semua wrapper tabel yang bisa di-scroll
    const tables = document.querySelectorAll('.table-responsive');

    // Loop setiap wrapper tabel (jika ada lebih dari satu)
    tables.forEach(wrapper => {
        let timer;

        // Tampilkan scrollbar sementara
        const showScrollbar = () => {
            wrapper.classList.add('show-scrollbar');

            clearTimeout(timer);
            
            // Sembunyikan lagi setelah 1.5 detik tanpa aktivitas
            timer = setTimeout(() => {
                wrapper.classList.remove('show-scrollbar');
            }, 1500);
        };

        // Trigger aktivitas
        wrapper.addEventListener('mousedown', showScrollbar);
        wrapper.addEventListener('touchstart', showScrollbar);
        wrapper.addEventListener('wheel', showScrollbar);
        wrapper.addEventListener('scroll', showScrollbar);
    });
});