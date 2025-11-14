<!-- Hanya bisa diakses kalau belum login -->
<?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>

  <!-- Modal Login Pasien -->
  <div class="modal fade" id="modalLoginPasien" tabindex="-1" role="dialog" aria-labelledby="modalLoginPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">
        <!-- Header -->
        <div class="modal-header bg-success text-white text-center">
          <h5 class="modal-title w-100 select-none" id="modalLoginPasienLabel">
            <i class="fas fa-user-injured mr-2" aria-hidden="true"></i>Login Pasien Klinik
          </h5>
          <button type="button" class="close select-none" onclick="$('#modalLoginPasien').modal('hide')">&times;</button>
        </div>

        <!-- Body -->
        <div class="modal-body pt-4 px-4">
          <form action="<?= BASE_URL ?>components/features/login_check.php" method="post">
            <div class="form-group">
              <label class="select-none"><strong>Email</strong></label>
              <input type="email" class="form-control select-none" placeholder="Masukkan email anda" name="patient-email" autocomplete="patient-email" required>
            </div>
            <div class="form-group position-relative">
              <label class="select-none"><strong>Password</strong></label>
              <div class="input-group">
                <input type="password" class="form-control select-none" placeholder="Masukkan password anda" name="patient-password" id="patient-password" autocomplete="current-password" required>
                <div class="input-group-append">
                  <div class="input-group-text" style="right:15px; top:38px; cursor:pointer;" onclick="togglePassword('patient-password', this)">
                      <i class="fas fa-eye" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- Captcha -->
            <div class="form-group">
              <label class="select-none"><strong>Verifikasi Captcha</strong></label>
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="d-flex">
                    <img id="captchaPasien" class="select-none"
                      data-base="<?= BASE_URL ?>components/features/captcha_generate.php?id=login_pasien"
                      src="<?= BASE_URL ?>components/features/captcha_generate.php?id=login_pasien&<?= time() ?>"
                      alt="Captcha"
                    >
                    <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaPasien')">
                      <i class="fas fa-sync" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
                <div class="col">
                  <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                  oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-2 w-100" name="patient-submit">
              <strong>Masuk<i class="fas fa-sign-in-alt ml-1" aria-hidden="true"></i></strong>
            </button>
          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer text-center flex-column">
          <p class="mb-1 select-none">Login sebagai Pekerja atau Admin? 
            <a href="#" id="switchToPekerjaFromPasien">
              <span>Klik di sini</span>
            </a>
          </p>
          <p class="mb-1 select-none">Belum punya akun? 
            <a href="#" id="switchToRegistration">
              <span>Daftar</span>
            </a>
          </p>
          <p class="mb-0 select-none">Lupa Password? 
            <a href="#" id="switchToForgotPassword">
              <span>Klik di sini</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Login Pekerja/Admin -->
  <div class="modal fade" id="modalLoginPekerjaAdmin" tabindex="-1" role="dialog" aria-labelledby="modalLoginPekerjaAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">
        <!-- Header -->
        <div class="modal-header bg-success text-white text-center">
          <h5 class="modal-title w-100 select-none" id="modalLoginPekerjaAdminLabel">
            <i class="fas fa-stethoscope mr-2" aria-hidden="true"></i>Login Pekerja / Admin Klinik
          </h5>
          <button type="button" class="close select-none" onclick="$('#modalLoginPekerjaAdmin').modal('hide')">&times;</button>
        </div>

        <!-- Body -->
        <div class="modal-body pt-4 px-4">
          <form action="<?= BASE_URL ?>components/features/login_check.php" method="post">
            <div class="form-group">
              <label class="select-none"><strong>Email</strong></label>
              <input type="email" class="form-control select-none" placeholder="Masukkan email anda" name="pekerja-email" autocomplete="pekerja-email" required>
            </div>
            <div class="form-group position-relative">
              <label class="select-none"><strong>Password</strong></label>
              <div class="input-group">
                <input type="password" class="form-control select-none" placeholder="Masukkan password anda" name="pekerja-password" id="pekerja-password" autocomplete="current-password" required>
                <div class="input-group-append">
                  <div class="input-group-text" style="right:15px; top:38px; cursor:pointer;" onclick="togglePassword('pekerja-password', this)">
                      <i class="fas fa-eye" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- Captcha -->
            <div class="form-group">
              <label class="select-none"><strong>Verifikasi Captcha</strong></label>
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="d-flex">
                    <img id="captchaPekerja" class="select-none"
                      data-base="<?= BASE_URL ?>components/features/captcha_generate.php?id=login_pekerja"
                      src="<?= BASE_URL ?>components/features/captcha_generate.php?id=login_pekerja&<?= time() ?>"
                      alt="Captcha"
                    >
                    <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaPekerja')">
                      <i class="fas fa-sync" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
                <div class="col">
                  <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                  oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-2 w-100" name="pekerja-submit">
              <strong>Masuk<i class="fas fa-sign-in-alt ml-1" aria-hidden="true"></i></strong>
            </button>
          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer text-center flex-column">
          <p class="mb-1 select-none">Login sebagai pasien? 
            <a href="#" id="switchToPasienFromPekerja">
              <span>Klik di sini</span>
            </a>
          </p>
          <p class="mb-0 select-none">Lupa Password? 
            <a href="<?= BASE_URL ?>index.php?page=admin/user_management">
              <span>Klik di sini</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>

<?php endif;?>