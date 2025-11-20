<?php
    $require_login = true;
    include __DIR__ . '/../../features/auth/authorization/worker.php';
    include __DIR__ . '/../../../config/config.php';

    // ======================== SEARCH ========================
    $search = $_GET['search'] ?? '';
?>

<main>
    <section class="patient-management-section">
        <div class="custom-header text-center queue-management-text select-none">
            <h2><i class="fa fa-book mr-1" aria-hidden="true"></i>Manajemen Pasien</h2>
            <p>Memudahkan Poliklinik dalam mengatur data pasien</p>
        </div><hr>

        <!-- Buttons & Search -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3 pb-2 flex-wrap">
            <!-- Button Group -->
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <button type="button" class="btn btn-success text-white mr-3" data-toggle="modal" data-target="#modalAddPasien">
                    <i class="fa fa-plus mr-1" aria-hidden="true"></i> Pasien
                </button>
                <a href="<?= BASE_URL ?>components/features/export/history_data/patient_history.php" class="btn btn-info text-white">
                    <i class="fa fa-download mr-1" aria-hidden="true"></i> Export
                </a>
            </div>

            <!-- Search Form -->
            <form class="form-inline" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" style="width: 280px;" placeholder="Cari Nama / Alamat / NIP / NIM" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive select-none mb-3">
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th class="text-center align-middle">ID</th>
                        <th class="text-center align-middle">NAMA</th>
                        <th class="text-center align-middle">UMUR</th>
                        <th class="text-center align-middle">ALAMAT</th>
                        <th class="text-center align-middle">PEKERJAAN</th>
                        <th class="text-center align-middle">STATUS</th>
                        <th class="text-center align-middle">JK</th>
                        <th class="text-center align-middle">NIM/NIP</th>
                        <th class="text-center align-middle">NO BPJS</th>
                        <th class="text-center align-middle">LAYANAN</th>
                        <th class="text-center align-middle">KATEGORI</th>
                        <th class="text-center align-middle">KET</th>
                        <th class="text-center align-middle">WAKTU PENCATATAN</th>
                        <th class="text-center align-middle">AKSI</th>
                    </tr>
                </thead>
                <tbody id="patientTableBody">
                    <tr><td colspan="13" class="text-center align-middle">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Info -->
        <div class="d-flex justify-content-between align-items-center select-none mt-3 py-3">
            <div class="d-flex align-items-center">
                <span id="patient-info">Jumlah data pasien</span>
                &nbsp;:&nbsp;<b id="patient-count">0</b>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn btn-success text-white mr-3" id="patient-prev">
                    <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>Back
                </a>
                <a class="btn btn-success text-white" id="patient-next">
                    Next<i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../../modal/patient.php'; ?>

<script>
    var activeTab = 'all';
    var currentPage = { 'all': 1 };
    var totalPage = { 'all': 1 };
    var lastUpdatedPatient = { id: null, waktu: null };
</script>