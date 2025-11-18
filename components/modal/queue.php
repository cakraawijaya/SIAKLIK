<?php

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $username = $_SESSION['username'] ?? '';
  $display_name = '';

  if ($username) {
    if (!isset($koneksi)) {
      include_once __DIR__ . '/../../config/config.php';
    }
    if (isset($koneksi)) {
      $stmt = $koneksi->prepare("
        SELECT nama FROM akun_pekerja WHERE username = ?
        UNION
        SELECT nama FROM akun_pasien WHERE username = ?
        LIMIT 1
      ");
      if ($stmt) {
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $stmt->bind_result($display_name);
        $stmt->fetch();
        $stmt->close();
      }
    }
  }
  if (!$display_name) $display_name = '';

?>

<!-- Hanya bisa diakses kalau sudah login -->
<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>

  <!-- ========================================= -->
  <!-- MODAL ANTREAN INTERNAL -->
  <!-- ========================================= -->
  <div class="modal fade queue-modal" id="modalAntreInternal" tabindex="-1" role="dialog" aria-labelledby="modalAntreInternalLabel" aria-hidden="true" data-kategori="INTERNAL">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title select-none" id="modalAntreInternalLabel">
            <i class="fas fa-hospital-user mr-2" aria-hidden="true"></i>Daftar Antrean INTERNAL
          </h5>
          <button type="button" class="close select-none" onclick="$('#modalAntreInternal').modal('hide')">&times;</button>
        </div>
        <div class="modal-body pt-4 px-4">
          <form class="queue-form" data-kategori="INTERNAL">
            <div class="form-group">
              <label class="select-none"><strong>Nama</strong></label>
              <span type="text" class="form-control select-none" name="display_name"
              style="display: flex; align-items: center; height: 33px;" readonly>
                <strong><?= htmlspecialchars($display_name) ?></strong>
              </span>
            </div>

            <div class="form-group">
              <label class="select-none"><strong>Poli / Layanan</strong></label>
              <select class="form-control select-none" name="layanan" required>
                <option value="" disabled selected>Pilih Poli Tujuan</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Gigi">Poli Gigi</option>
              </select>
            </div>

            <!-- Hidden -->
            <input type="hidden" name="kategori" value="INTERNAL">
            <input type="hidden" name="request_token" value="">
            <input type="hidden" name="kode" value="">

            <button type="submit" class="btn btn-primary mt-3 py-2 w-100">
              Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>
            </button>
          </form>
        </div>
        <div class="modal-footer">
          <small class="text-muted select-none">Pastikan Anda belum memiliki antrean aktif pada kategori ini.</small>
        </div>
      </div>
    </div>
  </div>


  <!-- ========================================= -->
  <!-- MODAL ANTREAN BPJS -->
  <!-- ========================================= -->
  <div class="modal fade queue-modal" id="modalAntreBPJS" tabindex="-1" role="dialog" aria-labelledby="modalAntreBPJSLabel" aria-hidden="true" data-kategori="BPJS">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title select-none" id="modalAntreBPJSLabel">
            <i class="fas fa-id-card mr-2" aria-hidden="true"></i>Daftar Antrean BPJS
          </h5>
          <button type="button" class="close select-none" onclick="$('#modalAntreBPJS').modal('hide')">&times;</button>
        </div>
        <div class="modal-body pt-4 px-4">
          <form class="queue-form" data-kategori="BPJS">
            <div class="form-group">
              <label class="select-none"><strong>Nama</strong></label>
              <span type="text" class="form-control select-none" name="display_name"
              style="display: flex; align-items: center; height: 33px;" readonly>
                <strong><?= htmlspecialchars($display_name) ?></strong>
              </span>
            </div>

            <div class="form-group">
              <label class="select-none"><strong>Poli / Layanan</strong></label>
              <select class="form-control select-none" name="layanan" required>
                <option value="" disabled selected>Pilih Poli Tujuan</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Gigi">Poli Gigi</option>
              </select>
            </div>

            <!-- Hidden -->
            <input type="hidden" name="kategori" value="BPJS">
            <input type="hidden" name="request_token" value="">
            <input type="hidden" name="kode" value="">

            <button type="submit" class="btn btn-success mt-3 py-2 w-100">
              Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>
            </button>
          </form>
        </div>
        <div class="modal-footer select-none">
          <small class="text-muted">Pastikan Anda belum memiliki antrean aktif pada kategori ini.</small>
        </div>
      </div>
    </div>
  </div>


  <!-- ========================================= -->
  <!-- MODAL ANTREAN UMUM -->
  <!-- ========================================= -->
  <div class="modal fade queue-modal" id="modalAntreUmum" tabindex="-1" role="dialog" aria-labelledby="modalAntreUmumLabel" aria-hidden="true" data-kategori="UMUM">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title select-none" id="modalAntreUmumLabel">
            <i class="fas fa-user-friends mr-2" aria-hidden="true"></i>Daftar Antrean UMUM
          </h5>
          <button type="button" class="close select-none" onclick="$('#modalAntreUmum').modal('hide')">&times;</button>
        </div>
        <div class="modal-body pt-4 px-4">
          <form class="queue-form" data-kategori="UMUM">
            <div class="form-group">
              <label class="select-none"><strong>Nama</strong></label>
              <span type="text" class="form-control select-none" name="display_name"
              style="display: flex; align-items: center; height: 33px;" readonly>
                <strong><?= htmlspecialchars($display_name) ?></strong>
              </span>
            </div>

            <div class="form-group">
              <label class="select-none"><strong>Poli / Layanan</strong></label>
              <select class="form-control select-none" name="layanan" required>
                <option value="" disabled selected>Pilih Poli Tujuan</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Gigi">Poli Gigi</option>
              </select>
            </div>

            <!-- Hidden -->
            <input type="hidden" name="kategori" value="UMUM">
            <input type="hidden" name="request_token" value="">
            <input type="hidden" name="kode" value="">

            <button type="submit" class="btn btn-info mt-3 py-2 w-100">
              Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>
            </button>
          </form>
        </div>
        <div class="modal-footer select-none">
          <small class="text-muted">Pastikan Anda belum memiliki antrean aktif pada kategori ini.</small>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>