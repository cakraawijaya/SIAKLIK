<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    $require_login = true; // harus login
    require_once __DIR__ . '/../../../features/auth/authorization/patient.php';


    // ===========================================================================================
    // TAB DAN SEARCH
    // ===========================================================================================

    // Daftar tab antrean yang tersedia
    $tab_labels = ['internal' => 'INTERNAL', 'bpjs' => 'BPJS', 'umum' => 'UMUM', 'selesai' => 'SELESAI'];

    // Menentukan tab yang sedang aktif
    $active_tab = $_GET['tab'] ?? 'internal';

    // Kata kunci pencarian antrean
    $search = $_GET['search'] ?? '';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- QUEUE LIST SECTION                                                                          -->
    <!-- =========================================================================================== -->
    <section class="queue-list-section">

        <!-- Header status antrean -->
        <div class="custom-header text-center queue-list-text select-none">
            <h2><i class="fas fa-tasks mr-2" aria-hidden="true"></i>Status Antrean</h2>
            <p>Informasi antrean terkini di setiap layanan poliklinik</p>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Tabs dan Search -->
        <div class="tab-search-wrapper">

            <!-- Navigasi tab antrean -->
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

            <!-- Form pencarian berdasarkan kode antrean -->
            <form class="form-inline" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" placeholder="Cari Kode Antrean" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>

        <!-- Tampilkan data antrean berdasarkan tab yang dipilih -->
        <div class="tab-content" id="antreanTabContent">
            <?php foreach($tab_labels as $label => $text): ?>
                <div class="tab-pane select-none fade <?= $active_tab === $label ? 'show active' : '' ?>" id="<?= $label ?>">


                    <!-- ============================= TABEL DAFTAR ANTREAN ============================ -->
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">KODE ANTREAN</th>
                                        <th class="text-center align-middle">NAMA</th>
                                        <th class="text-center align-middle">LAYANAN</th>
                                        <th class="text-center align-middle">JENIS ANTREAN</th>
                                        <th class="text-center align-middle">STATUS</th>
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


                    <!-- ============================== INFO & PAGINATION ============================== -->
                    <div class="info-pagination-wrapper">

                        <!-- Informasi jumlah antrean -->
                        <div class="count-data">
                            <span id="<?= $label ?>-info">Jumlah data antrean pasien</span>
                            <strong id="<?= $label ?>-category" class="text-muted">(<?= strtoupper($text) ?>)</strong>
                            :&nbsp;<b id="<?= $label ?>-count">0</b>
                        </div>

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

<!-- Definisi Awal Queue Handler -->
<script>
    var activeTab = '<?= $active_tab ?>'; // Tab yang sedang aktif
    var currentPage = { 'internal': 1, 'bpjs': 1, 'umum': 1, 'selesai': 1 }; // Halaman aktif tiap tab
    var totalPage = { 'internal': 1, 'bpjs': 1, 'umum': 1, 'selesai': 1 };   // Total halaman tiap tab
</script>