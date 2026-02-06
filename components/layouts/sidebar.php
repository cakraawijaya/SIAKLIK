<!-- SIDEBAR -->
<nav id="sidebar">


    <!--
    ===========================================================================================
    TOMBOL TUTUP SIDEBAR
    - Digunakan untuk menutup sidebar pada tampilan mobile (layar kecil)
    ===========================================================================================
    -->
    <div class="close-sidebar">
        <button type="button" id="sidebarCollapse2" class="close-button">
            <i class="fas fa-times" aria-hidden="true"></i>
            <span></span>
        </button>
    </div>


    <!--
    ===========================================================================================
    HEADER SIDEBAR
    - Menampilkan logo, nama aplikasi, dan identitas user (jika login)
    ===========================================================================================
    -->
    <div class="sidebar-header">
        <ul class="brand">

            <!-- Logo Aplikasi -->
            <li class="brand-child">
                <img class="brand-logo select-none" src="<?= BASE_URL ?>public/assets/img/favicon/logo.png" alt="logo-upn">
            </li>

            <!-- Nama & Deskripsi Aplikasi -->
            <li class="brand-child">
                <a class="brand-text" onclick="openLink('<?= BASE_URL ?>', false)">
                    <p class="title select-none">SIAKLIK</p>
                    <p class="sub-title text-small select-none">Sistem Pelayanan Klinik Kesehatan</p>
                </a>
            </li>


            <!--
            ===========================================================================================
            INFO USER LOGIN
            - Ditampilkan jika user sudah login
            - Menampilkan role dan nama user
            ===========================================================================================
            -->
            <?php if (isset($_SESSION['level'])): ?>
                <div class="divider-role"></div> <!-- Garis pemisah role user -->

                <?php
                    // Mapping role berdasarkan level user
                    $role = '';
                    switch ($_SESSION['level']) {
                        case 'admin':
                            $role = 'Admin Poliklinik';
                            break;
                        case 'pekerja':
                            $role = 'Pekerja Poliklinik';
                            break;
                        case 'pasien':
                            $role = 'Pasien Poliklinik';
                            break;
                    }

                    // Mengambil nama user dari database
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];

                        $nama = null;
                        $stmt = $koneksi->prepare("
                            SELECT nama FROM akun_pekerja WHERE username = ?
                            UNION
                            SELECT nama FROM akun_pasien WHERE username = ?
                            LIMIT 1
                        ");
                        $stmt->bind_param('ss', $username, $username);
                        $stmt->execute();
                        $stmt->bind_result($nama);
                        $stmt->fetch();
                        $stmt->close();
                    }
                ?>


                <!-- Role User -->
                <span class="mb-0 role select-none">
                    <i class="fas fa-circle online mr-2" aria-hidden="true"></i><?= $role ?>
                </span>

                <!-- Nama User -->
                <?php if (!empty($nama)): ?>
                    <span class="nama-user text-white text-small select-none">
                        <?= htmlspecialchars($nama); ?>
                    </span>
                <?php endif; ?>

            <?php endif; ?>
        </ul>
    </div>

    <div class="divider-sidebar-top"></div>  <!-- Garis pemisah sidebar bagian atas -->


    <!--
    ===========================================================================================
    MENU SIDEBAR
    - Berisi seluruh navigasi aplikasi
    - Menu muncul berdasarkan status login dan role
    ===========================================================================================
    -->
    <ul class="custom-bg-sidebar list-unstyled">


        <!--
        ===================================================================================
        MENU UTAMA
        ===================================================================================
        -->
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#main-menu', false)" data-toggle="collapse" aria-expanded="false" data-target="#main-menu" class="dropdown-toggle">
                <i class="fas fa-layer-group mr-2" aria-hidden="true"></i>
                Menu Utama
            </a>
            <ul class="collapse list-unstyled" id="main-menu">

                <?php
                    // Jika belum login, maka tampilkan :
                    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true):
                ?>

                    <!-- Masuk -->
                    <li>
                        <!-- Tambahkan class css: custom-mt-sidebar -->
                        <a onclick="openLink('#', false)" data-toggle="modal" data-target="#modalLoginPasien" class="custom-mt-sidebar">
                            <i class="fas fa-sign-in-alt mr-2" aria-hidden="true"></i>
                            <span>Masuk</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menu khusus untuk Admin -->
                <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>

                    <!-- Dashboard -->
                    <li>
                        <!-- Tambahkan class css: custom-mt-sidebar -->
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=admin/dashboard', false)" class="custom-mt-sidebar">
                            <i class="fas fa-laptop-house mr-2" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Catatan Aktivitas -->
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=admin/user_log', false)">
                            <i class="fas fa-folder-open mr-2" aria-hidden="true"></i>
                            <span>Catatan Aktivitas</span>
                        </a>
                    </li>

                <?php endif; ?>

                <!-- Menu khusus untuk Pekerja -->
                <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'pekerja'): ?>

                    <!-- Dashboard -->
                    <li>
                        <!-- Tambahkan class css: custom-mt-sidebar -->
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=worker/dashboard', false)" class="custom-mt-sidebar">
                            <i class="fas fa-laptop-house mr-2" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                <?php endif; ?>

                <!-- Menu untuk Pekerja dan Admin -->
                <?php
                    $allowed_roles = ['pekerja', 'admin'];
                    if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                ?>

                    <!-- Registrasi Antrean -->
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_registration', false)">
                            <i class="fas fa-user-tag mr-2" aria-hidden="true"></i>
                            <span>Registrasi Antrean</span>
                        </a>
                    </li>

                    <!-- Status Antrean -->
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_status', false)">
                            <i class="fas fa-tasks mr-2" aria-hidden="true"></i>
                            <span>Status Antrean</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menu khusus untuk Pasien -->
                <?php
                    if (isset($_SESSION['level']) && $_SESSION['level'] == 'pasien'):
                ?>

                    <!-- Registrasi Antrean -->
                    <li>
                        <!-- Tambahkan class css: custom-mt-sidebar -->
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_registration', false)" class="custom-mt-sidebar">
                            <i class="fas fa-user-tag mr-2" aria-hidden="true"></i>
                            <span>Registrasi Antrean</span>
                        </a>
                    </li>

                    <!-- Status Antrean -->
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_status', false)">
                            <i class="fas fa-tasks mr-2" aria-hidden="true"></i>
                            <span>Status Antrean</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Informasi Pelayanan -->
                <li>
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_information', false)">
                        <i class="fas fa-info-circle mr-2" aria-hidden="true"></i>
                        <span>Informasi Pelayanan</span>
                    </a>
                </li>

                <!-- Grafik Kunjungan -->
                <li class="main-menu-child">
                    <a onclick="openLink('#charts', false)" data-toggle="collapse" aria-expanded="false" data-target="#charts" class="dropdown-toggle">
                        <i class="fas fa-chart-line mr-2" aria-hidden="true"></i>
                        <span>Grafik Kunjungan</span>
                    </a>
                    <ul class="collapse list-unstyled" id="charts">

                        <!-- Kunjungan pasien berdasarkan Jenis Kelamin -->
                        <li>
                            <!-- Tambahkan class css: custom-mt-sidebar-child -->
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_gender', false)" class="custom-mt-sidebar-child">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>Jenis Kelamin</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2013 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2013', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2013</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2014 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2014', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2014</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2015 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2015', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2015</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2016 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2016', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2016</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2017 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2017', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2017</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2018 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2018', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2018</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2019 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2019', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2019</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2020 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2020', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2020</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2021 -->
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2021', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2021</span>
                            </a>
                        </li>

                        <!-- Kunjungan pasien berdasarkan SATKER Tahun 2022 -->
                        <li>
                            <!-- Tambahkan class css: custom-mb-sidebar-child -->
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2022', false)" class="custom-mb-sidebar-child">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2022</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                    // Variabel "is_logged_in" ini untuk mengecek apakah User sedang login
                    $is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
                ?>

                <!-- Fasilitas Poliklinik -->
                <li>
                    <!-- Jika belum login, Tambahkan class css: custom-mb-sidebar -->
                    <!-- Jika sedang login, Hapus class css: custom-mb-sidebar -->
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_facilities', false)" class="<?= !$is_logged_in ? 'custom-mb-sidebar' : '' ?>">
                        <i class="fas fa-hand-holding-medical mr-2" aria-hidden="true"></i>
                        <span>Fasilitas Poliklinik</span>
                    </a>
                </li>

                <!-- Pengaturan akun Admin -->
                <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=admin/profile', false)">
                            <i class="fas fa-user-cog mr-2" aria-hidden="true"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Pengaturan akun Pekerja -->
                <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'pekerja'): ?>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=worker/profile', false)">
                            <i class="fas fa-user-cog mr-2" aria-hidden="true"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Pengaturan akun Pasien -->
                <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'pasien'): ?>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/profile', false)">
                            <i class="fas fa-user-cog mr-2" aria-hidden="true"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php
                    if ($is_logged_in): // Jika sedang login, maka tampilkan :
                ?>

                    <!-- Keluar -->
                    <li>
                        <!-- Tambahkan class css: custom-mb-sidebar -->
                        <a onclick="openLink('<?= BASE_URL ?>components/features/auth/authentication/logout.php', false)" class="custom-mb-sidebar">
                            <i class="fas fa-sign-out-alt mr-2" aria-hidden="true"></i> 
                            <span>Keluar</span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </li>


        <!--
        ===================================================================================
        MENU INFORMASI: ARTIKEL
        ===================================================================================
        -->
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#article', false)" data-toggle="collapse" aria-expanded="false" data-target="#article" class="dropdown-toggle">
                <i class="fas fa-newspaper mr-2" aria-hidden="true"></i>
                Artikel
            </a>
            <ul class="collapse list-unstyled" id="article">

                <!-- Artikel HIV / AIDS -->
                <li>
                    <!-- Tambahkan class css: custom-mt-sidebar -->
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/hiv.pdf', true)" class="custom-mt-sidebar">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>HIV / AIDS</span>
                    </a>
                </li>

                <!-- Artikel Stroke -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/stroke.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Stroke</span>
                    </a>
                </li>

                <!-- Artikel TBC (Tuberkulosis) -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/tuberkulosis.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>TBC (Tuberkulosis)</span>
                    </a>
                </li>

                <!-- Artikel Hepatitis -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/hepatitis.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Hepatitis</span>
                    </a>
                </li>

                <!-- Artikel Diare -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/diare.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Diare</span>
                    </a>
                </li>

                <!-- Artikel Pneumonia -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/pneumonia.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Pneumonia</span>
                    </a>
                </li>

                <!-- Artikel Difteri -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/difteri.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Difteri</span>
                    </a>
                </li>

                <!-- Artikel DBD (Demam Berdarah Dengue) -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/dbd.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>DBD (Demam Berdarah Dengue)</span>
                    </a>
                </li>

                <!-- Artikel Kanker -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/kanker.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Kanker</span>
                    </a>
                </li>

                <!-- Artikel Kusta -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/kusta.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Kusta</span>
                    </a>
                </li>

                <!-- Artikel Stunting (Gizi Buruk) -->
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/stunting.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Stunting (Gizi Buruk)</span>
                    </a>
                </li>

                <!-- Artikel COVID-19 -->
                <li>
                    <!-- Tambahkan class css: custom-mb-sidebar -->
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/covid19.pdf', true)" class="custom-mb-sidebar">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>COVID-19</span>
                    </a>
                </li>
            </ul>
        </li>


        <!--
        ===================================================================================
        MENU INFORMASI: JAM LAYANAN
        ===================================================================================
        -->
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#service-hours', false)" data-toggle="collapse" aria-expanded="false" data-target="#service-hours" class="dropdown-toggle">
                <i class="fa fa-clock mr-2" aria-hidden="true"></i>
                Jam Layanan
            </a>
            <ul class="collapse list-unstyled" id="service-hours">

                <!-- Jam Buka Poliklinik -->
                <li>
                    <!-- Tambahkan class css: custom-mt-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="far fa-clock mr-2" aria-hidden="true"></i>
                        <span>Buka Jam: <u>07.30 WIB</u></span>
                    </a>
                </li>

                <!-- Jam Tutup Poliklinik -->
                <li>
                    <a onclick="openLink('#', false)">
                        <i class="fas fa-store-alt-slash mr-2" aria-hidden="true"></i>
                        <span>Tutup Jam: <u>15:30 WIB</u></span>
                    </a>
                </li>

                <!-- Hari Kerja Poliklinik -->
                <li>
                    <!-- Tambahkan class css: custom-mb-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-calendar-week mr-2" aria-hidden="true"></i>
                        <span>Hari kerja: <u>Senin - Jumat</u></span>
                    </a>
                </li>
            </ul>
        </li>


        <!--
        ===================================================================================
        MENU INFORMASI: KONTAK
        ===================================================================================
        -->
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#contact', false)" data-toggle="collapse" aria-expanded="false" data-target="#contact" class="dropdown-toggle">
                <i class="fas fa-address-book mr-2" aria-hidden="true"></i>
                Kontak
            </a>
            <ul class="collapse list-unstyled" id="contact">

                <!-- Telp Poliklinik -->
                <li>
                    <!-- Tambahkan class css: custom-mt-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="fas fa-phone-alt mr-2" aria-hidden="true"></i>
                        <span>Telp: <u>031-8706369</u></span>
                    </a>
                </li>

                <!-- Email Poliklinik -->
                <li>
                    <!-- Tambahkan class css: custom-mb-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-envelope mr-2" aria-hidden="true"></i>
                        <span>E-mail: <u>poliklinik@upnvjatim.ac.id</u></span>
                    </a>
                </li>
            </ul>
        </li>


        <!--
        ===================================================================================
        MENU INFORMASI: DOKTER
        ===================================================================================
        -->
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#doctor', false)" data-toggle="collapse" aria-expanded="false" data-target="#doctor" class="dropdown-toggle">
                <i class="fas fa-stethoscope mr-2" aria-hidden="true"></i>
                Dokter
            </a>
            <ul class="collapse list-unstyled" id="doctor">

                <!-- Dokter Umum -->
                <li>
                    <!-- Tambahkan class css: custom-mt-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="fas fa-user-md mr-2" aria-hidden="true"></i>
                        <span>dr. R.Rr. Henny Yuniarti</span>
                    </a>
                </li>

                <!-- Dokter Gigi -->
                <li>
                    <!-- Tambahkan class css: custom-mb-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-user-md mr-2" aria-hidden="true"></i>
                        <span>drg. Ida Aprilianti</span>
                    </a>
                </li>
            </ul>
        </li>


        <!--
        ===================================================================================
        MENU INFORMASI: PERAWAT
        ===================================================================================
        -->
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#nurse', false)" data-toggle="collapse" aria-expanded="false" data-target="#nurse" class="dropdown-toggle">
                <i class="fas fa-briefcase-medical mr-2" aria-hidden="true"></i>
                Perawat
            </a>
            <ul class="collapse list-unstyled" id="nurse">

                <!-- Perawat 1 -->
                <li>
                    <!-- Tambahkan class css: custom-mt-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="fas fa-user-nurse mr-2" aria-hidden="true"></i>
                        <span>Moh. Toyyib, S.Kep</span>
                    </a>
                </li>

                <!-- Perawat 2 -->
                <li>
                    <!-- Tambahkan class css: custom-mb-sidebar -->
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-user-nurse mr-2" aria-hidden="true"></i>
                        <span>Mufarida, A.Md. Kep</span>
                    </a>
                </li>
            </ul>
        </li>


        <!--
        ===================================================================================
        MENU INFORMASI: GALERI
        ===================================================================================
        -->
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#gallery', false)" data-toggle="collapse" aria-expanded="false" data-target="#gallery" class="dropdown-toggle">
                <i class="fas fa-photo-video mr-2" aria-hidden="true"></i>
                Galeri
            </a>
            <ul class="collapse list-unstyled" id="gallery">

                <!-- Album Foto -->
                <li>
                    <!-- Tambahkan class css: custom-mt-sidebar -->
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/gallery#gallery-foto', false)" class="custom-mt-sidebar">
                        <i class="fas fa-image mr-2" aria-hidden="true"></i>
                        <span>Album Foto</span>
                    </a>
                </li>

                <!-- Album Video -->
                <li>
                    <!-- Tambahkan class css: custom-mb-sidebar -->
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/gallery#gallery-video', false)" class="custom-mb-sidebar">
                        <i class="fas fa-film mr-2" aria-hidden="true"></i>
                        <span>Album Video</span>
                    </a>
                </li>
            </ul>
        </li>

        <div class="divider-sidebar-bottom"></div> <!-- Garis pemisah sidebar bagian bawah -->
    </ul>
</nav>