// ===========================================================================================
// FUNGSI TOGGLE PASSWORD
// ===========================================================================================
// Fungsi untuk menampilkan atau menyembunyikan password
function togglePassword(inputId, el) {

    // Ambil elemen input berdasarkan ID
    const input = document.getElementById(inputId);

    // Ambil ikon <i> (Font Awesome) di dalam elemen yang diklik
    const icon = el.querySelector('i');

    // Jika input masih bertipe password (tertutup), maka :
    if (input.type === "password") {

        // Ubah tipe input menjadi text (password terlihat)
        input.type = "text";

        // Ganti ikon mata terbuka menjadi mata tertutup
        icon.classList.replace('fa-eye', 'fa-eye-slash');

    } else { // Jika input bertipe text (password terlihat), maka :

        // Ubah tipe input menjadi password (tertutup)
        input.type = "password";

        // Ganti ikon mata tertutup menjadi mata terbuka
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}


// ===========================================================================================
// FUNGSI RESET PASSWORD
// ===========================================================================================
// Fungsi untuk reset semua password yang ada di modal
function resetPasswordFields(modal) {

    if (!modal) return; // Jika modal tidak ada, hentikan fungsi

    // Cari semua elemen dengan class .input-group di dalam modal
    modal.querySelectorAll('.input-group').forEach(group => {

        // Cari ikon mata (fa-eye atau fa-eye-slash)
        const eyeIcon = group.querySelector('i.fa-eye, i.fa-eye-slash');

        // Cari input di dalam input-group
        const input = group.querySelector('input');

        // Jika ikon mata dan input ditemukan, maka :
        if (eyeIcon && input) {

            // Cek input apakah sedang dalam mode text (password terlihat), jika iya maka :
            if (input.type === "text") {

                // Ubah tipe input menjadi password (tertutup)
                input.type = "password";
            }

            // Pastikan ikon selalu kembali ke fa-eye (mata terbuka)
            if (eyeIcon.classList.contains('fa-eye-slash')) {

                // Ganti ikon mata tertutup menjadi mata terbuka
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    });
}


// ===========================================================================================
// EVENT SAAT HALAMAN SELESAI DIMUAT
// ===========================================================================================
document.addEventListener('DOMContentLoaded', function() {

    // Ambil semua elemen modal
    const modals = document.querySelectorAll('.modal');

    // Loop setiap modal
    modals.forEach(modal => {

        /* =================== RESET PASSWORD SAAT TOMBOL BATAL DIKLIK =================== */
        modal.querySelectorAll('button, a').forEach(btn => {

            // Pasang event saat tombol diklik
            btn.addEventListener('click', function() {

                // Ambil teks dari tombol, hilangkan spasi, dan ubah ke huruf kecil
                const text = this.textContent.trim().toLowerCase();

                // Jika teks tombol mengandung kata "batal" atau "cancel", maka :
                if (text.includes('batal') || text.includes('cancel')) {

                    // Reset semua input password
                    resetPasswordFields(modal);
                }
            });
        });


        /* ================= RESET PASSWORD SAAT TOMBOL SILANG (X) DIKLIK ================ */
        // Cari tombol close (ikon X) di dalam modal
        const closeBtn = modal.querySelector('.close');

        if (closeBtn) { // Jika tombol close ditemukan, maka :

            // Pasang event saat tombol close diklik
            closeBtn.addEventListener('click', function() {

                // Reset semua input password
                resetPasswordFields(modal);
            });
        }


        /* ============ RESET PASSWORD SAAT MODAL TERTUTUP (EVENT BOOTSTRAP) ============= */
        // Reset saat modal benar-benar tertutup
        $(modal).on('hidden.bs.modal', function() {

            // Reset semua input password
            resetPasswordFields(modal);
        });
    });


    /* ======================== TANGKAP TOMBOL ESC SECARA GLOBAL ===================== */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { // Jika tombol ESC ditekan, maka :

            // Cari modal yang sedang aktif (terbuka)
            const activeModal = document.querySelector('.modal.show');

            // Kalau memang ada modal yang sedang terbuka, maka :
            if (activeModal) {

                // Reset semua input password
                resetPasswordFields(activeModal);
                
                // Tutup modal secara paksa supaya sistem tahu modal sudah ditutup
                $(activeModal).modal('hide');
            }
        }
    });
});