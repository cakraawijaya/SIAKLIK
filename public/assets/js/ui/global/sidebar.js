// Jalankan kode setelah DOM (struktur HTML) siap
$(document).ready(function() {

    // ===========================================================================================
    // CUSTOM SCROLLBAR
    // ===========================================================================================
    // Mengatur tampilan scrollbar menggunakan plugin mCustomScrollbar supaya lebih rapi dan nyaman
    $("#sidebar").mCustomScrollbar({ theme: "minimal" });


    // ===========================================================================================
    // FUNGSI CEK TAMPILAN MOBILE
    // ===========================================================================================
    // Digunakan untuk mengetahui apakah website sedang dibuka di layar kecil (HP/Tablet) atau tidak
    // Jika lebar layar 768px atau kurang, maka dianggap sebagai tampilan mobile
    function isMobile() { return window.innerWidth <= 768; }


    // ===========================================================================================
    // SETTING AWAL SIDEBAR UNTUK LAYAR BESAR (DESKTOP)
    // ===========================================================================================
    // Jika website dibuka di layar besar seperti laptop atau PC,
    // maka sidebar akan ditampilkan dalam keadaan terbuka (expanded) secara default
    if (!isMobile()) {
        $('body').addClass('sidebar-expanded');         // Menandai bahwa sidebar dalam keadaan terbuka
        $('#sidebar, #content').removeClass('active');  // Mengembalikan sidebar dan konten ke kondisi normal
    }


    // ===========================================================================================
    // TOMBOL BUKA ATAU TUTUP SIDEBAR
    // ===========================================================================================
    // Berlaku untuk dua tombol: #sidebarCollapse dan #sidebarCollapse2
    // Perilaku sidebar akan berbeda antara tampilan HP (mobile) dan komputer (desktop)
    $('#sidebarCollapse, #sidebarCollapse2').on('click', function () {

        // Jika tampilannya adalah mobile, maka :
        if (isMobile()) {

            // Sidebar muncul sebagai panel overlay di atas halaman
            $('#sidebar').toggleClass('show');      // Menampilkan atau menyembunyikan sidebar
            $('body').toggleClass('sidebar-open');  // Menandai kondisi sidebar sedang terbuka

        } else { // Jika tampilannya adalah desktop, maka :

            // Sidebar dapat diperkecil atau diperbesar
            $('#sidebar, #content').toggleClass('active'); // Mengubah tampilan sidebar dan area konten
            $('body').toggleClass('sidebar-collapsed sidebar-expanded'); // Mengubah status sidebar
        }
    });


    // ===========================================================================================
    // MENYESUAIKAN SIDEBAR SAAT UKURAN LAYAR BERUBAH
    // ===========================================================================================
    // Bagian ini akan dieksekusi setiap kali ukuran layar berubah
    $(window).on('resize', function () {

        // Jika layar berubah menjadi ukuran kecil (mobile), maka :
        if (isMobile()) {

            // Menghapus semua status sidebar versi desktop
            $('body').removeClass('sidebar-collapsed sidebar-expanded').removeClass('sidebar-open');

            // Mengembalikan tampilan sidebar dan konten ke kondisi awal
            $('#sidebar, #content').removeClass('active show');

        } else { // Jika layar kembali ke ukuran besar (desktop), maka :

            // Pastikan sidebar memiliki status default (terbuka)
            if (!$('body').hasClass('sidebar-collapsed') && !$('body').hasClass('sidebar-expanded')) {
                $('body').addClass('sidebar-expanded'); // Sidebar terbuka secara default
            }
        }
    });


    // ===========================================================================================
    // MEMBUKA PANEL SUBMENU (COLLAPSE) TERTENTU SAAT HALAMAN DIMUAT
    // ===========================================================================================
    // main-menu  ->  submenu level 1 (Menu Utama)
    // charts     ->  submenu level 2 (Grafik Kunjungan)
    const autoExpandMenus = ['#main-menu', '#charts']; // Daftar ID panel collapse

    // Fungsi untuk membuka panel submenu (collapse) serta menandai menu parent-nya sebagai aktif
    const expandMenu = () => {
        autoExpandMenus.forEach(menuId => {

            // Ambil elemen panel submenu (collapse) berdasarkan ID
            const $menu = $(menuId);

            // Cari tombol menu yang terhubung dengan submenu tersebut
            const $toggle = $(`a[data-target="${menuId}"]`);

            // Jika submenu dan tombolnya benar-benar ada, maka :
            if ($menu.length && $toggle.length) {

                // Buka submenu secara paksa
                $menu.addClass('show').collapse('show');

                // Tandai bahwa submenu sedang terbuka (untuk aksesibilitas)
                $toggle.attr('aria-expanded', 'true');

                // Ambil elemen menu parent (<li>) bisa berupa menu level 1 atau level 2
                const $li = $toggle.closest('.custom-menu-sidebar, .main-menu-child');

                // Tandai menu induk sebagai menu aktif
                if ($li.length) $li.addClass('active');

                // Jika menu parent ini adalah menu level 2 (submenu parent), maka :
                if ($li.hasClass('main-menu-child')) {
                    $toggle.addClass('active'); // Tandai tombolnya sebagai aktif
                }
            }
        });
    };


    // ===========================================================================================
    // MEMBUKA SUBMENU DEFAULT DAN MENUTUP MENU PARENT LAIN SAAT HALAMAN DIMUAT
    // ===========================================================================================
    // Bagian ini dieksekusi sesaat setelah halaman siap
    // Digunakan untuk membuka menu tertentu dan menutup menu lainnya
    setTimeout(() => {

        // Membuka menu yang sudah ditentukan sebelumnya (main-menu dan charts)
        expandMenu();

        // Menutup menu parent lain (level 1 & level 2) yang tidak termasuk submenu default
        $('#sidebar ul li.custom-menu-sidebar, #sidebar ul li.main-menu-child').each(function () {

            // Elemen menu (<li>) yang sedang diproses saat ini
            const $li = $(this);

            // Mengambil ID panel collapse dari atribut data-target
            const target = $li.find('> a').attr('data-target');

            // Jika target bukan main-menu dan charts, maka :
            if (!autoExpandMenus.includes(target)) {

                // Menghapus tanda aktif pada menu
                $li.removeClass('active');

                // Menutup submenu jika ada
                const $collapse = $(target);
                if ($collapse.length) $collapse.collapse('hide');

                // Mengembalikan status tombol menu ke kondisi tertutup
                $li.find('> a').attr('aria-expanded', 'false').removeClass('active');
            }
        });
    }, 200);


    // ===========================================================================================
    // AKSI SAAT MENU PARENT (LEVEL 1 & LEVEL 2) DIKLIK
    // ===========================================================================================
    // Mengatur buka atau tutup panel collapse di sidebar
    $('#sidebar ul li.custom-menu-sidebar > a, #sidebar ul li.main-menu-child > a').on('click', function () {

        const $link = $(this); // Link menu yang sedang diklik

        // Menu induk (<li>) dari link tersebut
        const $li = $link.closest('.custom-menu-sidebar, .main-menu-child');

        // Mengecek apakah link ini berfungsi sebagai dropdown submenu
        const isDropdown = $link.attr('data-toggle') === 'collapse';

        // Jalankan hanya jika menu memang memiliki submenu
        if (isDropdown) {

            // Ambil ID submenu yang terhubung dengan menu ini
            const target = $link.attr('data-target');

            // Ambil elemen submenu berdasarkan target
            const $collapse = $(target);

            // Menutup menu parent lain pada level yang sama agar hanya satu dropdown yang aktif
            $li.siblings('.custom-menu-sidebar, .main-menu-child')
                .removeClass('active')
                .find('.collapse.show').collapse('hide');

            // Mengembalikan status tombol menu lain ke kondisi tertutup
            $li.siblings('.custom-menu-sidebar, .main-menu-child')
                .find('[data-toggle="collapse"]')
                .attr('aria-expanded', 'false')
                .removeClass('active');

            // Mengecek apakah submenu ini sedang terbuka
            const isOpen = $collapse.hasClass('show');

            // Membuka atau menutup submenu yang diklik
            $collapse.collapse('toggle');
            $li.toggleClass('active');

            // Menjaga agar menu level 1 tetap terlihat aktif saat submenu level 2 dibuka
            $li.parents('.custom-menu-sidebar').addClass('active');

            // Jika yang dibuka adalah main-menu, maka :
            if (target === '#main-menu' && !isOpen) {
                expandMenu(); // Submenu charts ikut dibuka otomatis
            }
        }
    });


    // ===========================================================================================
    // MENENTUKAN MENU YANG AKTIF BERDASARKAN HALAMAN YANG DIBUKA
    // ===========================================================================================
    // Menandai menu aktif berdasarkan URL halaman saat ini
    const currentPath = window.location.pathname + window.location.search + window.location.hash;

    // Mengecek semua link menu yang ada di sidebar
    $('#sidebar ul li.custom-menu-sidebar a, #sidebar ul li.main-menu-child a').each(function () {

        // Abaikan elemen tanpa pathname (biasanya tombol dropdown)
        if (!this.pathname) return;

        // Gabungkan pathname + query + hash dari link
        const link = this.pathname + this.search + this.hash;

        // Mengambil elemen menu induk (<li>) dari link tersebut
        const $li = $(this).closest('.custom-menu-sidebar, .main-menu-child');

        // Jika URL saat ini sama dengan link menu, maka :
        if (currentPath === link) {

            // Menandai menu sebagai menu yang sedang aktif
            $li.addClass('active');

            // Membuka panel collapse di dalam menu aktif agar jalur menu ke halaman terlihat
            $li.find('.collapse').addClass('show');

            // Menandai bahwa submenu dalam kondisi terbuka
            $li.find('[data-toggle="collapse"]').attr('aria-expanded', 'true');

            // Jika menu ini adalah submenu, maka :
            if ($li.hasClass('main-menu-child')) {
                $(this).addClass('active'); // Link-nya juga ditandai sebagai aktif
            }
        }
    });

});