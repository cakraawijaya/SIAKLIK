<!-- Hanya bisa diakses kalau belum login -->
<?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>


  <!-- =========================================================================================== -->
  <!-- MODAL REGISTRASI PASIEN                                                                     -->
  <!-- =========================================================================================== -->
  <div class="modal fade" id="modalRegistration" tabindex="-1" role="dialog" aria-labelledby="modalRegistrationLabel" aria-hidden="true">

    <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">


        <!-- ==================================== HEADER =================================== -->
        <div class="modal-header bg-success text-white text-center">

          <!-- Judul modal -->
          <h5 class="modal-title w-100 select-none" id="modalRegistrationLabel">
            <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>Daftar Akun Pasien
          </h5>

          <!-- Tombol tutup modal -->
          <button type="button" class="close select-none" onclick="$('#modalRegistration').modal('hide')">&times;</button>

        </div>


        <!-- ===================================== BODY ==================================== -->
        <div class="modal-body pt-4 px-4">

          <!-- Form registrasi pasien -->
          <form action="<?= BASE_URL ?>components/features/auth/authentication/registration.php" method="post">

            <!-- Baris untuk mengatur tata letak tampilan -->
            <div class="row">

              <!-- ==================================== KOLOM 1 ================================== -->
              <div class="col-md-6">

                <!-- Username -->
                <div class="form-group">
                  <label class="select-none"><strong>Username</strong></label>
                  <input type="text" class="form-control select-none" placeholder="Masukkan username" name="register-username" autocomplete="username" required oninput="this.value = this.value.replace(/[^a-z0-9]/gi, '').toLowerCase(); if(this.value.length > 20) this.value = this.value.slice(0, 20)">
                </div>

                <!-- Nama Lengkap -->
                <div class="form-group mt-2">
                  <label class="select-none"><strong>Nama Lengkap</strong></label>
                  <input type="text" class="form-control select-none" placeholder="Masukkan nama lengkap" name="register-name" autocomplete="name" required oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)">
                </div>

                <!-- Email -->
                <div class="form-group mt-2">
                  <label class="select-none"><strong>Email</strong></label>
                  <input type="email" class="form-control select-none" placeholder="Masukkan email aktif" name="register-email" autocomplete="email" required oninput="filterEmail(this)">
                </div>
              </div>


              <!-- ==================================== KOLOM 2 ================================== -->
              <div class="col-md-6">

                <!-- Password -->
                <div class="form-group position-relative">
                  <label class="select-none"><strong>Password</strong></label>
                  <div class="input-group">
                    <input type="password" class="form-control select-none" placeholder="Masukkan password" name="register-password" id="register-password" autocomplete="new-password" required>
                    <div class="input-group-append">
                      <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('register-password', this)">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group position-relative mt-2">
                  <label class="select-none"><strong>Konfirmasi Password</strong></label>
                  <div class="input-group">
                    <input type="password" class="form-control select-none" placeholder="Ulangi password" name="register-confirm-password" id="register-confirm-password" autocomplete="new-confirm-password" required>
                    <div class="input-group-append">
                      <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('register-confirm-password', this)">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Captcha -->
                <div class="form-group mt-2">
                  <label class="select-none"><strong>Verifikasi Captcha</strong></label>
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <div class="d-flex">
                        <img id="captchaRegistrationPasien" class="select-none"
                          data-base="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=registrasi_pasien"
                          src="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=registrasi_pasien&<?= time() ?>"
                          alt="Captcha"
                        >
                        <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaRegistrationPasien')">
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

              </div>
            </div>

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-success py-3 mt-3 w-100">
              <strong>Daftar Sekarang <i class="fas fa-user-plus ml-1" aria-hidden="true"></i></strong>
            </button>

          </form>
        </div>


        <!-- ==================================== FOOTER =================================== -->
        <div class="modal-footer text-center flex-column">

          <!-- Link untuk menuju ke modal Login Pasien -->
          <p class="mb-0 select-none">Sudah punya akun?
            <a onclick="openLink('#', false)" id="switchToPasienFromRegistration">
              <span>Masuk</span>
            </a>
          </p>
        </div>

      </div>
    </div>
  </div>



  <script>

    // ===========================================================================================
    // FUNGSI FILTER EMAIL
    // ===========================================================================================
    function filterEmail(el) {

      // Mengubah seluruh karakter menjadi huruf kecil
      // Kemudian menghapus spasi di awal & akhir string
      let val = el.value.toLowerCase().trim();

      // Menghapus semua karakter selain :
      // Huruf (a-z), Angka (0-9), Titik (.), dan Simbol @
      val = val.replace(/[^a-z0-9.@]/g, '');

      // Pisahkan email berdasarkan karakter "@"
      let parts = val.split('@');

      // Jika terdapat lebih dari satu "@", maka :
      if (parts.length > 2) {

        // Ambil bagian pertama sebagai local-part
        // Gabungkan sisanya sebagai domain tanpa "@"
        val = parts[0] + '@' + parts.slice(1).join('');
      }

      // Jika email mengandung karakter "@", maka :
      if (val.includes('@')) {

        // Mengganti titik berturut-turut (..) menjadi satu titik (.)
        let local = parts[0].replace(/\.{2,}/g, '.');

        // Menghapus karakter selain huruf dan titik pada domain
        let domain = parts[1].replace(/[^a-z.]/g, '');

        // Menggabungkan kembali local dan domain
        val = local + '@' + domain;
      }

      // Jika panjang email lebih dari 45 karakter, maka :
      if (val.length > 45) {
        val = val.slice(0, 45); // Potong email hingga maksimal 45 karakter
      }

      el.value = val; // Set nilai input dengan hasil yang sudah difilter
    }

  </script>

<?php endif; ?>