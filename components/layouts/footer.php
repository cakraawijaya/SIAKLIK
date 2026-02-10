                <!-- FOOTER -->
                <footer class="footer-section text-light select-none">
                    <div class="container">
                        <div class="row g-3">

                            <!-- Informasi Lokasi Klinik -->
                            <div class="col-md-4 my-3 py-2 select-none">
                                <h5 class="footer-title">
                                    <i class="footer-icons fas fa-map-marker-alt" aria-hidden="true"></i>
                                    <span>Lokasi</span>
                                </h5>

                                <p>Jl. Rungkut Madya No.1, Gn. Anyar, Kec. Gn. Anyar, Kota SBY, Jawa Timur</p>

                                <!-- Link Google Maps -->
                                <a onclick="openLink('https://maps.app.goo.gl/MCWaaT6fg1CZRLd89', true)"
                                target="_blank"
                                class="maps-link d-block mt-2">
                                    <i class="fas fa-map-marked-alt mr-2" aria-hidden="true"></i>
                                    <span>Lihat di Google Maps</span>
                                </a>
                            </div>

                            <!-- Informasi Kontak & Media Sosial -->
                            <div class="col-md-4 my-3 py-2 select-none">
                                <h5 class="footer-title">
                                    <i class="footer-icons fas fa-address-book" aria-hidden="true"></i>
                                    <span>Kontak</span>
                                </h5>

                                <ul class="list-unstyled footer-list">
                                    <li><span><i class="fas fa-phone-alt mr-1" aria-hidden="true"></i>031-8706369</span></li>
                                    <li><span class="footer-email"><i class="fas fa-envelope mr-1" aria-hidden="true"></i>poliklinik@upnvjatim.ac.id</span></li>
                                </ul>

                                <!-- Social Media -->
                                <div class="mt-3 social-wrap">
                                    <a onclick="openLink('#', false)" class="social-icon"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    <a onclick="openLink('#', false)" class="social-icon"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                    <a onclick="openLink('#', false)" class="social-icon"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                    <a onclick="openLink('#', false)" class="social-icon"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                </div>
                            </div>

                            <!-- Jam Praktek Klinik -->
                            <div class="col-md-4 my-3 py-2 select-none">
                                <h5 class="footer-title">
                                    <i class="footer-icons fas fa-clock" aria-hidden="true"></i>
                                    <span>Praktek</span>
                                </h5>
                                
                                <ul class="list-unstyled footer-list">
                                    <li><span><strong>Senin - Jumat:</strong>&nbsp; 07.30 – 15.30</span></li>
                                    <li><span><strong>Sabtu & Minggu:</strong>&nbsp; Libur</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Hak Cipta -->
                    <div class="footer-copyright text-center py-3 mt-5 pt-2">
                        © 2021–<?= date("Y"); ?> <strong>SIAKLIK (Sistem Pelayanan Klinik Kesehatan)</strong>. All Rights Reserved
                    </div>
                </footer>

                <!-- Tombol Scroll ke Atas -->
                <a onclick="openLink('#', false)" class="vanillatop"><i class="fas fa-angle-up" aria-hidden="true"></i></a>

                <!-- Modal Login -->
                <?php include __DIR__ . '/../modal/login.php'; ?>

                <!-- Modal Register -->
                <?php include __DIR__ . '/../modal/registration.php'; ?>

                <!-- Modal Forgot Password -->
                <?php include __DIR__ . '/../modal/forgot_password.php'; ?>

                <!-- Modal Reset Password -->
                <?php include __DIR__ . '/../modal/reset_password.php'; ?>

            </div>
        </div>

        <!-- jQuery -->
        <script src="<?= BASE_URL ?>public/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Bundle -->
        <script src="<?= BASE_URL ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Malihu Scrollbar -->
        <script src="<?= BASE_URL ?>public/vendor/malihu/jquery.mCustomScrollbar.concat.min.js"></script>

        <!-- Sidebar Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/ui/global/sidebar.js"></script>

        <!-- Kelola URL -->
        <script src="<?= BASE_URL ?>public/assets/js/utils/url_handler.js"></script>

        <!-- Highcharts -->
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/highcharts.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/data.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/exporting.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/export-data.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/accessibility.js"></script>

        <!-- VanillaTop -->
        <script src="<?= BASE_URL ?>public/vendor/vanillatop/dist/vanillatop.min.js"></script>

        <!-- Register Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/auth/registration_handler.js"></script>

        <!-- Login Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/auth/login_handler.js"></script>

        <!-- Forgot Password Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/auth/forgot_password_handler.js"></script>

        <!-- Reset Password Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/auth/reset_password_handler.js"></script>

        <!-- Toggle Password -->
        <script src="<?= BASE_URL ?>public/assets/js/auth/toggle_password.js"></script>

        <!-- Reload Captcha -->
        <script src="<?= BASE_URL ?>public/assets/js/auth/reload_captcha.js"></script>

        <!-- Reset Modal -->
        <script src="<?= BASE_URL ?>public/assets/js/auth/reset_modal.js"></script>

        <!-- Definisi BASE-URL untuk AJAX -->
        <script>
            var BASE_URL = '<?= BASE_URL ?>';
        </script>

        <!-- Auth Handler -->
        <script src="<?= BASE_URL ?>public/assets/ajax/auth_handler.js"></script>

        <!-- Notifikasi Login & Register -->
        <?php include __DIR__ . '/../features/notification/access.php'; ?>

        <!-- SweetAlert2 -->
        <script src="<?= BASE_URL ?>public/vendor/sweetalert2/sweetalert2.all.min.js"></script>
        <?php
            if (isset($_SESSION['swal'])) {
                $swal = $_SESSION['swal'];
                unset($_SESSION['swal']);
            } else {
                $swal = null;
            }
        ?>
        <div id="swal-data" 
            data-icon="<?= $swal['icon'] ?? '' ?>" 
            data-title="<?= $swal['title'] ?? '' ?>" 
            data-html="<?= $swal['html'] ?? '' ?>" 
            data-timer="<?= $swal['timer'] ?? '' ?>"
            data-redirect="<?= $swal['redirect'] ?? '' ?>">
        </div>
        <script src="<?= BASE_URL ?>public/assets/js/utils/swal_handler.js"></script>

        <!-- Calendar -->
        <script src="<?= BASE_URL ?>public/assets/js/ui/home/calendar.js"></script>

        <!-- Resize Header Article -->
        <script src="<?= BASE_URL ?>public/assets/js/ui/home/resize_header_article.js"></script>

        <!-- Script Khusus Berdasarkan Halaman -->
        <?php if ($page == 'guest/statistics/gender'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_gender.js"></script>
        <?php elseif ($page == 'guest/statistics/2013'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2013.js"></script>
        <?php elseif ($page == 'guest/statistics/2014'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2014.js"></script>
        <?php elseif ($page == 'guest/statistics/2015'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2015.js"></script>
        <?php elseif ($page == 'guest/statistics/2016'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2016.js"></script>
        <?php elseif ($page == 'guest/statistics/2017'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2017.js"></script>
        <?php elseif ($page == 'guest/statistics/2018'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2018.js"></script>
        <?php elseif ($page == 'guest/statistics/2019'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2019.js"></script>
        <?php elseif ($page == 'guest/statistics/2020'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2020.js"></script>
        <?php elseif ($page == 'guest/statistics/2021'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2021.js"></script>
        <?php elseif ($page == 'guest/statistics/2022'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/ui/highcharts/statistic_2022.js"></script>
        <?php elseif ($page == 'management/users'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/user_management_handler.js"></script>
            <script src="<?= BASE_URL ?>public/assets/js/utils/table_scrollbar.js"></script>
        <?php elseif ($page == 'management/logs'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/user_log_handler.js"></script>
            <script src="<?= BASE_URL ?>public/assets/js/utils/table_scrollbar.js"></script>
        <?php elseif ($page == 'management/patients'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/patient_management_handler.js"></script>
            <script src="<?= BASE_URL ?>public/assets/js/utils/table_scrollbar.js"></script>
        <?php elseif ($page == 'management/queues'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/queue_management_handler.js"></script>
            <script src="<?= BASE_URL ?>public/assets/js/utils/table_scrollbar.js"></script>
        <?php elseif ($page == 'general/queue/registration'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/queue_registration_handler.js"></script>
        <?php elseif ($page == 'general/queue/status'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/queue_status_handler.js"></script>
            <script src="<?= BASE_URL ?>public/assets/js/utils/table_scrollbar.js"></script>
        <?php endif; ?>

    </body>
</html>