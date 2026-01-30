<?php

  // Hanya bisa diakses kalau sudah login
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):

    // Hanya Pekerja & Admin yang bisa akses
    $allowed_roles = ['pekerja', 'admin'];
    if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):

?>


      <!-- =========================================================================================== -->
      <!-- MODAL TAMBAH RIWAYAT PASIEN                                                                 -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalAddPasien" tabindex="-1" role="dialog" aria-labelledby="modalAddPasienLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">

            <!-- Form tambah riwayat pasien -->
            <form method="POST" id="formAddPasien" autocomplete="off">


              <!-- ==================================== HEADER =================================== -->
              <div class="modal-header bg-success text-white">

                <!-- Judul modal -->
                <h5 class="modal-title select-none" id="modalAddPasienLabel">
                  <i class="fa fa-user-plus mr-2" aria-hidden="true"></i>Tambah Data Pasien
                </h5>

                <!-- Tombol tutup modal -->
                <button type="button" class="close select-none" onclick="$('#modalAddPasien').modal('hide')">&times;</button>

              </div>


              <!-- ===================================== BODY ==================================== -->
              <div class="modal-body px-4 py-3">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row g-3">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4">

                    <!-- Nama lengkap -->
                    <div class="form-group">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea name="nama" class="form-control select-none" placeholder="Masukkan Nama Pasien" rows="3" required oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Alamat</strong></label>
                      <textarea name="alamat" class="form-control select-none" placeholder="Masukkan Alamat" rows="5" required oninput="if(this.value.length > 130) this.value = this.value.slice(0, 130)"></textarea>
                    </div>

                    <!-- Umur -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Umur</strong></label>
                      <input type="number" name="umur" class="form-control select-none" placeholder="Masukkan Umur" required oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3)">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4">

                    <!-- Pekerjaan -->
                    <div class="form-group">
                      <label class="select-none"><strong>Pekerjaan</strong></label>
                      <input type="text" name="pekerjaan" class="form-control select-none" placeholder="Masukkan Pekerjaan" required oninput="if(this.value.length > 100) this.value = this.value.slice(0, 100)">
                    </div>

                    <!-- Status perawatan -->
                    <div class="form-group form-status">
                      <label class="select-none"><strong>Status</strong></label>
                      <select name="status" id="status" class="form-control select-none" required>
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="Rawat Inap">Rawat Inap</option>
                        <option value="Rawat Jalan">Rawat Jalan</option>
                        <option value="Observasi">Observasi</option>
                        <option value="Pasca Rawat Inap">Pasca Rawat Inap</option>
                      </select>
                    </div>

                    <!-- Jenis layanan klinik -->
                    <div class="form-group form-layanan">
                        <label class="select-none"><strong>Layanan</strong></label>
                        <select name="layanan" id="layanan" class="form-control select-none" required>
                            <option value="" disabled selected>Pilih Layanan</option>
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                        </select>
                    </div>

                    <!-- Keterangan tambahan -->
                    <div class="form-group form-keterangan">
                      <label class="select-none"><strong>Keterangan</strong></label>
                      <input type="text" name="keterangan" class="form-control select-none" placeholder="Masukkan Keterangan">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4">

                    <!-- Jenis kelamin -->
                    <div class="form-group">
                      <label class="select-none"><strong>Jenis Kelamin</strong></label><br>
                      <div class="form-check form-check-inline select-none">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="L" checked>
                        <label class="form-check-label" for="laki">Laki-laki</label>
                      </div>
                      <div class="form-check form-check-inline select-none">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P">
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                      </div>
                    </div>

                    <!-- NIM / NIP (jika civitas akademika) -->
                    <div class="form-group form-nim-nip">
                      <label class="select-none"><strong>NIM / NIP</strong></label>
                      <input type="number" name="nim_nip" class="form-control select-none" placeholder="Masukkan NIM/NIP Pasien" oninput="if(this.value.length > 18) this.value = this.value.slice(0, 18)">
                    </div>

                    <!-- Nomor BPJS -->
                    <div class="form-group form-no-bpjs">
                      <label class="select-none"><strong>No BPJS</strong></label>
                      <input type="number" name="no_bpjs" class="form-control select-none" placeholder="Masukkan No BPJS" oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                    </div>

                    <!-- Kategori pasien -->
                    <div class="form-group form-kategori">
                      <label class="select-none"><strong>Kategori</strong></label><br>
                      <div class="form-check select-none">
                        <input class="form-check-input" type="radio" name="kategori" value="Eksternal" id="kategori_eksternal" checked>
                        <label class="form-check-label" for="kategori_eksternal">
                          Eksternal
                          <span class="text-muted text-success-custom">
                            (<small><strong>Non-Civitas Akademika</strong></small>)
                          </span>
                        </label>
                      </div>
                      <div class="form-check select-none mt-1">
                        <input class="form-check-input" type="radio" name="kategori" value="Internal" id="kategori_internal">
                        <label class="form-check-label" for="kategori_internal">
                          Internal
                          <span class="text-muted text-success-custom">
                            (<small><strong>Civitas Akademika</strong></small>)
                          </span>
                        </label>
                      </div>
                    </div>

                  </div>
                </div>
              </div>


              <!-- ==================================== FOOTER =================================== -->
              <div class="modal-footer mr-2">

                <!-- Tombol batal -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                </button>

                <!-- Tombol simpan -->
                <button type="submit" name="submit_add" class="btn btn-success">
                  <strong><i class="fa fa-save mr-1" aria-hidden="true"></i>Simpan</strong>
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL UBAH RIWAYAT PASIEN                                                                   -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalEditPasien" tabindex="-1" role="dialog" aria-labelledby="modalEditPasienLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">

            <!-- Form ubah riwayat pasien -->
            <form method="POST" id="formEditPasien" autocomplete="off">


              <!-- ==================================== HEADER =================================== -->
              <div class="modal-header bg-warning-custom text-white">

                <!-- Judul modal -->
                <h5 class="modal-title select-none" id="modalEditPasienLabel">
                  <i class="fa fa-edit mr-2" aria-hidden="true"></i>Edit Data Pasien
                </h5>

                <!-- Tombol tutup modal -->
                <button type="button" class="close select-none" onclick="$('#modalEditPasien').modal('hide')">&times;</button>

              </div>


              <!-- ===================================== BODY ==================================== -->
              <div class="modal-body px-4 py-3">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row g-3">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4">

                    <!-- ID Pasien -->
                    <div class="form-group select-none">
                      <label class="select-none"><strong>ID Pasien</strong></label>
                      <span type="text" class="form-control select-none"
                      style="display: flex; align-items: center; height: 33px;"
                      id="edit_id_display" readonly>
                      </span>

                      <!-- Data tersembunyi -->
                      <input type="hidden" id="edit_id" name="id">
                    </div>

                    <!-- Nama lengkap -->
                    <div class="form-group form-nama">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea id="edit_nama" name="nama" class="form-control select-none" placeholder="Masukkan Nama Pasien" rows="3" required oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group form-alamat">
                      <label class="select-none"><strong>Alamat</strong></label>
                      <textarea id="edit_alamat" name="alamat" class="form-control select-none" placeholder="Masukkan Alamat" rows="5" required oninput="if(this.value.length > 130) this.value = this.value.slice(0, 130)"></textarea>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4">

                    <!-- Umur -->
                    <div class="form-group">
                      <label class="select-none"><strong>Umur</strong></label>
                      <input type="number" id="edit_umur" name="umur" class="form-control select-none" placeholder="Masukkan Umur" required oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3)">
                    </div>

                    <!-- Pekerjaan -->
                    <div class="form-group form-pekerjaan">
                      <label class="select-none"><strong>Pekerjaan</strong></label>
                      <input type="text" id="edit_pekerjaan" name="pekerjaan" class="form-control select-none" placeholder="Masukkan Pekerjaan" oninput="if(this.value.length > 100) this.value = this.value.slice(0, 100)">
                    </div>

                    <!-- Status perawatan -->
                    <div class="form-group form-status">
                      <label class="select-none"><strong>Status</strong></label>
                      <select id="edit_status" name="status" class="form-control select-none" required>
                        <option value="Rawat Inap">Rawat Inap</option>
                        <option value="Rawat Jalan">Rawat Jalan</option>
                        <option value="Observasi">Observasi</option>
                        <option value="Pasca Rawat Inap">Pasca Rawat Inap</option>
                      </select>
                    </div>

                    <!-- Jenis layanan klinik -->
                    <div class="form-group form-layanan">
                      <label class="select-none"><strong>Layanan</strong></label>
                      <select id="edit_layanan" name="layanan" class="form-control select-none" required>
                          <option value="Poli Umum">Poli Umum</option>
                          <option value="Poli Gigi">Poli Gigi</option>
                      </select>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4">

                    <!-- Jenis kelamin -->
                    <div class="form-group">
                      <label class="select-none"><strong>Jenis Kelamin</strong></label><br>
                      <div class="form-check form-check-inline select-none">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit_laki" value="L">
                        <label class="form-check-label" for="edit_laki">Laki-laki</label>
                      </div>
                      <div class="form-check form-check-inline select-none">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit_perempuan" value="P">
                        <label class="form-check-label" for="edit_perempuan">Perempuan</label>
                      </div>
                    </div>

                    <!-- NIM / NIP (jika civitas akademika) -->
                    <div class="form-group form-nim-nip">
                      <label class="select-none"><strong>NIM / NIP</strong></label>
                      <input type="number" id="edit_nim_nip" name="nim_nip" class="form-control select-none" placeholder="Masukkan NIM/NIP Pasien" oninput="if(this.value.length > 18) this.value = this.value.slice(0, 18)">
                    </div>

                    <!-- Nomor BPJS -->
                    <div class="form-group form-no-bpjs">
                      <label class="select-none"><strong>No BPJS</strong></label>
                      <input type="number" id="edit_no_bpjs" name="no_bpjs" class="form-control select-none" placeholder="Masukkan No BPJS" oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                    </div>

                    <!-- Kategori pasien -->
                    <div class="form-group form-kategori">
                      <label class="select-none"><strong>Kategori</strong></label><br>
                      <div class="form-check form-check-inline select-none">
                        <input class="form-check-input" type="radio" name="kategori" value="Eksternal" id="edit_kategori_eksternal">
                        <label class="form-check-label" for="edit_kategori_eksternal">Eksternal</label>
                      </div>
                      <div class="form-check form-check-inline select-none">
                        <input class="form-check-input" type="radio" name="kategori" value="Internal" id="edit_kategori_internal">
                        <label class="form-check-label" for="edit_kategori_internal">Internal</label>
                      </div>
                    </div>

                    <!-- Keterangan tambahan -->
                    <div class="form-group form-keterangan">
                      <label class="select-none"><strong>Keterangan</strong></label>
                      <input type="text" id="edit_keterangan" name="keterangan" class="form-control select-none" placeholder="Masukkan Keterangan">
                    </div>

                  </div>
                </div>
              </div>


              <!-- ==================================== FOOTER =================================== -->
              <div class="modal-footer mr-2">

                <!-- Tombol batal -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                </button>

                <!-- Tombol ubah -->
                <button type="submit" name="submit_edit" class="btn btn-warning-custom text-white">
                  <strong><i class="fa fa-edit mr-1" aria-hidden="true"></i>Ubah</strong>
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL HAPUS RIWAYAT PASIEN                                                                  -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalDeletePasien" tabindex="-1" role="dialog" aria-labelledby="modalDeletePasienLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran standard, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">

            <!-- Form hapus riwayat pasien -->
            <form method="POST" id="formDeletePasien">

              <!-- Data tersembunyi -->
              <input type="hidden" name="submit_delete" value="1">
              <input type="hidden" name="id" id="delete_id">


              <!-- ==================================== HEADER =================================== -->
              <div class="modal-header bg-danger text-white">

                <!-- Judul modal -->
                <h5 class="modal-title select-none" id="modalDeletePasienLabel">
                  <i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>Konfirmasi Hapus
                </h5>

                <!-- Tombol tutup modal -->
                <button type="button" class="close select-none" onclick="$('#modalDeletePasien').modal('hide')">&times;</button>

              </div>


              <!-- ===================================== BODY ==================================== -->
              <div class="modal-body text-center select-none">

                <!-- Tampilan data riwayat pasien yang akan dihapus -->
                <p class="text-danger font-weight-bold my-4">
                  <span id="delete_show_nama"></span>
                  <span id="delete_show_id"></span>
                </p>
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
              </div>


              <!-- ==================================== FOOTER =================================== -->
              <div class="modal-footer justify-content-center" style="gap: 1rem;">

                <!-- Tombol batal -->
                <button type="button" class="btn btn-secondary py-2 px-4" data-dismiss="modal">
                  <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                </button>

                <!-- Tombol hapus -->
                <button type="submit" name="submit_delete" value="1" class="btn btn-danger py-2 px-4" id="confirmDeleteBtn">
                  <strong><i class="fa fa-trash mr-1" aria-hidden="true"></i>Hapus</strong>
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>

    <?php endif; ?>
  <?php endif; ?>