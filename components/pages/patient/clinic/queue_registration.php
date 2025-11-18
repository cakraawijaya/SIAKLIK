<?php
// FILE: queue_registration.php (halaman registrasi antrean)
// Pastikan file ini berada di lokasi yang sama seperti sebelumnya.

$require_login = true;
include __DIR__ . '/../../../features/auth/authorization/patient.php';
include __DIR__ . '/../../../../config/config.php';
?>

<main>
    <section class="queue-registration-section px-4 w-100">
        <div class="custom-header about-header text-center queue-registration-text select-none">
            <h2>
                <i class="fas fa-user-tag mr-2" aria-hidden="true">
                </i>Registrasi Antrean Poliklinik
            </h2>
            <p>Pilihan antrean ada 3 macam, yaitu: Internal, BPJS, dan Umum</p>
        </div><hr>

        <!-- Tombol Modal Pendaftaran -->
        <div class="container-fluid mt-5 mb-3 px-4 pb-2">
            <div class="row text-center justify-content-center" style="gap:30px;">
                <div class="col">
                <a href="#modalAntreInternal" data-toggle="modal" class="d-block mx-1 queue-link select-none" data-kategori="INTERNAL">
                    <div class="card bg-primary text-white queue-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-hospital-user mb-3" aria-hidden="true"></i>
                        <span class="font-weight-bold">ANTREAN INTERNAL</span>
                    </div>
                    </div>
                </a>
                </div>
                <div class="col">
                <a href="#modalAntreBPJS" data-toggle="modal" class="d-block mx-1 queue-link select-none" data-kategori="BPJS">
                    <div class="card bg-success text-white queue-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-id-card mb-3" aria-hidden="true"></i>
                        <span class="font-weight-bold">ANTREAN BPJS</span>
                    </div>
                    </div>
                </a>
                </div>
                <div class="col">
                <a href="#modalAntreUmum" data-toggle="modal" class="d-block mx-1 queue-link select-none" data-kategori="UMUM">
                    <div class="card bg-info text-white queue-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-user-friends mb-3" aria-hidden="true"></i>
                        <span class="font-weight-bold">ANTREAN UMUM</span>
                    </div>
                    </div>
                </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal Antrean -->
<?php include __DIR__ . '/../../../modal/queue.php'; ?>

<style>
.queue-card {
    border-radius: 16px;
    transition: transform 0.35s ease, box-shadow 0.35s ease, background 0.35s ease;
    cursor: pointer;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    position: relative;
}
.queue-card .card-body {
    height: 170px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.queue-card i {
    font-size: 60px;
    margin-bottom: 10px;
    transition: transform 0.3s ease, color 0.3s ease;
}
.queue-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.18);
}
.queue-card:hover i {
    transform: scale(1.1);
}
.queue-card:hover::after {
    width: 100%;
}
.queue-card i {
    text-shadow: none;
}
a.d-block {
    text-decoration: none !important;
}


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


@media (max-width: 768px) {
    .row {
        flex-direction: column;
        gap: 20px !important;
    }
    .queue-card .card-body {
        height: 150px;
    }
    .queue-card i {
        font-size: 50px;
    }
}
</style>