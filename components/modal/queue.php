<?php

  // ===========================================================================================
  // CEK SESSION
  // ===========================================================================================
  // Mengecek apakah session belum pernah dimulai
  if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Jika session belum aktif, maka mulai session baru
  }


  // ===========================================================================================
  // AMBIL DATA USER DARI SESSION
  // ===========================================================================================
  $username = $_SESSION['username'] ?? ''; // Username disimpan di session saat login
  $display_name = ''; // Jika tidak ada, maka default string = kosong


  // ===========================================================================================
  // AMBIL NAMA USER DARI DATABASE
  // ===========================================================================================
  if ($username) {

    // Pastikan koneksi database tersedia
    if (!isset($koneksi)) {
      require_once __DIR__ . '/../../config/config.php';
    }

    // Jika koneksi database tersedia, maka :
    if (isset($koneksi)) {

      // Cari nama user di dua tabel akun (pekerja & pasien)
      $stmt = $koneksi->prepare("
        SELECT nama FROM akun_pekerja WHERE username = ?
        UNION
        SELECT nama FROM akun_pasien WHERE username = ?
        LIMIT 1
      ");

      // Eksekusi statement jika valid
      if ($stmt) {
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $stmt->bind_result($display_name);
        $stmt->fetch();
        $stmt->close();
      }
    }

  } if (!$display_name) $display_name = ''; // Fallback jika nama tidak ditemukan


  // ===========================================================================================
  // PENGECEKAN STATUS LOGIN
  // ===========================================================================================
  // Hanya bisa diakses kalau sudah login
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):

