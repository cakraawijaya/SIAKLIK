<?php
    $require_login = true;
    include __DIR__ . '/../../../features/auth/authorization/patient.php';
    include __DIR__ . '/../../../../config/config.php';
?>

<main>
    <section class="queue-registration-section">
        <div class="custom-header text-center queue-registration-text select-none">
            <h2>
                <i class="fas fa-user-tag mr-2" aria-hidden="true">
                </i>Registrasi Antrean
            </h2>
            <p>Pilihan antrean ada 3 macam, yaitu: Internal, BPJS, dan Umum</p>
        </div><hr>

        <!-- Queue Registration Grid -->
        <div class="queue-registration-grid text-center">

            <!-- Card 1 -->
            <div class="queue-registration-item select-none">
                <a onclick="openLink('#modalAntreInternal', false)" data-target="#modalAntreInternal" data-toggle="modal" data-kategori="INTERNAL">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <i class="fas fa-hospital-user" aria-hidden="true"></i>
                            <span class="font-weight-bold">ANTREAN INTERNAL</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="queue-registration-item select-none">
                <a onclick="openLink('#modalAntreBPJS', false)" data-target="#modalAntreBPJS" data-toggle="modal" data-kategori="BPJS">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <i class="fas fa-id-card" aria-hidden="true"></i>
                            <span class="font-weight-bold">ANTREAN BPJS</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="queue-registration-item select-none">
                <a onclick="openLink('#modalAntreUmum', false)" data-target="#modalAntreUmum" data-toggle="modal" data-kategori="UMUM">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <i class="fas fa-user-friends" aria-hidden="true"></i>
                            <span class="font-weight-bold">ANTREAN UMUM</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>

<!-- Modal Antrean -->
<?php include __DIR__ . '/../../../modal/queue.php'; ?>

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

    /* Subtitle */
    .swal2-html-container {
        margin-top: 0.5rem;
        font-size: 1.1rem;
        color: #6c757d;
        line-height: 1.7;
    }

    /* Tombol confirm */
    .swal2-confirm-button {
        display: inline-block;
        padding: 0.8rem 5rem;
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
    .swal2-confirm-button:active {
        outline: none !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    /* Shadow saat hover */
    .swal2-confirm-button:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }

    /* Confirm warna dinamis */
    .swal2-danger-confirm  { background-color: #dc3545 !important; }

    /* Hover tombol - warna lebih gelap */
    .swal2-danger-confirm:hover  { background-color: #c82333 !important; }
</style>