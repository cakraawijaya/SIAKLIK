<!-- Hanya bisa diakses kalau belum login -->
<?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>

  <!-- Modal Lupa Password Pasien -->
  <div class="modal fade" id="modalForgotPassword" tabindex="-1" role="dialog" aria-labelledby="modalForgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">
        <!-- Header -->
        <div class="modal-header bg-success text-white text-center">
          <h5 class="modal-title w-100 select-none" id="modalForgotPasswordLabel">
            <i class="fas fa-unlock-alt mr-2" aria-hidden="true"></i>Lupa Password Pasien
          </h5>
          <button type="button" class="close select-none" onclick="$('#modalForgotPassword').modal('hide')">&times;</button>
        </div>

        <!-- Body -->
        <div class="modal-body pt-4 px-4">
          <form action="<?= BASE_URL ?>components/features/auth/recovery/forgot_password.php" method="post">
            <div class="form-group">
              <label class="select-none" for="email"><strong>Email</strong></label>
              <input type="email" id="email" class="form-control select-none" name="email" placeholder="Masukkan email Anda" required>
            </div>

            <button type="submit" class="btn btn-success text-white py-2 mt-2 w-100">
              <strong>Kirim Link Reset<i class="fas fa-paper-plane ml-2" aria-hidden="true"></i></strong>
            </button>
          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer text-center flex-column">
          <p class="mb-0 select-none">Ingat password?
            <a onclick="openLink('#', false)" id="switchToPasienFromForgotPassword">
              <span>Kembali ke Login</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>