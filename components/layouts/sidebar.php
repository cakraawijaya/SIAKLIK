<!-- Sidebar  -->
<nav id="sidebar">
    <div class="close-sidebar">
        <button type="button" id="sidebarCollapse2" class="close-button">
            <i class="fas fa-times" aria-hidden="true"></i>
            <span></span>
        </button>
    </div>
    <div class="sidebar-header">
        <ul class="brand">
            <li class="brand-child">
                <img class="brand-logo select-none" src="<?= BASE_URL ?>public/assets/img/favicon/logo.png" alt="logo-upn">
            </li>
            <li class="brand-child">
                <a class="brand-text" onclick="openLink('<?= BASE_URL ?>', false)">
                    <p class="title select-none">SIAKLIK</p>
                    <p class="sub-title text-small select-none">Sistem Pelayanan Klinik Kesehatan</p>
                </a>
            </li>
            
            <?php if (isset($_SESSION['level'])): ?>
                <div class="divider-role"></div>
                <?php
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
                
                <span class="mb-0 role select-none">
                    <i class="fas fa-circle online mr-2" aria-hidden="true"></i><?= $role ?>
                </span>

                <?php if (!empty($nama)): ?>
                    <span class="nama-user text-white text-small select-none">
                        <?= htmlspecialchars($nama); ?>
                    </span>
                <?php endif; ?>
                
            <?php endif; ?>
        </ul>
    </div>
    <div class="divider-sidebar-top"></div>
    <ul class="custom-bg-sidebar list-unstyled">
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#main-menu', false)" data-toggle="collapse" aria-expanded="false" data-target="#main-menu" class="dropdown-toggle">
                <i class="fas fa-layer-group mr-2" aria-hidden="true"></i>
                Menu Utama
            </a>
            <ul class="collapse list-unstyled" id="main-menu">
                
                <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                    <li>
                        <a onclick="openLink('#', false)" data-toggle="modal" data-target="#modalLoginPasien" class="custom-mt-sidebar">
                            <i class="fas fa-sign-in-alt mr-2" aria-hidden="true"></i>
                            <span>Masuk</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php 
                    // Jika login sebagai pekerja / admin → beri class css: custom-mt-sidebar hanya pada Dashboard Poliklinik
                    $allowed_roles = ['pekerja', 'admin'];
                    if(isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):
                ?>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=worker/dashboard', false)" class="custom-mt-sidebar">
                            <i class="fas fa-laptop-house mr-2" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_registration', false)">
                            <i class="fas fa-user-tag mr-2" aria-hidden="true"></i>
                            <span>Registrasi Antrean</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_status', false)">
                            <i class="fas fa-tasks mr-2" aria-hidden="true"></i>
                            <span>Status Antrean</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php 
                    // Jika login sebagai pasien → beri class css: custom-mt-sidebar hanya pada Daftar Antrean
                    if (isset($_SESSION['level']) && $_SESSION['level'] == 'pasien'):
                ?>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_registration', false)" class="custom-mt-sidebar">
                            <i class="fas fa-user-tag mr-2" aria-hidden="true"></i>
                            <span>Registrasi Antrean</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/queue_status', false)">
                            <i class="fas fa-tasks mr-2" aria-hidden="true"></i>
                            <span>Status Antrean</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <li>
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_information', false)">
                        <i class="fas fa-info-circle mr-2" aria-hidden="true"></i>
                        <span>Informasi Pelayanan</span>
                    </a>
                </li>
                <li class="main-menu-child">
                    <a onclick="openLink('#charts', false)" data-toggle="collapse" aria-expanded="false" data-target="#charts" class="dropdown-toggle">
                        <i class="fas fa-chart-line mr-2" aria-hidden="true"></i>
                        <span>Grafik Kunjungan</span>
                    </a>
                    <ul class="collapse list-unstyled" id="charts">
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_gender', false)" class="custom-mt-sidebar-child">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>Jenis Kelamin</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2013', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2013</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2014', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2014</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2015', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2015</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2016', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2016</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2017', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2017</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2018', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2018</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2019', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2019</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2020', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2020</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2021', false)">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2021</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/chart/chart_2022', false)" class="custom-mb-sidebar-child">
                                <i class="fas fa-procedures mr-2" aria-hidden="true"></i>
                                <span>SATKER Tahun 2022</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                    $is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
                ?>

                <li>
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/clinic_facilities', false)" class="<?= !$is_logged_in ? 'custom-mb-sidebar' : '' ?>">
                        <i class="fas fa-hand-holding-medical mr-2" aria-hidden="true"></i>
                        <span>Fasilitas Poliklinik</span>
                    </a>
                </li>

                <?php if ($is_logged_in): ?> 
                    <li>
                        <a onclick="openLink('<?= BASE_URL ?>components/features/auth/authentication/logout.php', false)" class="custom-mb-sidebar">
                            <i class="fas fa-sign-out-alt mr-2" aria-hidden="true"></i> 
                            <span>Keluar</span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </li>
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#article', false)" data-toggle="collapse" aria-expanded="false" data-target="#article" class="dropdown-toggle">
                <i class="fas fa-newspaper mr-2" aria-hidden="true"></i>
                Artikel
            </a>
            <ul class="collapse list-unstyled" id="article">
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/hiv.pdf', true)" class="custom-mt-sidebar">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>HIV / AIDS</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/stroke.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Stroke</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/tuberkulosis.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>TBC (Tuberkulosis)</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/hepatitis.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Hepatitis</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/diare.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Diare</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/pneumonia.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Pneumonia</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/difteri.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Difteri</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/dbd.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>DBD (Demam Berdarah Dengue)</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/kanker.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Kanker</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/kusta.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Kusta</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/stunting.pdf', true)">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>Stunting (Gizi Buruk)</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('https://mozilla.github.io/pdf.js/web/viewer.html?file=https://raw.githubusercontent.com/cakraawijaya/SIAKLIK/master/public/assets/pdf/covid19.pdf', true)" class="custom-mb-sidebar">
                        <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                        <span>COVID-19</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#service-hours', false)" data-toggle="collapse" aria-expanded="false" data-target="#service-hours" class="dropdown-toggle">
                <i class="fa fa-clock mr-2" aria-hidden="true"></i>
                Jam Layanan
            </a>
            <ul class="collapse list-unstyled" id="service-hours">
                <li>
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="far fa-clock mr-2" aria-hidden="true"></i>
                        <span>Buka Jam: <u>07.30 WIB</u></span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('#', false)">
                        <i class="fas fa-store-alt-slash mr-2" aria-hidden="true"></i>
                        <span>Tutup Jam: <u>15:30 WIB</u></span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-calendar-week mr-2" aria-hidden="true"></i>
                        <span>Hari kerja: <u>Senin - Jumat</u></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#contact', false)" data-toggle="collapse" aria-expanded="false" data-target="#contact" class="dropdown-toggle">
                <i class="fas fa-address-book mr-2" aria-hidden="true"></i>
                Kontak
            </a>
            <ul class="collapse list-unstyled" id="contact">
                <li>
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="fas fa-phone-alt mr-2" aria-hidden="true"></i>
                        <span>Telp: <u>031-8706369</u></span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-envelope mr-2" aria-hidden="true"></i>
                        <span>E-mail: <u>poliklinik@upnvjatim.ac.id</u></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#doctor', false)" data-toggle="collapse" aria-expanded="false" data-target="#doctor" class="dropdown-toggle">
                <i class="fas fa-stethoscope mr-2" aria-hidden="true"></i>
                Dokter
            </a>
            <ul class="collapse list-unstyled" id="doctor">
                <li>
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="fas fa-user-md mr-2" aria-hidden="true"></i>
                        <span>dr. R.Rr. Henny Yuniarti</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-user-md mr-2" aria-hidden="true"></i>
                        <span>drg. Ida Aprilianti</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#nurse', false)" data-toggle="collapse" aria-expanded="false" data-target="#nurse" class="dropdown-toggle">
                <i class="fas fa-briefcase-medical mr-2" aria-hidden="true"></i>
                Perawat
            </a>
            <ul class="collapse list-unstyled" id="nurse">
                <li>
                    <a onclick="openLink('#', false)" class="custom-mt-sidebar">
                        <i class="fas fa-user-nurse mr-2" aria-hidden="true"></i>
                        <span>Moh. Toyyib, S.Kep</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('#', false)" class="custom-mb-sidebar">
                        <i class="fas fa-user-nurse mr-2" aria-hidden="true"></i>
                        <span>Mufarida, A.Md. Kep</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="custom-menu-sidebar select-none">
            <a onclick="openLink('#gallery', false)" data-toggle="collapse" aria-expanded="false" data-target="#gallery" class="dropdown-toggle">
                <i class="fas fa-photo-video mr-2" aria-hidden="true"></i>
                Galeri
            </a>
            <ul class="collapse list-unstyled" id="gallery">
                <li>
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/gallery#gallery-foto', false)" class="custom-mt-sidebar">
                        <i class="fas fa-image mr-2" aria-hidden="true"></i>
                        <span>Album Foto</span>
                    </a>
                </li>
                <li>
                    <a onclick="openLink('<?= BASE_URL ?>index.php?page=patient/clinic/gallery#gallery-video', false)" class="custom-mb-sidebar">
                        <i class="fas fa-film mr-2" aria-hidden="true"></i>
                        <span>Album Video</span>
                    </a>
                </li>
            </ul>
        </li>
        <div class="divider-sidebar-bottom"></div>
    </ul>
</nav>