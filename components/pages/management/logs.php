<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    $require_login = true; // harus login
    require_once __DIR__ . '/../../features/auth/authorization/admin.php';


    // ===========================================================================================
    // TAB DAN SEARCH
    // ===========================================================================================

    // Daftar tab user yang tersedia
    $tab_labels = ['pasien' => 'PASIEN', 'pekerja' => 'PEKERJA', 'admin' => 'ADMIN'];

    // Menentukan tab yang sedang aktif
    $active_tab = $_GET['tab'] ?? 'pasien';

    // Kata kunci pencarian log user
    $search = $_GET['search'] ?? '';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- USER LOG SECTION                                                                            -->
    <!-- =========================================================================================== -->
    <section class="user-log-section w-100">

        <!-- Header catatan aktivitas pengguna -->
        <div class="custom-header text-center user-log-text select-none">
            <h2>
                <i class="fas fa-folder-open mr-1" aria-hidden="true"></i>
                Catatan Aktivitas
            </h2>
            <p>Memudahkan Poliklinik dalam memantau aktivitas setiap pengguna</p>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Tab dan Pencarian -->
        <div class="tab-search-wrapper">

            <!-- Navigasi tab user -->
            <ul class="nav nav-tabs">
                <?php foreach($tab_labels as $label => $text): ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark select-none <?= $active_tab === $label ? 'active' : '' ?>" 
                        onclick="openLink('#<?= $label ?>', false)" data-tab="<?= $label ?>">
                            <?= $text ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Form pencarian untuk mencari data aktivitas pengguna -->
            <!-- Kata kunci pencarian tidak terbatas (bebas) -->
            <form class="form-inline" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" placeholder="Cari Data Aktivitas Pengguna" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>

        <!-- Menampilkan data catatan aktivitas (sesuai tab yang sedang dipilih) -->
        <div class="tab-content" id="userLogTabContent">
            <?php foreach ($tab_labels as $label => $text): ?>
                <div class="tab-pane select-none fade <?= $active_tab === $label ? 'show active' : '' ?>" id="<?= $label ?>">


                    <!-- ======================== TABEL DAFTAR CATATAN AKTIVITAS ======================= -->
                    <div class="table-wrapper">        
                        <div class="table-responsive">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">WAKTU</th>
                                        <th class="text-center align-middle">USERNAME</th>
                                        <th class="text-center align-middle">ROLE</th>
                                        <th class="text-center align-middle">AKTIVITAS</th>
                                        <th class="text-center align-middle">DETAIL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> <!-- Informasi sementara saat data belum dimuat -->
                                        <td colspan="5" class="text-center align-middle" data-header="Pemberitahuan Sistem">
                                            <div class="td-value">Memuat data...</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- ================================== PAGINATION ============================== -->
                    <div class="pagination-wrapper">

                        <!-- Tombol navigasi halaman -->
                        <div class="pagination">
                            <a class="btn btn-success text-white mr-3" id="<?= $label ?>-prev"><i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>Kembali</a>
                            <a class="btn btn-success text-white" id="<?= $label ?>-next">Lanjut<i class="fas fa-arrow-right ml-1" aria-hidden="true"></i></a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>


<!-- Definisi Awal untuk User Log Handler -->
<script>
    var activeTab = '<?= $active_tab ?>';                         // Tab yang sedang aktif
    var currentPage = { 'pasien': 1, 'pekerja': 1, 'admin': 1 };  // Halaman aktif tiap tab
    var totalPage = { 'pasien': 1, 'pekerja': 1, 'admin': 1 };    // Total halaman tiap tab
</script>