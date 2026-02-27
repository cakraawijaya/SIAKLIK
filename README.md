[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?style=flat)](https://github.com/ellerbrock/open-source-badges/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?logo=github&color=%23F7DF1E)](https://opensource.org/licenses/MIT)
![GitHub last commit](https://img.shields.io/github/last-commit/cakraawijaya/SIAKLIK?logo=Codeforces&logoColor=white&color=%23F7DF1E)
![Project](https://img.shields.io/badge/Project-Website-light.svg?style=flat&logo=googlechrome&logoColor=white&color=%23F7DF1E)
![Type](https://img.shields.io/badge/Type-Internship-light.svg?style=flat&logo=gitbook&logoColor=white&color=%23F7DF1E)

# SIAKLIK
We have carried out this internship program for approximately six months on a hybrid basis from August 2020 to January 2021. During our internship, we managed to update the website system of Poliklinik UPN Veteran East Java. This update was carried out as an effort to fulfill the requirements for graduation from the undergraduate level. The developed website has been adjusted to the phenomena in the field. To find out the extent of the quality of this website, a validation test is needed, which we did using the Blackbox Testing method.

<br><br>

## Project Requirements
| Part | Description |
| --- | --- |
| Features | • Login<br>• Register<br>• Queue<br>• Export<br>• Chart<br>• Pagination<br>• Search<br>• Create<br>• Read<br>• Update<br>• Delete<br>• Captcha<br>• Access Rights<br>• ETC |
| Framework | Bootstrap 4 |
| Web Libraries | • jQuery<br>• Font-Awesome<br>• Dompdf<br>• PHPMailer<br>• Malihu<br>• VanillaTop<br>• SweetAlert2<br>• Highcharts |
| Tools | • Visual Studio Code<br>• Xampp<br>• Composer |

<br><br>

## Download & Install
1. XAMPP with PHP version 7.4

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

## Database
1. Open ``` XAMPP ```, then start the ``` Apache ``` & ``` MySQL ``` section. This aims to be able to support the website optimally.<br><br>
   
2. Access the ``` browser ``` first in order to open the database admin panel, please copy the following link: ``` localhost/phpmyadmin/ ```.<br><br>
 
3. Create a database called ``` siaklik_db ``` on local.<br><br>

4. Open the ``` siaklik_db ``` database and Import ``` siaklik_db.sql ``` in the ``` SIAKLIK/public/assets/database ``` directory.<br><br>

5. Then open the XAMP file: ``` php.ini ``` -> remove ``` semicolon (;) ``` in front of ``` extension=gd ``` -> save.<br><br>

6. Then open the XAMP file: ``` my.ini ``` -> add ``` event_scheduler=ON ``` under ``` [mysqld] ``` -> restart MySQL.<br><br>

7. Check the Event Scheduler status at ``` localhost/phpmyadmin/ ``` with the following command:

   <table><tr><td width="810">
      
      ```sql
         SHOW VARIABLES LIKE 'event_scheduler';
      ```
   </td></tr></table><br>

8. If it is active (ON), then it has been successful. If not, set it like this:

   <table><tr><td width="810">
      
      ```sql
         SET GLOBAL event_scheduler = ON;
      ```
   </td></tr></table>

<br><br>

## Default Account
| Role | Email | Password |
| --- | --- | --- |
| Admin | admin1@poliklinik.upnvjatim.ac.id | admin123! |
| Pekerja | pekerja1@poliklinik.upnvjatim.ac.id | pekerja123! |
| Pasien | pasien1@gmail.com | pasien123! |

<br><br>

## Get Started
1. Download this repository.<br><br>

2. Extract the downloaded file.<br><br>

3. Move the ``` SIAKLIK ``` directory into the ``` htdocs ``` directory, whose details you can find out as follows: ``` C:\xampp\htdocs ```.<br><br>

4. Then, to ensure that all ``` dependencies (libraries/plugins) ``` in the SIAKLIK project do not cause errors, do the following:

   <table><tr><td width="810">
      
      ```bash
         composer install
      ```
   </td></tr></table><br>
   
5. Please open your ``` browser ``` by writing: ``` localhost/SIAKLIK/ ```.<br><br>
   
6. Please login and access the features, enjoy [Done].

<br><br>

## Internship Team Members
| NUMBER | FULL NAME | NPM | ROLE |
| --- | --- | --- | --- |
| 1 | Heri Khariono | 18081010002 | Frontend |
| 2 | Devan Cakra Mudra Wijaya | 18081010013 | Frontend |
| 3 | Haidar Ananta Kusuma | 18081010057 | Backend |
| 4 | Rifky Akhmad Fernanda | 18081010126 | Fullstack |

<br><br>

## Highlights
<table>
<tr>
<th width="840">Home</th>
</tr>
<tr>
<td><img src="documentation/pages/beranda.jpg" alt="home"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Statistics</th>
</tr>
<tr>
<th width="210">Options</th>
<th width="210">Gender</th>
<th width="210">2013</th>
<th width="210">2014</th>
</tr>
<tr>
<td><img src="documentation/pages/guest/statistics/grafik_kunjungan.jpg" alt="options"></td>
<td><img src="documentation/pages/guest/statistics/gender.jpg" alt="gender"></td>
<td><img src="documentation/pages/guest/statistics/2013.jpg" alt="2013"></td>
<td><img src="documentation/pages/guest/statistics/2014.jpg" alt="2014"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="2" width="840">Queue</th>
</tr>
<tr>
<th width="420">Registration</th>
<th width="420">Status</th>
</tr>
<tr>
<td><img src="documentation/pages/general/queue/registrasi_antrean.jpg" alt="queue-registration"></td>
<td><img src="documentation/pages/general/queue/status_antrean.jpg" alt="queue-status"></td>
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
<th colspan="4" width="840">Management</th>
</tr>
<tr>
<th width="210">Activity Log</th>
<th width="210">User</th>
<th width="210">Patient</th>
<th width="210">Queue</th>
</tr>
<tr>
<td><img src="documentation/pages/management/logs.jpg" alt="activity-log-management"></td>
<td><img src="documentation/pages/management/users.jpg" alt="user-management"></td>
<td><img src="documentation/pages/management/patients.jpg" alt="patient-management"></td>
<td><img src="documentation/pages/management/queues.jpg" alt="queue-management"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Export PDF</th>
</tr>
<tr>
<th width="210">Patient History</th>
<th width="210">Admin</th>
<th width="210">Worker</th>
<th width="210">Patient</th>
</tr>
<tr>
<td><img src="documentation/features/export/riwayat_pasien.jpg" alt="export-patient-history"></td>
<td><img src="documentation/features/export/user_admin.jpg" alt="export-admin-account"></td>
<td><img src="documentation/features/export/user_pekerja.jpg" alt="export-worker-account"></td>
<td><img src="documentation/features/export/user_pasien.jpg" alt="export-patient-account"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Modal</th>
</tr>
<tr>
<th width="210">Login</th>
<th width="210">Edit Account</th>
<th width="210">Forgot Password</th>
<th width="210">Queue Action Confirmation</th>
</tr>
<tr>
<td><img src="documentation/features/modal_menu/login/admin.jpg" alt="login"></td>
<td><img src="documentation/features/modal_menu/manajemen_user/admin/edit_akun.jpg" alt="edit-account"></td>
<td><img src="documentation/features/modal_menu/lupa_password_pasien.jpg" alt="forgot-password"></td>
<td><img src="documentation/features/modal_menu/antrean_pasien/konfirmasi_aksi_selesai.jpg" alt="queue-action-confirmation"></td>
</tr>
</table>
<br>
<table>
<tr>
<th colspan="4" width="840">Alert</th>
</tr>
<tr>
<th width="210">Timeout</th>
<th width="210">Password Reset Sent</th>
<th width="210">Photo Oversized</th>
<th width="210">Invalid Token</th>
</tr>
<tr>
<td><img src="documentation/features/alert/success/user_timeout.jpg" alt="timeout"></td>
<td><img src="documentation/features/alert/success/reset_terkirim.jpg" alt="password-sent"></td>
<td><img src="documentation/features/alert/failure/foto_over_size.jpg" alt="photo-oversized"></td>
<td><img src="documentation/features/alert/failure/token_kadaluarsa.jpg" alt="invalid-token"></td>
</table>
<br>
<table>
<tr>
<th colspan="2" width="840">Error</th>
</tr>
<tr>
<th width="420">Page</th>
<th width="420">Database</th>
</tr>
<tr>
<td><img src="documentation/pages/system/error/page_not_found.jpg" alt="page-not-found"></td>
<td><img src="documentation/pages/system/error/unknown_database.jpg" alt="unknown-database"></td>
</tr>
</table>
<br>
Explore the full documentation <u><a href="https://github.com/cakraawijaya/SIAKLIK/tree/master/documentation">here</a></u>

<br><br>

## Reminder
If you want to reset the auto-increment on the riwayat_antrean / riwayat aktivitas table, simply change the table_name via phpMyAdmin. Here's how:

   <table><tr><td width="810">
      
   ```sql
      SET @num := 0;
      UPDATE table_name SET id = @num := (@num+1);
      ALTER TABLE table_name AUTO_INCREMENT =1;
   ```
   </td></tr></table>

<br><br>

## Appreciation
If this work is useful to you, then support this work as a form of appreciation to the author by clicking the ``` ⭐Star ``` button at the top of the repository.

<br><br>

## Disclaimer
This application is the result of my work with my team and is not the result of plagiarism from other people's research or work, except those related to third party services which include: libraries, frameworks, and so on.

<br><br>

## LICENSE
MIT License - Copyright © 2021 - Devan C. M. Wijaya et al

Permission is hereby granted without charge to any person obtaining a copy of this software and the software-related documentation files to deal in them without restriction, including without limitation the right to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons receiving the Software to be furnished therewith on the following terms:

The above copyright notice and this permission notice must accompany all copies or substantial portions of the Software.

IN ANY EVENT, THE AUTHOR OR COPYRIGHT HOLDER HEREIN RETAINS FULL OWNERSHIP RIGHTS. THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, THEREFORE IF ANY DAMAGE, LOSS, OR OTHERWISE ARISES FROM THE USE OR OTHER DEALINGS IN THE SOFTWARE, THE AUTHOR OR COPYRIGHT HOLDER SHALL NOT BE LIABLE, AS THE USE OF THE SOFTWARE IS NOT COMPELLED AT ALL, SO THE RISK IS YOUR OWN.
