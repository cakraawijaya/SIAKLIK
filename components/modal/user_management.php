<?php

  // Hanya bisa diakses kalau sudah login
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):

    // Hanya Admin yang bisa akses
    $allowed_roles = ['admin'];
    if (isset($_SESSION['level']) && in_array($_SESSION['level'], $allowed_roles)):

?>


      <!-- =========================================================================================== -->
      <!-- MODAL TAMBAH DATA PENGGUNA PASIEN                                                           -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalAddPenggunaPasien" tabindex="-1" role="dialog" aria-labelledby="modalAddPenggunaPasienLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">


            <!-- ==================================== HEADER =================================== -->
            <div class="modal-header bg-success text-white text-center">

              <!-- Judul modal -->
              <h5 class="modal-title select-none" id="modalAddPenggunaPasienLabel">
                <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>
                <span>Tambah Akun Pasien</span>
              </h5>

              <!-- Tombol tutup modal -->
              <button type="button" class="close select-none" onclick="$('#modalAddPenggunaPasien').modal('hide')">&times;</button>

            </div>


            <!-- ===================================== BODY ==================================== -->
            <div class="modal-body px-4 mt-2">

              <!-- Form tambah data pengguna (Pasien) -->
              <form method="post" id="formAddPenggunaPasien">

                <!-- Data tersembunyi -->
                <input type="hidden" name="kategori" value="pasien">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4 col-left mt-2">

                    <!-- Foto -->
                    <div class="border rounded bg-light" style="height: 202px;">
                      <img id="previewFotoAddPasien"
                          class="img-fluid p-2 rounded select-none"
                          style="max-height: 202px; object-fit: cover; width: 100%;">
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group form-upload-file">
                      <label class="select-none"><strong>Upload Foto</strong></label>
                      <input type="file" class="select-none" id="fileInputAddPasien" name="add-foto" accept="image/*" onchange="updateFileName(this); previewImage(this);" style="display:none;">
                      <div class="file-input-custom select-none" onclick="document.getElementById('fileInputAddPasien').click()">
                        <button type="button" class="btn-choose text-center align-middle">
                          <span>Pilih Berkas</span>
                        </button>
                        <span id="file-name-add-pasien">Belum ada berkas</span>
                      </div>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4 col-center">

                    <!-- Username -->
                    <div class="form-group">
                      <label class="select-none"><strong>Username</strong></label>
                      <input type="text" class="form-control select-none" placeholder="Masukkan username" name="add-username" autocomplete="username" required
                      oninput="this.value = this.value.replace(/[^a-z0-9]/gi, '').toLowerCase(); if(this.value.length > 20) this.value = this.value.slice(0, 20)">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea class="form-control select-none" placeholder="Masukkan nama lengkap" name="add-name" rows="4" autocomplete="name" required
                      oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                      </textarea>
                    </div>

                    <!-- Email -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Email</strong></label>
                      <input type="email" class="form-control select-none" placeholder="Masukkan email aktif" name="add-email" autocomplete="email" required oninput="filterEmail(this)">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4 col-right">

                    <!-- Password -->
                    <div class="form-group position-relative">
                      <label class="select-none"><strong>Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Masukkan password" name="add-password" id="add-password-pasien" autocomplete="new-password" required>
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('add-password-pasien', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group position-relative form-konfirmasi-password">
                      <label class="select-none"><strong>Konfirmasi Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Ulangi password" name="add-confirm-password" id="add-confirm-password-pasien" autocomplete="new-confirm-password" required>
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('add-confirm-password-pasien', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Captcha -->
                    <div class="form-group form-verifikasi-captcha">
                      <label class="select-none"><strong>Verifikasi Captcha</strong></label>
                      <div class="d-flex align-items-center">
                        <img id="captchaAddPenggunaPasien" class="select-none"
                          data-base="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=add_user_pasien"
                          src="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=add_user_pasien&<?= time() ?>"
                          alt="Captcha">
                        <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaAddPenggunaPasien')">
                          <i class="fas fa-sync" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div class="align-items-center mt-3">
                        <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                        oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                      </div>
                    </div>

                  </div>
                </div>


                <!-- ==================================== FOOTER =================================== -->
                <div class="modal-footer pb-0 pr-0 mt-3">

                  <!-- Tombol batal -->
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                  </button>

                  <!-- Tombol submit -->
                  <button type="submit" name="submit_add_user" class="btn btn-success">
                    <strong><i class="fa fa-save mr-1" aria-hidden="true"></i>Simpan</strong>
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL UBAH DATA PENGGUNA PASIEN                                                             -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalEditPenggunaPasien" tabindex="-1" role="dialog" aria-labelledby="modalEditPenggunaPasienLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">


            <!-- ==================================== HEADER =================================== -->
            <div class="modal-header bg-warning-custom text-white text-center">

              <!-- Judul modal -->
              <h5 class="modal-title select-none" id="modalEditPenggunaPasienLabel">
                <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>
                <span>Edit Akun Pasien</span>
              </h5>

              <!-- Tombol tutup modal -->
              <button type="button" class="close select-none" onclick="$('#modalEditPenggunaPasien').modal('hide')">&times;</button>

            </div>


            <!-- ===================================== BODY ==================================== -->
            <div class="modal-body px-4 mt-2">

              <!-- Form ubah data pengguna (Pasien) -->
              <form method="post" id="formEditPenggunaPasien">

                <!-- Data tersembunyi -->
                <input type="hidden" name="kategori" value="pasien">
                <input type="hidden" name="edit-email-lama" id="edit-email-lama">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4 col-left mt-2">

                    <!-- Foto -->
                    <div class="border rounded bg-light" style="height: 202px;">
                      <img id="previewFotoEditPasien"
                          class="img-fluid p-2 rounded select-none"
                          style="max-height: 202px; object-fit: cover; width: 100%;">
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group form-upload-file">
                      <label class="select-none"><strong>Upload Foto</strong></label>
                      <input type="file" class="select-none" id="fileInputEditPasien" name="edit-foto" accept="image/*" onchange="updateFileName(this); previewImage(this);" style="display:none;">
                      <div class="file-input-custom select-none" onclick="document.getElementById('fileInputEditPasien').click()">
                        <button type="button" class="btn-choose text-center align-middle">
                          <span>Ganti Foto</span>
                        </button>
                        <span id="file-name-edit-pasien">Belum ada berkas</span>
                      </div>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4 col-center">

                    <!-- Username -->
                    <div class="form-group">
                      <label class="select-none"><strong>Username</strong></label>
                      <input type="text" class="form-control select-none" placeholder="Ubah username" name="edit-username" autocomplete="username" required
                      oninput="this.value = this.value.replace(/[^a-z0-9]/gi, '').toLowerCase(); if(this.value.length > 20) this.value = this.value.slice(0, 20)">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea class="form-control select-none" placeholder="Ubah nama lengkap" name="edit-name" rows="4" autocomplete="name" required
                      oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                      </textarea>
                    </div>

                    <!-- Email -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Email</strong></label>
                      <input type="email" class="form-control select-none" placeholder="Ubah email" name="edit-email" autocomplete="email" required oninput="filterEmail(this)">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4 col-right">

                    <!-- Password -->
                    <div class="form-group position-relative">
                      <label class="select-none"><strong>Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Isi untuk ubah password" name="edit-password" id="edit-password-pasien" autocomplete="new-password">
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('edit-password-pasien', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group position-relative form-konfirmasi-password">
                      <label class="select-none"><strong>Konfirmasi Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Ulangi password diatas" name="edit-confirm-password" id="edit-confirm-password-pasien" autocomplete="new-confirm-password">
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('edit-confirm-password-pasien', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Captcha -->
                    <div class="form-group form-verifikasi-captcha">
                      <label class="select-none"><strong>Verifikasi Captcha</strong></label>
                      <div class="d-flex align-items-center">
                        <img id="captchaEditPenggunaPasien" class="select-none"
                          data-base="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=edit_user_pasien"
                          src="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=edit_user_pasien&<?= time() ?>"
                          alt="Captcha">
                        <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaEditPenggunaPasien')">
                          <i class="fas fa-sync" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div class="align-items-center mt-3">
                        <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                        oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                      </div>
                    </div>

                  </div>
                </div>


                <!-- ==================================== FOOTER =================================== -->
                <div class="modal-footer pb-0 pr-0 mt-3">

                  <!-- Tombol batal -->
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                  </button>

                  <!-- Tombol submit -->
                  <button type="submit" name="submit_edit_user" class="btn btn-warning-custom text-white">
                    <strong><i class="fa fa-save mr-1" aria-hidden="true"></i>Simpan</strong>
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL HAPUS DATA PENGGUNA PASIEN                                                            -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalDeletePenggunaPasien" tabindex="-1" role="dialog" aria-labelledby="modalDeletePenggunaPasienLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran standard, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">

            <!-- Form hapus data pengguna (Pasien) -->
            <form method="POST" id="formDeletePenggunaPasien">

              <!-- Data tersembunyi -->
              <input type="hidden" name="kategori" value="pasien">
              <input type="hidden" name="submit_delete_user" value="1">
              <input type="hidden" name="delete-email" id="delete_email">


              <!-- ==================================== HEADER =================================== -->
              <div class="modal-header bg-danger text-white">

                <!-- Judul modal -->
                <h5 class="modal-title select-none" id="modalDeletePenggunaPasienLabel">
                  <i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                  <span>Konfirmasi Hapus Pasien</span>
                </h5>

                <!-- Tombol tutup modal -->
                <button type="button" class="close select-none" onclick="$('#modalDeletePenggunaPasien').modal('hide')">&times;</button>

              </div>


              <!-- ===================================== BODY ==================================== -->
              <div class="modal-body text-center select-none">

                <!-- Tampilan data pasien yang akan dihapus -->
                <p class="text-danger font-weight-bold my-4">
                  <span id="delete_show_nama"></span>
                  <span id="delete_show_email"></span>
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
                <button type="submit" name="submit_delete_user" value="1" class="btn btn-danger py-2 px-4" id="confirmDeleteBtn">
                  <strong><i class="fa fa-trash mr-1" aria-hidden="true"></i>Hapus</strong>
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL TAMBAH DATA PENGGUNA PEKERJA                                                          -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalAddPenggunaPekerja" tabindex="-1" role="dialog" aria-labelledby="modalAddPenggunaPekerjaLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">


            <!-- ==================================== HEADER =================================== -->
            <div class="modal-header bg-success text-white text-center">

              <!-- Judul modal -->
              <h5 class="modal-title select-none" id="modalAddPenggunaPekerjaLabel">
                <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>
                <span>Tambah Akun Pekerja</span>
              </h5>

              <!-- Tombol tutup modal -->
              <button type="button" class="close select-none" onclick="$('#modalAddPenggunaPekerja').modal('hide')">&times;</button>

            </div>


            <!-- ===================================== BODY ==================================== -->
            <div class="modal-body px-4 mt-2">

              <!-- Form tambah data pengguna (Pekerja) -->
              <form method="post" id="formAddPenggunaPekerja">

                <!-- Data tersembunyi -->
                <input type="hidden" name="kategori" value="pekerja">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4 col-left mt-2">

                    <!-- Foto -->
                    <div class="border rounded bg-light" style="height: 202px;">
                      <img id="previewFotoAddPekerja"
                          class="img-fluid p-2 rounded select-none"
                          style="max-height: 202px; object-fit: cover; width: 100%;">
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group form-upload-file">
                      <label class="select-none"><strong>Upload Foto</strong></label>
                      <input type="file" class="select-none" id="fileInputAddPekerja" name="add-foto" accept="image/*" onchange="updateFileName(this); previewImage(this);" style="display:none;">
                      <div class="file-input-custom select-none" onclick="document.getElementById('fileInputAddPekerja').click()">
                        <button type="button" class="btn-choose text-center align-middle">
                          <span>Pilih Berkas</span>
                        </button>
                        <span id="file-name-add-pekerja">Belum ada berkas</span>
                      </div>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4 col-center">

                    <!-- Username -->
                    <div class="form-group">
                      <label class="select-none"><strong>Username</strong></label>
                      <input type="text" class="form-control select-none" placeholder="Masukkan username" name="add-username" autocomplete="username" required
                      oninput="this.value = this.value.replace(/[^a-z0-9]/gi, '').toLowerCase(); if(this.value.length > 20) this.value = this.value.slice(0, 20)">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea class="form-control select-none" placeholder="Masukkan nama lengkap" name="add-name" rows="4" autocomplete="name" required
                      oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                      </textarea>
                    </div>

                    <!-- Email -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Email</strong></label>
                      <input type="email" class="form-control select-none" placeholder="Masukkan email aktif" name="add-email" autocomplete="email" required oninput="filterEmail(this)">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4 col-right">

                    <!-- Password -->
                    <div class="form-group position-relative">
                      <label class="select-none"><strong>Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Masukkan password" name="add-password" id="add-password-pekerja" autocomplete="new-password" required>
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('add-password-pekerja', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group position-relative form-konfirmasi-password">
                      <label class="select-none"><strong>Konfirmasi Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Ulangi password" name="add-confirm-password" id="add-confirm-password-pekerja" autocomplete="new-confirm-password" required>
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('add-confirm-password-pekerja', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Captcha -->
                    <div class="form-group form-verifikasi-captcha">
                      <label class="select-none"><strong>Verifikasi Captcha</strong></label>
                      <div class="d-flex align-items-center">
                        <img id="captchaAddPenggunaPekerja" class="select-none"
                          data-base="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=add_user_pekerja"
                          src="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=add_user_pekerja&<?= time() ?>"
                          alt="Captcha">
                        <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaAddPenggunaPekerja')">
                          <i class="fas fa-sync" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div class="align-items-center mt-3">
                        <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                        oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                      </div>
                    </div>

                  </div>
                </div>


                <!-- ==================================== FOOTER =================================== -->
                <div class="modal-footer pb-0 pr-0 mt-3">

                  <!-- Tombol batal -->
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                  </button>

                  <!-- Tombol submit -->
                  <button type="submit" name="submit_add_user" class="btn btn-success">
                    <strong><i class="fa fa-save mr-1" aria-hidden="true"></i>Simpan</strong>
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL UBAH DATA PENGGUNA PEKERJA                                                            -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalEditPenggunaPekerja" tabindex="-1" role="dialog" aria-labelledby="modalEditPenggunaPekerjaLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">


            <!-- ==================================== HEADER =================================== -->
            <div class="modal-header bg-warning-custom text-white text-center">

              <!-- Judul modal -->
              <h5 class="modal-title select-none" id="modalEditPenggunaPekerjaLabel">
                <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>
                <span>Edit Akun Pekerja</span>
              </h5>

              <!-- Tombol tutup modal -->
              <button type="button" class="close select-none" onclick="$('#modalEditPenggunaPekerja').modal('hide')">&times;</button>

            </div>


            <!-- ===================================== BODY ==================================== -->
            <div class="modal-body px-4 mt-2">

              <!-- Form ubah data pengguna (Pekerja) -->
              <form method="post" id="formEditPenggunaPekerja">

                <!-- Data tersembunyi -->
                <input type="hidden" name="kategori" value="pekerja">
                <input type="hidden" name="edit-email-lama" id="edit-email-lama">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4 col-left mt-2">

                    <!-- Foto -->
                    <div class="border rounded bg-light" style="height: 202px;">
                      <img id="previewFotoEditPekerja"
                          class="img-fluid p-2 rounded select-none"
                          style="max-height: 202px; object-fit: cover; width: 100%;">
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group form-upload-file">
                      <label class="select-none"><strong>Upload Foto</strong></label>
                      <input type="file" class="select-none" id="fileInputEditPekerja" name="edit-foto" accept="image/*" onchange="updateFileName(this); previewImage(this);" style="display:none;">
                      <div class="file-input-custom select-none" onclick="document.getElementById('fileInputEditPekerja').click()">
                        <button type="button" class="btn-choose text-center align-middle">
                          <span>Ganti Foto</span>
                        </button>
                        <span id="file-name-edit-pekerja">Belum ada berkas</span>
                      </div>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4 col-center">

                    <!-- Username -->
                    <div class="form-group">
                      <label class="select-none"><strong>Username</strong></label>
                      <input type="text" class="form-control select-none" placeholder="Ubah username" name="edit-username" autocomplete="username" required
                      oninput="this.value = this.value.replace(/[^a-z0-9]/gi, '').toLowerCase(); if(this.value.length > 20) this.value = this.value.slice(0, 20)">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea class="form-control select-none" placeholder="Ubah nama lengkap" name="edit-name" rows="4" autocomplete="name" required
                      oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                      </textarea>
                    </div>

                    <!-- Email -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Email</strong></label>
                      <input type="email" class="form-control select-none" placeholder="Ubah email" name="edit-email" autocomplete="email" required oninput="filterEmail(this)">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4 col-right">

                    <!-- Password -->
                    <div class="form-group position-relative">
                      <label class="select-none"><strong>Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Isi untuk ubah password" name="edit-password" id="edit-password-pekerja" autocomplete="new-password">
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('edit-password-pekerja', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group position-relative form-konfirmasi-password">
                      <label class="select-none"><strong>Konfirmasi Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Ulangi password diatas" name="edit-confirm-password" id="edit-confirm-password-pekerja" autocomplete="new-confirm-password">
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('edit-confirm-password-pekerja', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Captcha -->
                    <div class="form-group form-verifikasi-captcha">
                      <label class="select-none"><strong>Verifikasi Captcha</strong></label>
                      <div class="d-flex align-items-center">
                        <img id="captchaEditPenggunaPekerja" class="select-none"
                          data-base="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=edit_user_pekerja"
                          src="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=edit_user_pekerja&<?= time() ?>"
                          alt="Captcha">
                        <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaEditPenggunaPekerja')">
                          <i class="fas fa-sync" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div class="align-items-center mt-3">
                        <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                        oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                      </div>
                    </div>

                  </div>
                </div>


                <!-- ==================================== FOOTER =================================== -->
                <div class="modal-footer pb-0 pr-0 mt-3">

                  <!-- Tombol batal -->
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                  </button>

                  <!-- Tombol submit -->
                  <button type="submit" name="submit_edit_user" class="btn btn-warning-custom text-white">
                    <strong><i class="fa fa-save mr-1" aria-hidden="true"></i>Simpan</strong>
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL HAPUS DATA PENGGUNA PEKERJA                                                           -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalDeletePenggunaPekerja" tabindex="-1" role="dialog" aria-labelledby="modalDeletePenggunaPekerjaLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran standard, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">

            <!-- Form hapus data pengguna (Pekerja) -->
            <form method="POST" id="formDeletePenggunaPekerja">

              <!-- Data tersembunyi -->
              <input type="hidden" name="kategori" value="pekerja">
              <input type="hidden" name="submit_delete_user" value="1">
              <input type="hidden" name="delete-email" id="delete_email">


              <!-- ==================================== HEADER =================================== -->
              <div class="modal-header bg-danger text-white">

                <!-- Judul modal -->
                <h5 class="modal-title select-none" id="modalDeletePenggunaPekerjaLabel">
                  <i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                  <span>Konfirmasi Hapus Pekerja</span>
                </h5>

                <!-- Tombol tutup modal -->
                <button type="button" class="close select-none" onclick="$('#modalDeletePenggunaPekerja').modal('hide')">&times;</button>

              </div>


              <!-- ===================================== BODY ==================================== -->
              <div class="modal-body text-center select-none">

                <!-- Tampilan data pekerja yang akan dihapus -->
                <p class="text-danger font-weight-bold my-4">
                  <span id="delete_show_nama"></span>
                  <span id="delete_show_email"></span>
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
                <button type="submit" name="submit_delete_user" value="1" class="btn btn-danger py-2 px-4" id="confirmDeleteBtn">
                  <strong><i class="fa fa-trash mr-1" aria-hidden="true"></i>Hapus</strong>
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL TAMBAH DATA PENGGUNA ADMIN                                                            -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalAddPenggunaAdmin" tabindex="-1" role="dialog" aria-labelledby="modalAddPenggunaAdminLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">


            <!-- ==================================== HEADER =================================== -->
            <div class="modal-header bg-success text-white text-center">

              <!-- Judul modal -->
              <h5 class="modal-title select-none" id="modalAddPenggunaAdminLabel">
                <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>
                <span>Tambah Akun Admin</span>
              </h5>

              <!-- Tombol tutup modal -->
              <button type="button" class="close select-none" onclick="$('#modalAddPenggunaAdmin').modal('hide')">&times;</button>

            </div>


            <!-- ===================================== BODY ==================================== -->
            <div class="modal-body px-4 mt-2">

              <!-- Form tambah data pengguna (Admin) -->
              <form method="post" id="formAddPenggunaAdmin">

                <!-- Data tersembunyi -->
                <input type="hidden" name="kategori" value="admin">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4 col-left mt-2">

                    <!-- Foto -->
                    <div class="border rounded bg-light" style="height: 202px;">
                      <img id="previewFotoAddAdmin"
                          class="img-fluid p-2 rounded select-none"
                          style="max-height: 202px; object-fit: cover; width: 100%;">
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group form-upload-file">
                      <label class="select-none"><strong>Upload Foto</strong></label>
                      <input type="file" class="select-none" id="fileInputAddAdmin" name="add-foto" accept="image/*" onchange="updateFileName(this); previewImage(this);" style="display:none;">
                      <div class="file-input-custom select-none" onclick="document.getElementById('fileInputAddAdmin').click()">
                        <button type="button" class="btn-choose text-center align-middle">
                          <span>Pilih Berkas</span>
                        </button>
                        <span id="file-name-add-admin">Belum ada berkas</span>
                      </div>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4 col-center">

                    <!-- Username -->
                    <div class="form-group">
                      <label class="select-none"><strong>Username</strong></label>
                      <input type="text" class="form-control select-none" placeholder="Masukkan username" name="add-username" autocomplete="username" required
                      oninput="this.value = this.value.replace(/[^a-z0-9]/gi, '').toLowerCase(); if(this.value.length > 20) this.value = this.value.slice(0, 20)">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea class="form-control select-none" placeholder="Masukkan nama lengkap" name="add-name" rows="4" autocomplete="name" required
                      oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                      </textarea>
                    </div>

                    <!-- Email -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Email</strong></label>
                      <input type="email" class="form-control select-none" placeholder="Masukkan email aktif" name="add-email" autocomplete="email" required oninput="filterEmail(this)">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4 col-right">

                    <!-- Password -->
                    <div class="form-group position-relative">
                      <label class="select-none"><strong>Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Masukkan password" name="add-password" id="add-password-admin" autocomplete="new-password" required>
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('add-password-admin', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group position-relative form-konfirmasi-password">
                      <label class="select-none"><strong>Konfirmasi Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Ulangi password" name="add-confirm-password" id="add-confirm-password-admin" autocomplete="new-confirm-password" required>
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('add-confirm-password-admin', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Captcha -->
                    <div class="form-group form-verifikasi-captcha">
                      <label class="select-none"><strong>Verifikasi Captcha</strong></label>
                      <div class="d-flex align-items-center">
                        <img id="captchaAddPenggunaAdmin" class="select-none"
                          data-base="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=add_user_admin"
                          src="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=add_user_admin&<?= time() ?>"
                          alt="Captcha">
                        <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaAddPenggunaAdmin')">
                          <i class="fas fa-sync" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div class="align-items-center mt-3">
                        <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                        oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                      </div>
                    </div>

                  </div>
                </div>


                <!-- ==================================== FOOTER =================================== -->
                <div class="modal-footer pb-0 pr-0 mt-3">

                  <!-- Tombol batal -->
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                  </button>

                  <!-- Tombol submit -->
                  <button type="submit" name="submit_add_user" class="btn btn-success">
                    <strong><i class="fa fa-save mr-1" aria-hidden="true"></i>Simpan</strong>
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL UBAH DATA PENGGUNA ADMIN                                                              -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalEditPenggunaAdmin" tabindex="-1" role="dialog" aria-labelledby="modalEditPenggunaAdminLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran besar, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">


            <!-- ==================================== HEADER =================================== -->
            <div class="modal-header bg-warning-custom text-white text-center">

              <!-- Judul modal -->
              <h5 class="modal-title select-none" id="modalEditPenggunaAdminLabel">
                <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>
                <span>Edit Akun Admin</span>
              </h5>

              <!-- Tombol tutup modal -->
              <button type="button" class="close select-none" onclick="$('#modalEditPenggunaAdmin').modal('hide')">&times;</button>

            </div>


            <!-- ===================================== BODY ==================================== -->
            <div class="modal-body px-4 mt-2">

              <!-- Form ubah data pengguna (Admin) -->
              <form method="post" id="formEditPenggunaAdmin">

                <!-- Data tersembunyi -->
                <input type="hidden" name="kategori" value="admin">
                <input type="hidden" name="edit-email-lama" id="edit-email-lama">

                <!-- Baris untuk mengatur tata letak tampilan -->
                <div class="row">

                  <!-- ==================================== KOLOM 1 ================================== -->
                  <div class="col-md-4 col-left mt-2">

                    <!-- Foto -->
                    <div class="border rounded bg-light" style="height: 202px;">
                      <img id="previewFotoEditAdmin"
                          class="img-fluid p-2 rounded select-none"
                          style="max-height: 202px; object-fit: cover; width: 100%;">
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group form-upload-file">
                      <label class="select-none"><strong>Upload Foto</strong></label>
                      <input type="file" class="select-none" id="fileInputEditAdmin" name="edit-foto" accept="image/*" onchange="updateFileName(this); previewImage(this);" style="display:none;">
                      <div class="file-input-custom select-none" onclick="document.getElementById('fileInputEditAdmin').click()">
                        <button type="button" class="btn-choose text-center align-middle">
                          <span>Ganti Foto</span>
                        </button>
                        <span id="file-name-edit-admin">Belum ada berkas</span>
                      </div>
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 2 ================================== -->
                  <div class="col-md-4 col-center">

                    <!-- Username -->
                    <div class="form-group">
                      <label class="select-none"><strong>Username</strong></label>
                      <input type="text" class="form-control select-none" placeholder="Ubah username" name="edit-username" autocomplete="username" required
                      oninput="this.value = this.value.replace(/[^a-z0-9]/gi, '').toLowerCase(); if(this.value.length > 20) this.value = this.value.slice(0, 20)">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Nama Lengkap</strong></label>
                      <textarea class="form-control select-none" placeholder="Ubah nama lengkap" name="edit-name" rows="4" autocomplete="name" required
                      oninput="this.value = this.value.replace(/\b\w/g, char => char.toUpperCase()); if(this.value.length > 60) this.value = this.value.slice(0, 60)"></textarea>
                      </textarea>
                    </div>

                    <!-- Email -->
                    <div class="form-group mt-2">
                      <label class="select-none"><strong>Email</strong></label>
                      <input type="email" class="form-control select-none" placeholder="Ubah email" name="edit-email" autocomplete="email" required oninput="filterEmail(this)">
                    </div>
                  </div>


                  <!-- ==================================== KOLOM 3 ================================== -->
                  <div class="col-md-4 col-right">

                    <!-- Password -->
                    <div class="form-group position-relative">
                      <label class="select-none"><strong>Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Isi untuk ubah password" name="edit-password" id="edit-password-admin" autocomplete="new-password">
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('edit-password-admin', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group position-relative form-konfirmasi-password">
                      <label class="select-none"><strong>Konfirmasi Password</strong></label>
                      <div class="input-group">
                        <input type="password" class="form-control select-none" placeholder="Ulangi password diatas" name="edit-confirm-password" id="edit-confirm-password-admin" autocomplete="new-confirm-password">
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword('edit-confirm-password-admin', this)">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Captcha -->
                    <div class="form-group form-verifikasi-captcha">
                      <label class="select-none"><strong>Verifikasi Captcha</strong></label>
                      <div class="d-flex align-items-center">
                        <img id="captchaEditPenggunaAdmin" class="select-none"
                          data-base="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=edit_user_admin"
                          src="<?= BASE_URL ?>components/features/auth/security/captcha_generate.php?id=edit_user_admin&<?= time() ?>"
                          alt="Captcha">
                        <button type="button" class="btn btn-outline-primary" onclick="reloadCaptcha('captchaEditPenggunaAdmin')">
                          <i class="fas fa-sync" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div class="align-items-center mt-3">
                        <input type="text" class="form-control input-captcha select-none" placeholder="Masukkan kode captcha" name="kode" required
                        oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5)">
                      </div>
                    </div>

                  </div>
                </div>


                <!-- ==================================== FOOTER =================================== -->
                <div class="modal-footer pb-0 pr-0 mt-3">

                  <!-- Tombol batal -->
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Batal</strong>
                  </button>

                  <!-- Tombol submit -->
                  <button type="submit" name="submit_edit_user" class="btn btn-warning-custom text-white">
                    <strong><i class="fa fa-save mr-1" aria-hidden="true"></i>Simpan</strong>
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



      <!-- =========================================================================================== -->
      <!-- MODAL HAPUS DATA PENGGUNA ADMIN                                                             -->
      <!-- =========================================================================================== -->
      <div class="modal fade" id="modalDeletePenggunaAdmin" tabindex="-1" role="dialog" aria-labelledby="modalDeletePenggunaAdminLabel" aria-hidden="true">

        <!-- Dialog modal (ukuran standard, berada di tengah & bisa di scroll) -->
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content border-0 shadow-lg">

            <!-- Form hapus data pengguna (Admin) -->
            <form method="POST" id="formDeletePenggunaAdmin">

              <!-- Data tersembunyi -->
              <input type="hidden" name="kategori" value="admin">
              <input type="hidden" name="submit_delete_user" value="1">
              <input type="hidden" name="delete-email" id="delete_email">


              <!-- ==================================== HEADER =================================== -->
              <div class="modal-header bg-danger text-white">

                <!-- Judul modal -->
                <h5 class="modal-title select-none" id="modalDeletePenggunaAdminLabel">
                  <i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                  <span>Konfirmasi Hapus Admin</span>
                </h5>

                <!-- Tombol tutup modal -->
                <button type="button" class="close select-none" onclick="$('#modalDeletePenggunaAdmin').modal('hide')">&times;</button>

              </div>


              <!-- ===================================== BODY ==================================== -->
              <div class="modal-body text-center select-none">

                <!-- Tampilan data admin yang akan dihapus -->
                <p class="text-danger font-weight-bold my-4">
                  <span id="delete_show_nama"></span>
                  <span id="delete_show_email"></span>
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
                <button type="submit" name="submit_delete_user" value="1" class="btn btn-danger py-2 px-4" id="confirmDeleteBtn">
                  <strong><i class="fa fa-trash mr-1" aria-hidden="true"></i>Hapus</strong>
                </button>
              </div>

            </form>
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
  <?php endif; ?>