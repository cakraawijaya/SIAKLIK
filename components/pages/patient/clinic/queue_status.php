<?php
    // ======================== AUTH & CONFIG ========================
    $require_login = true;
    include __DIR__ . '/../../../features/auth/authorization/patient.php';
    include __DIR__ . '/../../../../config/config.php';

    // ======================== TAB DAN SEARCH ========================
    $tab_labels = ['internal'=>'INTERNAL','bpjs'=>'BPJS','umum'=>'UMUM','selesai'=>'SELESAI'];
    $active_tab = $_GET['tab'] ?? 'internal';
    $search = $_GET['search'] ?? '';
?>

<main>
    <section class="queue-list px-4 w-100">
        <div class="custom-header about-header text-center queue-list-text select-none">
            <h2><i class="fas fa-tasks mr-2" aria-hidden="true"></i>Status Antrean Poliklinik</h2>
            <p>Informasi antrean terkini di setiap layanan poliklinik</p>
        </div><hr>

        <!-- Tabs dan Search -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
            <ul class="nav nav-tabs mt-4" style="border-bottom:0;">
                <?php foreach($tab_labels as $label=>$text): ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark select-none <?= $active_tab===$label?'active':'' ?>" href="#<?= $label ?>" data-tab="<?= $label ?>">
                            <?= $text ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <form class="form-inline mt-4" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" placeholder="Cari Kode Antrean" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="antreanTabContent">
            <?php foreach($tab_labels as $label=>$text): ?>
                <div class="tab-pane select-none fade <?= $active_tab===$label?'show active':'' ?>" id="<?= $label ?>">
                    <div class="table-responsive mb-3">
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
                                <tr><td colspan="5" class="text-center align-middle">Memuat data...</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Info & Pagination -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span id="<?= $label ?>-info">Jumlah data antrean pasien</span>&nbsp;
                            <strong id="<?= $label ?>-category" class="text-muted">(<?= strtoupper($text) ?>)</strong>
                            &nbsp;:&nbsp;<b id="<?= $label ?>-count">0</b>
                        </div>
                        <div class="d-flex align-items-center">
                            <a class="btn btn-success text-white mr-3" id="<?= $label ?>-prev"><i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>Back</a>
                            <a class="btn btn-success text-white" id="<?= $label ?>-next">Next<i class="fas fa-arrow-right ml-1" aria-hidden="true"></i></a>
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
    var currentPage = { 'internal':1, 'bpjs':1, 'umum':1, 'selesai':1 };
    var totalPage = { 'internal':1, 'bpjs':1, 'umum':1, 'selesai':1 };
</script>