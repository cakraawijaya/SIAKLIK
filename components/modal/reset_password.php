<?php require_once __DIR__ . '/../features/auth/security/token_check.php'; ?>

<!-- Hanya bisa diakses kalau belum login -->
<?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>

  <!-- Tampilkan Modal -->
  <?php if($showModal): ?>

    <!-- Modal Reset Password -->
    <div class="modal fade" id="modalResetPassword" tabindex="-1" role="dialog" aria-labelledby="modalResetPasswordLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg">
          <!-- Header -->
          <div class="modal-header bg-success text-white text-center">
            <h5 class="modal-title w-100 select-none" id="modalResetPasswordLabel">
              <i class="fas fa-key mr-2" aria-hidden="true"></i>Reset Password
            </h5>
            <button type="button" class="close select-none" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!-- Body -->
          <div class="modal-body pt-4 px-4">
            <form method="POST" action="<?= BASE_URL ?>components/features/auth/recovery/reset_password.php">
              <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
              <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

              <div class="form-group position-relative">
                <label class="select-none"><strong>Password</strong></label>
                <div class="input-group">
                  <input type="password" class="form-control select-none" placeholder="Masukkan password baru" name="reset-password" id="reset-password" autocomplete="reset-password" required>
                  <div class="input-group-append">
                    <div class="input-group-text" style="right:15px; top:38px; cursor:pointer;" onclick="togglePassword('reset-password', this)">
                      <i class="fas fa-eye" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group position-relative mt-4">
                <label class="select-none"><strong>Konfirmasi Password</strong></label>
                <div class="input-group">
                  <input type="password" class="form-control select-none" placeholder="Ulangi password" name="reset-confirm-password" id="reset-confirm-password" autocomplete="reset-confirm-password" required>
                  <div class="input-group-append">
                    <div class="input-group-text" style="right:15px; top:38px; cursor:pointer;" onclick="togglePassword('reset-confirm-password', this)">
                      <i class="fas fa-eye" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-success mt-3 mb-0 w-100">
                <strong>Reset Password<i class="fas fa-paper-plane ml-2" aria-hidden="true"></i></strong>
              </button>
            </form>
          </div>

          <!-- Footer -->
          <div class="modal-footer text-center flex-column">
            <p class="mb-0 select-none">Sudah ingat password? 
              <a href="<?= BASE_URL ?>components/features/auth/recovery/delete_reset_token.php?email=<?= urlencode($_GET['email'] ?? '') ?>">
                <span>Login sekarang</span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>

  <?php endif; ?>
<?php endif; ?>