<?php

    // ===========================================================================================
    // AUTENTIKASI, KEAMANAN, DAN KONTROL AKSES PENGGUNA
    // ===========================================================================================
    $require_login = true; // harus login
    require_once __DIR__ . '/../../features/auth/authorization/worker.php';


    // ===========================================================================================
    // SEARCH
    // ===========================================================================================

    // Menentukan tab yang sedang aktif (halaman ini hanya 1 tab)
    $active_tab = $_GET['tab'] ?? 'all';

    // Kata kunci pencarian riwayat pasien
    $search = $_GET['search'] ?? '';

?>


<main>

    <!-- =========================================================================================== -->
    <!-- PATIENT MANAGEMENT SECTION                                                                  -->
    <!-- =========================================================================================== -->
    <section class="patient-management-section">

        <!-- Header riwayat pasien -->
        <div class="custom-header text-center queue-management-text select-none">
            <h2><i class="fa fa-book mr-1" aria-hidden="true"></i>Manajemen Pasien</h2>
            <p>Memudahkan Poliklinik dalam mengatur data pasien</p>
        </div><hr>

        <!-- Aksi -->
        <div class="action-bar-wrapper">

            <!-- Bagian Kiri -->
            <div class="add-export">

                <!-- Tombol Tambah Data -->
                <button type="button" class="btn add-btn btn-success text-white" data-toggle="modal" data-target="#modalAddPasien">
                    <i class="fa fa-plus mr-1" aria-hidden="true"></i> Pasien
                </button>

                <!-- Tombol Ekspor Data -->
                <a onclick="openLink('<?= BASE_URL ?>components/features/export/history_data/patient_history.php', false)" class="btn btn-info text-white">
                    <i class="fa fa-download mr-1" aria-hidden="true"></i> Export
                </a>
            </div>

            <!-- Bagian Kanan: Pencarian Data -->
            <!-- Kata kunci pencarian bisa bergantung pada nama, alamat, NIP, maupun NIM (pilih salah satu diantaranya) -->
            <form class="form-inline" id="searchForm">
                <input type="text" name="search" class="form-control select-none mr-2" placeholder="Cari Nama / Alamat / NIP / NIM" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-info text-white" type="submit">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>


        <!-- ========================= TABEL DAFTAR RIWAYAT PASIEN ========================= -->
        <div class="table-wrapper">
            <div class="table-responsive select-none">
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
                        <tr> <!-- Informasi sementara saat data belum dimuat -->
                            <td colspan="13" class="text-center align-middle" data-header="Pemberitahuan Sistem">
                                <div class="td-value">Memuat data...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- ============================== INFO & PAGINATION ============================== -->
        <div class="info-pagination-wrapper">

            <!-- Informasi jumlah riwayat pasien -->
            <div class="count-data">
                <span id="patient-info">Jumlah data pasien</span>
                :&nbsp;<b id="patient-count">0</b>
            </div>

            <!-- Tombol navigasi halaman -->
            <div class="pagination">
                <a class="btn btn-success text-white mr-3" id="patient-prev"><i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>Kembali</a>
                <a class="btn btn-success text-white" id="patient-next">Lanjut<i class="fas fa-arrow-right ml-1" aria-hidden="true"></i></a>
            </div>

        </div>
    </section>
</main>


<!-- Modal Riwayat Pasien -->
<?php include __DIR__ . '/../../modal/patient.php'; ?>


<!-- Definisi Awal untuk Patient Management Handler -->
<script>
    var activeTab = '<?= $active_tab ?>';                   // Tab yang sedang aktif
    var currentPage = { '<?= $active_tab ?>': 1 };          // Halaman aktif
    var totalPage = { '<?= $active_tab ?>': 1 };            // Total halaman
    var lastUpdatedPatient = { id: null, waktu: null };     // Data pasien terakhir yang diperbarui
</script>