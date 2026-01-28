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

    // Kata kunci pencarian user
    $search = $_GET['search'] ?? '';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- USER MANAGEMENT SECTION                                                                     -->
    <!-- =========================================================================================== -->
    <section class="user-management-section">

        <!-- Header manajemen pengguna -->
        <div class="custom-header text-center user-management-text select-none">
            <h2><i class="fas fa-user-cog mr-2" aria-hidden="true"></i>Manajemen Pengguna</h2>
            <p>Memudahkan Admin dalam mengelola seluruh data pengguna poliklinik</p>
        </div>

        <hr> <!-- Garis pemisah di bawah header -->

        <!-- Tab -->
        <div class="tab-wrapper">

            <!-- Navigasi tab user -->
            <ul class="nav nav-tabs">
                <?php foreach ($tab_labels as $label => $text): ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark select-none <?= $active_tab === $label ? 'active' : '' ?>"
                        onclick="openLink('#<?= $label ?>', false)" data-tab="<?= $label ?>" style="cursor:pointer;">
                            <?= $text ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Aksi -->
        <div class="action-bar-wrapper">

            <!-- Bagian Kiri -->
            <div class="add-export">

                <!-- Tombol Tambah Data -->
                <button type="button" class="btn add-btn btn-success text-white">
                    <i class="fa fa-plus mr-1" aria-hidden="true"></i>
                    <span id="btnAddText">Data <?= ucfirst(strtolower($tab_labels[$active_tab])) ?></span>
                </button>

                <!-- Tombol Ekspor Data -->
                <a id="btnExport" class="btn btn-info text-white">
                    <i class="fa fa-download mr-1" aria-hidden="true"></i>
                    <span id="btnExportText">Export <?= ucfirst(strtolower($tab_labels[$active_tab])) ?></span>
                </a>
            </div>

            <!-- Bagian Kanan: Pencarian Data -->
            <!-- Kata kunci pencarian tidak terbatas (bebas) -->
            <form class="form-inline" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" placeholder="Cari Data Pengguna" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>

        <!-- Menampilkan data user (sesuai tab yang sedang dipilih) -->
        <div class="tab-content" id="userManagementTabContent">
            <?php foreach ($tab_labels as $label => $text): ?>
                <div class="tab-pane select-none fade <?= $active_tab === $label ? 'show active' : '' ?>" id="<?= $label ?>">


                    <!-- ============================== TABEL DAFTAR USER ============================== -->
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">FOTO</th>
                                        <th class="text-center align-middle">EMAIL</th>
                                        <th class="text-center align-middle">USERNAME</th>
                                        <th class="text-center align-middle">NAMA</th>
                                        <th class="text-center align-middle">AKSI</th>
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

                        <!-- Informasi jumlah user -->
                        <div class="count-data">
                            <span id="<?= $label ?>-info">Jumlah data pengguna</span>
                            <strong id="<?= $label ?>-category" class="text-muted"><?= strtoupper($text) ?></strong>
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


<!-- Modal Manajemen Pengguna -->
<?php include __DIR__ . '/../../modal/user_management.php'; ?>


<!-- Definisi Awal untuk User Management Handler -->
<script>
    var activeTab = '<?= $active_tab ?>';                         // Tab yang sedang aktif
    var currentPage = { 'pasien': 1, 'pekerja': 1, 'admin': 1 };  // Halaman aktif tiap tab
    var totalPage = { 'pasien': 1, 'pekerja': 1, 'admin': 1 };    // Total halaman tiap tab

    // Menyimpan email user terakhir yang diedit
    var lastEditedUser = { 'email': null };

    // Menyimpan email admin yang sedang login
    const CURRENT_USER_EMAIL = "<?= $_SESSION['email'] ?>";
</script>


<style>
    /* Card utama */
    .swal2-card {
        padding: 1rem 2rem 3rem 2rem !important;
        width: 480px !important;
        min-height: 240px !important;
        border-radius: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    /* Title */
    .swal2-title {
        font-size: 1.8rem !important;
        font-weight: 700;
        color: #343a40;
    }

    /* Subtitle / infoText */
    .swal2-html-container {
        margin-top: 0.5rem;
        font-size: 1.1rem;
        color: #6c757d;
        line-height: 1.7;
    }

    /* Container tombol */
    .swal2-actions {
        display: flex !important;
        justify-content: flex-start !important; /* Cancel di kiri */
        gap: 1rem; /* jarak tombol */
        margin-top: 1.5rem;
    }

    /* Tombol confirm dan cancel */
    .swal2-confirm-button,
    .swal2-cancel-button {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        color: #fff !important;
        border: none !important; /* hilangkan border default */
        border-radius: 0.5rem;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15); /* shadow smooth */
        transition: all 0.2s ease-in-out;
        outline: none !important; /* hilangkan outline saat focus */
    }

    /* Hilangkan efek default focus/active */
    .swal2-confirm-button:focus,
    .swal2-confirm-button:active,
    .swal2-cancel-button:focus,
    .swal2-cancel-button:active {
        outline: none !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    /* Hover tombol - warna lebih gelap */
    .swal2-success-confirm:hover { background-color: #218838 !important; }
    .swal2-danger-confirm:hover  { background-color: #c82333 !important; }
    .swal2-cancel-button:hover    { background-color: #5a6268 !important; }

    /* Shadow saat hover */
    .swal2-confirm-button:hover,
    .swal2-cancel-button:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }

    /* Confirm warna dinamis */
    .swal2-success-confirm { background-color: #28a745 !important; }
    .swal2-danger-confirm  { background-color: #dc3545 !important; }

    /* Cancel */
    .swal2-cancel-button { background-color: #6c757d !important; }
</style>