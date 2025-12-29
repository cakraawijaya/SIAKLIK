<?php
    // ======================== AUTH & CONFIG ========================
    $require_login = true;
    include __DIR__ . '/../../features/auth/authorization/worker.php';
    include __DIR__ . '/../../../config/config.php';

    // ======================== TAB DAN SEARCH ========================
    $tab_labels = ['internal'=>'INTERNAL','bpjs'=>'BPJS','umum'=>'UMUM'];
    $active_tab = $_GET['tab'] ?? 'internal';
    $search = $_GET['search'] ?? '';
?>

<main>
    <section class="queue-management-section">
        <div class="custom-header text-center queue-management-text select-none">
            <h2><i class="fas fa-tasks mr-2" aria-hidden="true"></i>Manajemen Antrean</h2>
            <p>Memudahkan Poliklinik dalam menyelesaikan data antrean pasien</p>
        </div><hr>

        <!-- Tabs dan Search -->
        <div class="tab-search-wrapper">
            <ul class="nav nav-tabs">
                <?php foreach ($tab_labels as $label=>$text): ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark select-none <?= $active_tab===$label?'active':'' ?>" 
                        onclick="openLink('#<?= $label ?>', false)" data-tab="<?= $label ?>">
                            <?= $text ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <form class="form-inline" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" placeholder="Cari Kode Antrean" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>

        <!-- Table Content -->
        <div class="tab-content" id="antreanTabContent">
            <?php foreach ($tab_labels as $label=>$text): ?>
                <div class="tab-pane select-none fade <?= $active_tab===$label?'show active':'' ?>" id="<?= $label ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">KODE ANTREAN</th>
                                    <th class="text-center align-middle">USERNAME</th>
                                    <th class="text-center align-middle">NAMA</th>
                                    <th class="text-center align-middle">LAYANAN</th>
                                    <th class="text-center align-middle">JENIS ANTREAN</th>
                                    <th class="text-center align-middle">STATUS</th>
                                    <th class="text-center align-middle">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center align-middle" data-header="Pemberitahuan Sistem">
                                        <div class="td-value">Memuat data...</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="info-pagination-wrapper">
                        <div class="count-data">
                            <span id="<?= $label ?>-info">Jumlah data antrean aktif pasien</span>
                            <strong id="<?= $label ?>-category" class="text-muted">(<?= strtoupper($text) ?>)</strong>
                            :&nbsp;<b id="<?= $label ?>-count">0</b>
                        </div>
                        <div class="pagination">
                            <a class="btn btn-success text-white mr-3" id="<?= $label ?>-prev"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
                            <a class="btn btn-success text-white" id="<?= $label ?>-next">Lanjut<i class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<!-- Definisi Awal Queue Handler -->
<script>
    var activeTab = '<?= $active_tab ?>';
    var currentPage = { 'internal':1, 'bpjs':1, 'umum':1 };
    var totalPage = { 'internal':1, 'bpjs':1, 'umum':1 };
    var lastUpdatedQueue = { kode: null, status: null, waktu: null };
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