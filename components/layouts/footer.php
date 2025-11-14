                <!-- Footer -->
                <footer class="footer-section font-small pt-5 text-light">
                    <div class="container text-center text-md-left">
                        <div class="row">
                            <!-- Alamat Klinik -->
                            <div class="col-md-4 mb-4 col-left select-none">
                                <h5 class="footer-title mb-4">
                                    <i class="footer-icons fas fa-map-marker-alt" aria-hidden="true"></i>
                                    Alamat Poliklinik
                                </h5>
                                <p>Jl. Rungkut Madya No.1, Gn. Anyar, Kec. Gn. Anyar, Kota SBY, Jawa Timur</p>
                                <a href="https://www.google.com/maps?ll=-7.333339,112.788588&z=16&t=m&hl=en&gl=ID&mapclient=embed&cid=12854831982186720929" 
                                target="_blank" class="maps-link d-block mt-3">
                                    <i class="fas fa-map-marked-alt mr-1" aria-hidden="true"></i>
                                    Lihat di Google Maps
                                </a>
                            </div>

                            <!-- Kontak -->
                            <div class="col-md-4 mb-4 col-center select-none">
                                <h5 class="footer-title mb-4">
                                    <i class="footer-icons fas fa-address-book mr-1" aria-hidden="true"></i>
                                    Kontak
                                </h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-phone-alt" aria-hidden="true"></i> 031-8706369</li>
                                    <li><i class="fas fa-envelope" aria-hidden="true"></i> poliklinik@upnvjatim.ac.id</li>
                                </ul>
                                <!-- Sosial Media -->
                                <div class="mt-3">
                                    <a href="#" class="social-icon" onclick="event.preventDefault();"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    <a href="#" class="social-icon" onclick="event.preventDefault();"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                    <a href="#" class="social-icon" onclick="event.preventDefault();"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                    <a href="#" class="social-icon" onclick="event.preventDefault();"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                </div>
                            </div>

                            <!-- Jam Operasional -->
                            <div class="col-md-4 mb-4 col-right select-none">
                                <h5 class="footer-title mb-4">
                                    <i class="footer-icons fas fa-clock mr-1" aria-hidden="true"></i>
                                    Jam Operasional
                                </h5>
                                <p><strong>Senin - Jumat:</strong> 07.30 - 15.30</p>
                                <p><strong>Sabtu & Minggu:</strong> Libur</p>
                            </div>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="footer-copyright bg-dark text-light text-center select-none py-3 mt-4">
                        &copy; 2021-<?= date("Y"); ?> <strong>SIAKLIK (Sistem Pelayanan Klinik Kesehatan)</strong>. All Rights Reserved
                    </div>

                </footer>
                <!-- END Footer -->

                <!-- Tombol Scroll Up -->
                <a href="#" class="vanillatop"><i class="fas fa-angle-up" aria-hidden="true"></i></a>

                <!-- Modal Login -->
                <?php include __DIR__ . '/../modal/modal_login.php'; ?>

                <!-- Modal Register -->
                <?php include __DIR__ . '/../modal/modal_registration.php'; ?>

                <!-- Modal Forgot Password -->
                <?php include __DIR__ . '/../modal/modal_forgot_password.php'; ?>

                <!-- Modal Reset Password -->
                <?php include __DIR__ . '/../modal/modal_reset_password.php'; ?>

            </div>
            <!-- End of Page Main Body Page Content  -->
        </div>

        <!-- jQuery -->
        <script src="<?= BASE_URL ?>public/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Bundle -->
        <script src="<?= BASE_URL ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Malihu Scrollbar -->
        <script src="<?= BASE_URL ?>public/vendor/malihu/jquery.mCustomScrollbar.concat.min.js"></script>
        
        <!-- Sidebar Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/others/sidebar.js"></script>
        
        <!-- Highcharts -->
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/highcharts.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/data.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/exporting.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/export-data.js"></script>
        <script src="<?= BASE_URL ?>public/vendor/highcharts/code/modules/accessibility.js"></script>
        
        <!-- VanillaTop -->
        <script src="<?= BASE_URL ?>public/vendor/vanillatop/dist/vanillatop.min.js"></script>
        
        <!-- Register Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/actions/registration_handler.js"></script>
        
        <!-- Login Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/actions/login_handler.js"></script>
        
        <!-- Forgot Password Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/actions/forgot_password_handler.js"></script>
        
        <!-- Reset Password Handler -->
        <script src="<?= BASE_URL ?>public/assets/js/actions/reset_password_handler.js"></script>
        
        <!-- Toggle Password -->
        <script src="<?= BASE_URL ?>public/assets/js/actions/toggle_password.js"></script>
        
        <!-- Reload Captcha -->
        <script src="<?= BASE_URL ?>public/assets/js/actions/reload_captcha.js"></script>

        <!-- Reset Modal -->
        <script src="<?= BASE_URL ?>public/assets/js/actions/reset_modal.js"></script>

        <!-- Definisi BASE-URL untuk AJAX -->
        <script>
            var BASE_URL = '<?= BASE_URL ?>';
        </script>

        <!-- Auth Handler -->
        <script src="<?= BASE_URL ?>public/assets/ajax/auth_handler.js"></script>
        
        <!-- Notifikasi Login & Register -->
        <?php include __DIR__ . '/../features/access_notification.php'; ?>
        
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
        <script src="<?= BASE_URL ?>public/assets/js/actions/swal_handler.js"></script>
        
        <!-- Calendar -->
        <script src="<?= BASE_URL ?>public/assets/js/others/calendar.js"></script>
        
        <!-- Resize Header Article -->
        <script src="<?= BASE_URL ?>public/assets/js/others/resize_header_article.js"></script>

        <!-- Script Khusus Berdasarkan Halaman -->
        <?php if ($page == 'patient/chart/chart_gender'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_gender.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2013'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2013.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2014'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2014.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2015'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2015.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2016'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2016.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2017'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2017.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2018'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2018.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2019'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2019.js"></script>
        <?php elseif ($page == 'patient/chart/chart_2020'): ?>
            <script src="<?= BASE_URL ?>public/assets/js/highcharts/chart_bar_2020.js"></script>
        <?php elseif ($page == 'admin/user_management'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/user_management_handler.js"></script>
        <?php elseif ($page == 'worker/patient_management'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/patient_management_handler.js"></script>
        <?php elseif ($page == 'worker/queue_management'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/queue_management_handler.js"></script>
        <?php elseif ($page == 'patient/clinic/queue_registration'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/queue_registration_handler.js"></script>
        <?php elseif ($page == 'patient/clinic/queue_status'): ?>
            <script src="<?= BASE_URL ?>public/assets/ajax/queue_status_handler.js"></script>
        <?php endif; ?>
        
    </body>
</html>