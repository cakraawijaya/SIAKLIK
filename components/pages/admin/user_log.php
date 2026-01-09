<?php
    
    // ======================== AUTH & CONFIG ========================
    $require_login = true; // harus login
    include __DIR__ . '/../../features/auth/authorization/admin.php';

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__ . '/../../../config/config.php';

    
    // ======================== TAB DAN SEARCH ========================
    $tab_labels = ['pasien' => 'PASIEN', 'pekerja' => 'PEKERJA', 'admin' => 'ADMIN'];
    $active_tab = $_GET['tab'] ?? 'pasien';
    $search = $_GET['search'] ?? '';

?>

<main>
    <section class="user-log-section w-100">
        <div class="custom-header text-center user-log-text select-none">
            <h2>
                <i class="fas fa-folder-open mr-1" aria-hidden="true"></i>
                Catatan Aktivitas
            </h2>
            <p>Memudahkan Poliklinik dalam memantau aktivitas setiap pengguna</p>
        </div><hr>

        <!-- Tabs dan Search -->
        <div class="tab-search-wrapper">
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
            <form class="form-inline" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" placeholder="Cari Data Aktivitas Pengguna" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>

        <!-- Table Content -->
        <div class="tab-content" id="userLogTabContent">
            <?php foreach ($tab_labels as $label => $text): ?>
                <div class="tab-pane select-none fade <?= $active_tab === $label ? 'show active' : '' ?>" id="<?= $label ?>">
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
                                <tr>
                                    <td colspan="5" class="text-center align-middle" data-header="Pemberitahuan Sistem">
                                        <div class="td-value">Memuat data...</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="info-pagination-wrapper">
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


<!-- Definisi Awal User Handler -->
<script>
    var activeTab = '<?= $active_tab ?>';
    var currentPage = { pasien: 1, pekerja: 1, admin: 1 };
    var totalPage = { pasien: 1, pekerja: 1, admin: 1 };
</script>