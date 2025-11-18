$(document).ready(function () {
    // Scrollbar sidebar
    $("#sidebar").mCustomScrollbar({ theme: "minimal" });

    // Toggle sidebar buka/tutup
    $('#sidebarCollapse, #sidebarCollapse2').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').removeClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    // ===============================
    // Fungsi expand main-menu + charts
    // ===============================
    const autoExpandMenus = ['#main-menu', '#charts'];
    const expandMenu = () => {
        autoExpandMenus.forEach(menuId => {
            const $menu = $(menuId);
            const $toggle = $(`a[href="${menuId}"]`);
            if ($menu.length && $toggle.length) {
                $menu.addClass('show').collapse('show');
                $toggle.attr('aria-expanded', 'true');

                const $li = $toggle.closest('.custom-menu-sidebar, .main-menu-child');
                if ($li.length) $li.addClass('active');

                if ($li.hasClass('main-menu-child')) {
                    $toggle.addClass('active');
                }
            }
        });
    };

    // ===============================
    // Auto-expand awal
    // ===============================
    setTimeout(() => {
        expandMenu();

        // Tutup semua dropdown lain yang bukan main-menu atau charts
        $('#sidebar ul li.custom-menu-sidebar, #sidebar ul li.main-menu-child').each(function () {
            const $li = $(this);
            const id = $li.find('> a').attr('href');
            if (!autoExpandMenus.includes(id)) {
                $li.removeClass('active');
                const $collapse = $(id);
                if ($collapse.length) $collapse.collapse('hide');
                $li.find('> a').attr('aria-expanded', 'false').removeClass('active');
            }
        });
    }, 200);

    // ===============================
    // Klik dropdown → toggle active & collapse
    // ===============================
    $('#sidebar ul li.custom-menu-sidebar > a, #sidebar ul li.main-menu-child > a').on('click', function () {
        const $link = $(this);
        const $li = $link.closest('.custom-menu-sidebar, .main-menu-child');
        const isDropdown = $link.attr('data-toggle') === 'collapse';

        if (isDropdown) {
            // Tutup sibling menu
            $li.siblings('.custom-menu-sidebar, .main-menu-child').removeClass('active')
                .find('.collapse.show').collapse('hide');
            $li.siblings('.custom-menu-sidebar, .main-menu-child').find('[data-toggle="collapse"]').attr('aria-expanded', 'false').removeClass('active');

            // Toggle dropdown
            const $collapse = $($link.attr('href'));
            const isOpen = $collapse.hasClass('show'); // cek status sebelum toggle
            $collapse.collapse('toggle');
            $li.toggleClass('active');

            // Parent tetap aktif
            $li.parents('.custom-menu-sidebar').addClass('active');

            // Jika klik main-menu dan sebelumnya tertutup → expand charts
            if ($link.attr('href') === '#main-menu' && !isOpen) {
                expandMenu();
            }
        }
    });

    // ===============================
    // Tandai menu sesuai URL (termasuk hash)
    // ===============================
    const currentPath = window.location.pathname + window.location.search + window.location.hash;
    $('#sidebar ul li.custom-menu-sidebar a, #sidebar ul li.main-menu-child a').each(function () {
        const link = this.pathname + this.search + this.hash;
        const $li = $(this).closest('.custom-menu-sidebar, .main-menu-child');

        if (currentPath === link) {
            $li.addClass('active');
            $li.find('.collapse').addClass('show');
            $li.find('[data-toggle="collapse"]').attr('aria-expanded', 'true');

            if ($li.hasClass('main-menu-child')) {
                $(this).addClass('active');
            }
        }
    });
});