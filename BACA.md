[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?style=flat)](https://github.com/ellerbrock/open-source-badges/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?logo=github&color=%23F7DF1E)](https://opensource.org/licenses/MIT)
![GitHub last commit](https://img.shields.io/github/last-commit/cakraawijaya/SIAKLIK?logo=Codeforces&logoColor=white&color=%23F7DF1E)
![Project](https://img.shields.io/badge/Project-Website-light.svg?style=flat&logo=googlechrome&logoColor=white&color=%23F7DF1E)
![Type](https://img.shields.io/badge/Type-Internship-light.svg?style=flat&logo=gitbook&logoColor=white&color=%23F7DF1E)

# SIAKLIK
Program magang ini telah kami laksanakan selama kurang lebih enam bulan secara hybrid dari bulan Agustus 2020 hingga bulan Januari 2021. Selama magang, kami berhasil memperbarui sistem website Poliklinik UPN Veteran Jawa Timur. Pembaruan ini dilakukan sebagai upaya untuk memenuhi syarat kelulusan jenjang S1. Website yang dikembangkan telah disesuaikan dengan fenomena yang ada di lapangan. Untuk mengetahui sejauh mana kualitas website ini, diperlukan uji validasi, yang kami lakukan dengan metode Blackbox Testing.

<br><br>

## Kebutuhan Proyek
| Bagian | Deskripsi |
| --- | --- |
| Fitur | • Masuk<br>• Pendaftaran<br>• Antrian<br>• Ekspor<br>• Grafik<br>• Paginasi<br>• Pencarian<br>• Buat<br>• Baca<br>• Perbarui<br>• Hapus<br>• Captcha<br>• Hak Akses<br>• DLL |
| Kerangka Kerja | Bootstrap 4 |
| Pustaka Web | • jQuery<br>• Font-Awesome<br>• Dompdf<br>• PHPMailer<br>• Malihu<br>• VanillaTop<br>• SweetAlert2<br>• Highcharts |
| Peralatan | • Visual Studio Code<br>• Xampp<br>• Composer |

<br><br>

## Unduh & Instal
1. XAMPP dengan PHP versi 7.4

   <table><tr><td width="810">

   ```
   https://bit.ly/XAMPP_PHP7_Installer
   ```

   </td></tr></table><br>
   
2. Visual Studio Code

   <table><tr><td width="810">

   ```
   https://bit.ly/VScode_Installer
   ```

   </td></tr></table><br>
   
3. Composer

   <table><tr><td width="810">

   ```
   https://bit.ly/Composer_Installer
   ```

   </td></tr></table>

<br><br>

## Basis data
1. Buka ``` XAMPP ```, lalu tekan tombol mulai di bagian ``` Apache ``` & ``` MySQL ```. Hal ini bertujuan untuk dapat mendukung website secara optimal.<br><br>

2. Akses ``` peramban ``` terlebih dahulu untuk membuka panel admin basis data, silakan salin tautan berikut: ``` localhost/phpmyadmin/ ```.<br><br>
   
3. Buat basis data bernama ``` siaklik_db ``` di lokal.<br><br>
   
4. Buka basis data ``` siaklik_db ``` dan Impor ``` siaklik_db.sql ``` di direktori ``` SIAKLIK/public/assets/database ```.<br><br>

5. Kemudian buka berkas XAMP: ``` php.ini ``` -> hapus ``` titik koma (;) ``` di depan ``` extension=gd ``` -> simpan.<br><br>

6. Kemudian buka berkas XAMP: ``` my.ini ``` -> tambahkan ``` event_scheduler=ON ``` di bawah ``` [mysqld] ``` -> mulai ulang MySQL.<br><br>

7. Cek status Event Scheduler di ``` localhost/phpmyadmin/ ``` dengan perintah berikut :<br><br>

   <table><tr><td width="810">
      
      ```sql
         SHOW VARIABLES LIKE 'event_scheduler';
      ```
   </td></tr></table><br>

8. Kalau aktif (ON), maka sudah berhasil, jika belum atur seperti ini:<br><br>

   <table><tr><td width="810">
      
      ```sql
         SET GLOBAL event_scheduler = ON;
      ```
   </td></tr></table>

<br><br>

## Akun Bawaan
| Peran | Surel | Kata Sandi |
| --- | --- | --- |
| Admin | admin1@poliklinik.upnvjatim.ac.id | admin123! |
| Pekerja | pekerja1@poliklinik.upnvjatim.ac.id | pekerja123! |
| Pasien | pasien1@gmail.com | pasien123! |

<br><br>

## Memulai
1. Unduh repositori ini.<br><br>

2. Ekstrak file yang diunduh.<br><br>
   
3. Pindahkan direktori ``` SIAKLIK ``` ke dalam direktori ``` htdocs ```, yang rinciannya dapat anda lihat sebagai berikut: ``` C:\xampp\htdocs ```.<br><br>

4. Kemudian agar semua ``` dependensi (library/plugin) ``` yang ada di project SIAKLIK tidak error, maka lakukan:

   <table><tr><td width="810">
      
      ```bash
         composer install
      ```
   </td></tr></table><br>
   
5. Silakan buka ``` peramban ``` anda dengan menuliskan: ``` localhost/SIAKLIK/ ```.<br><br>
   
6. Silakan masuk dan akses fitur-fiturnya, selamat menikmati [Selesai].

<br><br>

## Anggota Tim Magang
| NOMOR | NAMA LENGKAP | NPM | PERAN |
| --- | --- | --- | --- |
| 1 | Heri Khariono | 18081010002 | Frontend |
| 2 | Devan Cakra Mudra Wijaya | 18081010013 | Frontend |
| 3 | Haidar Ananta Kusuma | 18081010057 | Backend |
| 4 | Rifky Akhmad Fernanda | 18081010126 | Fullstack |

<br><br>

## Sorotan
<table>
<tr>
<th width="840">Beranda</th>
</tr>
<tr>
<td><img src="documentation/pages/beranda.jpg" alt="beranda"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Statistik</th>
</tr>
<tr>
<th width="210">Pilihan</th>
<th width="210">Jenis Kelamin</th>
<th width="210">2013</th>
<th width="210">2014</th>
</tr>
<tr>
<td><img src="documentation/pages/guest/statistics/grafik_kunjungan.jpg" alt="pilihan"></td>
<td><img src="documentation/pages/guest/statistics/gender.jpg" alt="jenis-kelamin"></td>
<td><img src="documentation/pages/guest/statistics/2013.jpg" alt="2013"></td>
<td><img src="documentation/pages/guest/statistics/2014.jpg" alt="2014"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="2" width="840">Antrean</th>
</tr>
<tr>
<th width="420">Registrasi</th>
<th width="420">Status</th>
</tr>
<tr>
<td><img src="documentation/pages/general/queue/registrasi_antrean.jpg" alt="registrasi-antrean"></td>
<td><img src="documentation/pages/general/queue/status_antrean.jpg" alt="status-antrean"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="2" width="840">Dashboard</th>
</tr>
<tr>
<th width="420">Admin</th>
<th width="420">Worker</th>
</tr>
<tr>
<td><img src="documentation/pages/admin/dashboard.jpg" alt="dashboard-admin"></td>
<td><img src="documentation/pages/worker/dashboard.jpg" alt="dashboard-worker"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Manajemen</th>
</tr>
<tr>
<th width="210">Catatan</th>
<th width="210">Pengguna</th>
<th width="210">Riwayat Pasien</th>
<th width="210">Antrean</th>
</tr>
<tr>
<td><img src="documentation/pages/management/logs.jpg" alt="manajemen-catatan"></td>
<td><img src="documentation/pages/management/users.jpg" alt="manajemen-pengguna"></td>
<td><img src="documentation/pages/management/patients.jpg" alt="manajemen-riwayat-pasien"></td>
<td><img src="documentation/pages/management/queues.jpg" alt="manajemen-antrean"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Ekspor</th>
</tr>
<tr>
<th width="210">Riwayat Pasien</th>
<th width="210">Admin</th>
<th width="210">Pekerja</th>
<th width="210">Pasien</th>
</tr>
<tr>
<td><img src="documentation/features/export/riwayat_pasien.jpg" alt="riwayat-pasien"></td>
<td><img src="documentation/features/export/user_admin.jpg" alt="user-admin"></td>
<td><img src="documentation/features/export/user_pekerja.jpg" alt="user-pekerja"></td>
<td><img src="documentation/features/export/user_pasien.jpg" alt="user-pasien"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Modal</th>
</tr>
<tr>
<th width="210">Masuk</th>
<th width="210">Edit Akun</th>
<th width="210">Lupa Kata Sandi</th>
<th width="210">Konfirmasi Tindakan Antrean</th>
</tr>
<tr>
<td><img src="documentation/features/modal_menu/login/admin.jpg" alt="masuk-admin"></td>
<td><img src="documentation/features/modal_menu/manajemen_user/admin/edit_akun.jpg" alt="edit-akun"></td>
<td><img src="documentation/features/modal_menu/lupa_password_pasien.jpg" alt="lupa-kata-sandi"></td>
<td><img src="documentation/features/modal_menu/antrean_pasien/konfirmasi_aksi_selesai.jpg" alt="tindakan-antrean"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Peringatan</th>
</tr>
<tr>
<th width="210">Waktu Habis</th>
<th width="210">Reset Kata Sandi Terkirim</th>
<th width="210">Foto Berukuran Besar</th>
<th width="210">Token Tidak Valid</th>
</tr>
<tr>
<td><img src="documentation/features/alert/success/user_timeout.jpg" alt="waktu-habis"></td>
<td><img src="documentation/features/alert/success/reset_terkirim.jpg" alt="reset-kata-sandi-terkirim"></td>
<td><img src="documentation/features/alert/failure/foto_over_size.jpg" alt="foto-berukuran-besar"></td>
<td><img src="documentation/features/alert/failure/token_kadaluarsa.jpg" alt="token-tidak-valid"></td>
</table>
<br>
<table>
<tr>
<th colspan="2" width="840">Kesalahan</th>
</tr>
<tr>
<th width="420">Halaman</th>
<th width="420">Basis Data</th>
</tr>
<tr>
<td><img src="documentation/pages/system/error/page_not_found.jpg" alt="halaman-tidak-ditemukan"></td>
<td><img src="documentation/pages/system/error/unknown_database.jpg" alt="basis-data-tidak-diketahui"></td>
</tr>
</table>
<br>
Explore the full documentation <u><a href="https://github.com/cakraawijaya/SIAKLIK/tree/master/documentation">here</a></u>

<br><br>

## Pengingat
Jika ingin mengatur ulang auto-increment pada tabel riwayat_antrean / riwayat_aktivitas, cukup ubah nama_tabel melalui phpMyAdmin. Berikut caranya:

   <table><tr><td width="810">
      
   ```sql
      SET @num := 0;
      UPDATE nama_tabel SET id = @num := (@num+1);
      ALTER TABLE nama_tabel AUTO_INCREMENT =1;
   ```
   </td></tr></table>

<br><br>

## Apresiasi
Jika karya ini bermanfaat bagi anda, maka dukunglah karya ini sebagai bentuk apresiasi kepada penulis dengan mengklik tombol ``` ⭐Bintang ``` di bagian atas repositori.

<br><br>

## Penafian
Aplikasi ini merupakan hasil karya saya bersama tim saya dan bukan merupakan hasil plagiat dari penelitian atau karya orang lain, kecuali yang berkaitan dengan layanan pihak ketiga yang meliputi: pustaka, kerangka kerja, dan lain sebagainya.

<br><br>

## LISENSI 
LISENSI MIT - Hak Cipta © 2021 - Devan C. M. Wijaya dkk

Dengan ini diberikan izin tanpa biaya kepada siapa pun yang mendapatkan salinan perangkat lunak ini dan file dokumentasi terkait perangkat lunak untuk menggunakannya tanpa batasan, termasuk namun tidak terbatas pada hak untuk menggunakan, menyalin, memodifikasi, menggabungkan, mempublikasikan, mendistribusikan, mensublisensikan, dan/atau menjual salinan Perangkat Lunak ini, dan mengizinkan orang yang menerima Perangkat Lunak ini untuk dilengkapi dengan persyaratan berikut:

Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus menyertai semua salinan atau bagian penting dari Perangkat Lunak.

DALAM HAL APAPUN, PENULIS ATAU PEMEGANG HAK CIPTA DI SINI TETAP MEMILIKI HAK KEPEMILIKAN PENUH. PERANGKAT LUNAK INI DISEDIAKAN SEBAGAIMANA ADANYA, TANPA JAMINAN APAPUN, BAIK TERSURAT MAUPUN TERSIRAT, OLEH KARENA ITU JIKA TERJADI KERUSAKAN, KEHILANGAN, ATAU LAINNYA YANG TIMBUL DARI PENGGUNAAN ATAU URUSAN LAIN DALAM PERANGKAT LUNAK INI, PENULIS ATAU PEMEGANG HAK CIPTA TIDAK BERTANGGUNG JAWAB, KARENA PENGGUNAAN PERANGKAT LUNAK INI TIDAK DIPAKSAKAN SAMA SEKALI, SEHINGGA RISIKO ADALAH MILIK ANDA SENDIRI.
