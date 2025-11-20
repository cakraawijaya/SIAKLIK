$(document).ready(function () {

    // ===============================
    // Scrollbar sidebar
    // ===============================
    $("#sidebar").mCustomScrollbar({ theme: "minimal" });

    // ===============================
    // Toggle sidebar buka/tutup
    // ===============================
    function isMobile() { return window.innerWidth <= 768; }
    $('#sidebarCollapse, #sidebarCollapse2').on('click', function () {

        if (isMobile()) {
            // MODE MOBILE
            $('#sidebar').toggleClass('show');
            $('body').toggleClass('sidebar-open');
        } else {
            // MODE DESKTOP
            $('#sidebar, #content').toggleClass('active');
        }
    });

    // ===============================
    // Fungsi expand main-menu + charts
    // ===============================
    const autoExpandMenus = ['#main-menu', '#charts'];

    const expandMenu = () => {
        autoExpandMenus.forEach(menuId => {

            // TARGET COLLAPSE
            const $menu = $(menuId);

            // TRIGGER MENGGUNAKAN DATA-TARGET
            const $toggle = $(`a[data-target="${menuId}"]`);

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

        // Tutup dropdown lain yang bukan main-menu atau charts
        $('#sidebar ul li.custom-menu-sidebar, #sidebar ul li.main-menu-child').each(function () {
            const $li = $(this);

            // target collapse dari tombol
            const target = $li.find('> a').attr('data-target');

            if (!autoExpandMenus.includes(target)) {
                $li.removeClass('active');

                const $collapse = $(target);
                if ($collapse.length) $collapse.collapse('hide');

                $li.find('> a')
                    .attr('aria-expanded', 'false')
                    .removeClass('active');
            }
        });
    }, 200);

    // ===============================
    // Klik dropdown → toggle collapse
    // ===============================
    $('#sidebar ul li.custom-menu-sidebar > a, #sidebar ul li.main-menu-child > a').on('click', function () {

        const $link = $(this);
        const $li = $link.closest('.custom-menu-sidebar, .main-menu-child');

        const isDropdown = $link.attr('data-toggle') === 'collapse';

        if (isDropdown) {

            const target = $link.attr('data-target');
            const $collapse = $(target);

            // Tutup sibling lain
            $li.siblings('.custom-menu-sidebar, .main-menu-child')
                .removeClass('active')
                .find('.collapse.show').collapse('hide');

            $li.siblings('.custom-menu-sidebar, .main-menu-child')
                .find('[data-toggle="collapse"]')
                .attr('aria-expanded', 'false')
                .removeClass('active');

            // Toggle collapse
            const isOpen = $collapse.hasClass('show');

            $collapse.collapse('toggle');
            $li.toggleClass('active');

            // Parent tetap aktif
            $li.parents('.custom-menu-sidebar').addClass('active');

            // Jika buka main-menu → auto expand charts
            if (target === '#main-menu' && !isOpen) {
                expandMenu();
            }
        }
    });

    // ===============================
    // Tandai menu aktif berdasarkan URL
    // ===============================
    const currentPath = window.location.pathname + window.location.search + window.location.hash;

    $('#sidebar ul li.custom-menu-sidebar a, #sidebar ul li.main-menu-child a').each(function () {

        // Abaikan elemen tanpa href (misal dropdown toggle)
        if (!this.pathname) return;

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