?>


  <!-- =========================================================================================== -->
  <!-- MODAL ANTREAN INTERNAL                                                                      -->
  <!-- =========================================================================================== -->
  <div class="modal fade queue-modal" id="modalAntreInternal" tabindex="-1" role="dialog" aria-labelledby="modalAntreInternalLabel" aria-hidden="true" data-kategori="INTERNAL">

    <!-- Dialog modal (ukuran standard, berada di tengah & bisa di scroll) -->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">


        <!-- ==================================== HEADER =================================== -->
        <div class="modal-header bg-primary text-white">

          <!-- Judul modal -->
          <h5 class="modal-title select-none" id="modalAntreInternalLabel">
            <i class="fas fa-hospital-user mr-2" aria-hidden="true"></i>Daftar Antrean INTERNAL
          </h5>

          <!-- Tombol tutup modal -->
          <button type="button" class="close select-none" onclick="$('#modalAntreInternal').modal('hide')">&times;</button>

        </div>


        <!-- ===================================== BODY ==================================== -->
        <div class="modal-body pt-4 px-4">

          <!-- Form pendaftaran antrean pasien kategori INTERNAL -->
          <form class="queue-form" data-kategori="INTERNAL">

            <!-- Nama Lengkap -->
            <div class="form-group">
              <label class="select-none"><strong>Nama</strong></label>
              <span type="text" class="form-control select-none" name="display_name"
              style="display: flex; align-items: center; height: 33px;" readonly>
                <strong><?= htmlspecialchars($display_name) ?></strong>
              </span>
            </div>

            <!-- Jenis layanan klinik -->
            <div class="form-group">
              <label class="select-none"><strong>Layanan</strong></label>
              <select class="form-control select-none" name="layanan" required>
                <option value="" disabled selected>Pilih Layanan</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Gigi">Poli Gigi</option>
              </select>
            </div>

            <!-- Data tersembunyi -->
            <input type="hidden" name="kategori" value="INTERNAL">
            <input type="hidden" name="request_token" value="">
            <input type="hidden" name="kode" value="">

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-primary mt-3 py-2 w-100">
              Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>
            </button>

          </form>
        </div>


        <!-- ==================================== FOOTER =================================== -->
        <!-- Informasi penting -->
        <div class="modal-footer">
          <small class="text-muted select-none">Pastikan Anda belum memiliki antrean aktif pada kategori ini.</small>
        </div>

      </div>
    </div>
  </div>



  <!-- =========================================================================================== -->
  <!-- MODAL ANTREAN BPJS                                                                          -->
  <!-- =========================================================================================== -->
  <div class="modal fade queue-modal" id="modalAntreBPJS" tabindex="-1" role="dialog" aria-labelledby="modalAntreBPJSLabel" aria-hidden="true" data-kategori="BPJS">

    <!-- Dialog modal (ukuran standard, berada di tengah & bisa di scroll) -->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">


        <!-- ==================================== HEADER =================================== -->
        <div class="modal-header bg-success text-white">

          <!-- Judul modal -->
          <h5 class="modal-title select-none" id="modalAntreBPJSLabel">
            <i class="fas fa-id-card mr-2" aria-hidden="true"></i>Daftar Antrean BPJS
          </h5>

          <!-- Tombol tutup modal -->
          <button type="button" class="close select-none" onclick="$('#modalAntreBPJS').modal('hide')">&times;</button>

        </div>


        <!-- ===================================== BODY ==================================== -->
        <div class="modal-body pt-4 px-4">

          <!-- Form pendaftaran antrean pasien kategori BPJS -->
          <form class="queue-form" data-kategori="BPJS">

            <!-- Nama Lengkap -->
            <div class="form-group">
              <label class="select-none"><strong>Nama</strong></label>
              <span type="text" class="form-control select-none" name="display_name"
              style="display: flex; align-items: center; height: 33px;" readonly>
                <strong><?= htmlspecialchars($display_name) ?></strong>
              </span>
            </div>

            <!-- Jenis layanan klinik -->
            <div class="form-group">
              <label class="select-none"><strong>Layanan</strong></label>
              <select class="form-control select-none" name="layanan" required>
                <option value="" disabled selected>Pilih Layanan</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Gigi">Poli Gigi</option>
              </select>
            </div>

            <!-- Data tersembunyi -->
            <input type="hidden" name="kategori" value="BPJS">
            <input type="hidden" name="request_token" value="">
            <input type="hidden" name="kode" value="">

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-success mt-3 py-2 w-100">
              Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>
            </button>

          </form>
        </div>


        <!-- ==================================== FOOTER =================================== -->
        <!-- Informasi penting -->
        <div class="modal-footer select-none">
          <small class="text-muted">Pastikan Anda belum memiliki antrean aktif pada kategori ini.</small>
        </div>

      </div>
    </div>
  </div>



  <!-- =========================================================================================== -->
  <!-- MODAL ANTREAN UMUM                                                                          -->
  <!-- =========================================================================================== -->
  <div class="modal fade queue-modal" id="modalAntreUmum" tabindex="-1" role="dialog" aria-labelledby="modalAntreUmumLabel" aria-hidden="true" data-kategori="UMUM">

    <!-- Dialog modal (ukuran standard, berada di tengah & bisa di scroll) -->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">


        <!-- ==================================== HEADER =================================== -->
        <div class="modal-header bg-info text-white">

          <!-- Judul modal -->
          <h5 class="modal-title select-none" id="modalAntreUmumLabel">
            <i class="fas fa-user-friends mr-2" aria-hidden="true"></i>Daftar Antrean UMUM
          </h5>

          <!-- Tombol tutup modal -->
          <button type="button" class="close select-none" onclick="$('#modalAntreUmum').modal('hide')">&times;</button>

        </div>


        <!-- ===================================== BODY ==================================== -->
        <div class="modal-body pt-4 px-4">

          <!-- Form pendaftaran antrean pasien kategori UMUM -->
          <form class="queue-form" data-kategori="UMUM">

            <!-- Nama Lengkap -->
            <div class="form-group">
              <label class="select-none"><strong>Nama</strong></label>
              <span type="text" class="form-control select-none" name="display_name"
              style="display: flex; align-items: center; height: 33px;" readonly>
                <strong><?= htmlspecialchars($display_name) ?></strong>
              </span>
            </div>

            <!-- Jenis layanan klinik -->
            <div class="form-group">
              <label class="select-none"><strong>Layanan</strong></label>
              <select class="form-control select-none" name="layanan" required>
                <option value="" disabled selected>Pilih Layanan</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Gigi">Poli Gigi</option>
              </select>
            </div>

            <!-- Data tersembunyi -->
            <input type="hidden" name="kategori" value="UMUM">
            <input type="hidden" name="request_token" value="">
            <input type="hidden" name="kode" value="">

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-info mt-3 py-2 w-100">
              Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>
            </button>

          </form>
        </div>


        <!-- ==================================== FOOTER =================================== -->
        <!-- Informasi penting -->
        <div class="modal-footer select-none">
          <small class="text-muted">Pastikan Anda belum memiliki antrean aktif pada kategori ini.</small>
        </div>

      </div>
    </div>
  </div>

<?php endif; ?>