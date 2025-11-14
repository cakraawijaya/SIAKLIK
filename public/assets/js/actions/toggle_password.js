// === Fungsi Toggle Password ===
function togglePassword(inputId, el) {
    const input = document.getElementById(inputId);
    const icon = el.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// === Fungsi Reset Semua Password di Modal ===
function resetPasswordFields(modal) {
    if (!modal) return;

    // Cari semua input yang termasuk dalam .input-group dengan ikon mata
    modal.querySelectorAll('.input-group').forEach(group => {
        const eyeIcon = group.querySelector('i.fa-eye, i.fa-eye-slash');
        const input = group.querySelector('input');

        if (eyeIcon && input) {
            // kalau input sedang dalam mode text (password terbuka)
            if (input.type === "text") {
                input.type = "password";
            }

            // pastikan ikon selalu kembali ke fa-eye
            if (eyeIcon.classList.contains('fa-eye-slash')) {
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('.modal');

    modals.forEach(modal => {
        // Reset saat tombol batal diklik
        modal.querySelectorAll('button, a').forEach(btn => {
            btn.addEventListener('click', function() {
                const text = this.textContent.trim().toLowerCase();
                if (text.includes('batal') || text.includes('cancel')) {
                    resetPasswordFields(modal);
                }
            });
        });

        // Reset saat tombol X diklik
        const closeBtn = modal.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                resetPasswordFields(modal);
            });
        }

        // Reset saat modal benar-benar tertutup (Bootstrap event)
        $(modal).on('hidden.bs.modal', function() {
            resetPasswordFields(modal);
        });
    });

    // Tangkap tombol ESC global — untuk jaga-jaga kalau Bootstrap gagal trigger
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.modal.show');
            if (activeModal) {
                resetPasswordFields(activeModal);
                // Tutup modal secara manual agar hidden.bs.modal ikut jalan
                $(activeModal).modal('hide');
            }
        }
    });
});