<?php

    // ===========================================================================================
    // KONEKSI & AKSES BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/../../../../config/config.php';


    // ===========================================================================================
    // LOAD LIBRARY PHPMailer
    // ===========================================================================================
    // Memanggil autoload Composer untuk mengakses library eksternal
    require_once __DIR__ . '/../../../../vendor/autoload.php';

    // Menggunakan namespace PHPMailer agar class bisa dipanggil langsung
    use PHPMailer\PHPMailer\PHPMailer;


    // ===========================================================================================
    // PROSES HANYA DIJALANKAN JIKA REQUEST = POST
    // ===========================================================================================
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        /* =================================== INPUT DATA ================================ */
        // Mengambil input email dari form dan mengamankannya dari SQL Injection
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);


        /* =================================== CEK EMAIL ================================= */
        // Mengecek apakah email yang dimasukkan terdaftar di tabel akun_pasien
        $query = mysqli_query($koneksi, "SELECT * FROM akun_pasien WHERE email='$email'");

        // Jika email tidak ditemukan, maka :
        if (mysqli_num_rows($query) == 0) {

            // Redirect ke modal forgot password
            // Hal ini disertai dengan pesan = Email tidak ditemukan!
            header("Location: " . BASE_URL . "index.php?pesan=email_salah&modal=forgot_password");
            exit; // Menghentikan eksekusi script
        }


        /* ================================= GENERATE TOKEN ============================== */
        // Membuat token reset password secara acak
        $token = bin2hex(random_bytes(32));

        // Simpan token ke database
        mysqli_query($koneksi, "REPLACE INTO password_resets(email, token, created_at) VALUES('$email', '$token', NOW())");


        /* =============== KONFIGURASI & PENGIRIMAN EMAIL MENGGUNAKAN PHPMailer ========== */
        $mail = new PHPMailer(); // Membuat objek baru dari class PHPMailer

        // Menggunakan SMTP sebagai metode pengiriman email
        $mail->isSMTP();

        $mail->Host       = 'smtp.gmail.com';                   // Server SMTP Gmail
        $mail->SMTPAuth   = true;                               // Mengaktifkan autentikasi SMTP
        $mail->Username   = 'wtechnoid@gmail.com';              // Email pengirim
        $mail->Password   = 'unftesuqxtcpsvsh';                 // App Password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enkripsi TLS
        $mail->Port       = 587;                                // Port SMTP Gmail

        $mail->setFrom('from@example.com', 'SIAKLIK');          // Mengatur email pengirim
        $mail->addAddress($email, 'User');                      // Mengatur email penerima

        $mail->isHTML(true);                                    // Mengatur format email menjadi HTML
        $mail->Subject = 'Reset Password SIAKLIK';              // Subjek email

        // Membuat link reset password yang berisi email dan token
        $resetLink = BASE_URL . "?email=$email&token=$token";

        // Isi email reset password
        $mail->Body = "
            <h4>Reset Password</h4>
            <p>Klik link berikut untuk mereset password Anda:</p>
            <a href='$resetLink'>$resetLink</a>
            <p>Jika tidak meminta reset, abaikan email ini.</p>
        ";


        /* ============================= PROSES PENGIRIMAN EMAIL ========================= */
        if ($mail->send()) { // Jika email berhasil dikirim, maka :

            // Redirect ke halaman beranda
            // Hal ini disertai dengan pesan = Link reset password dikirim!
            header("Location: " . BASE_URL . "index.php?pesan=reset_terkirim");
            exit; // Menghentikan eksekusi script

        } else { // Jika email gagal dikirim, maka :

            // Redirect ke modal forgot password
            // Hal ini disertai dengan pesan = Gagal mengirim email!
            header("Location: " . BASE_URL . "index.php?pesan=gagal_email&modal=forgot_password");
            exit; // Menghentikan eksekusi script
        }

        // Redirect default (fallback) itu ke halaman beranda
        header("Location: " . BASE_URL);
        exit; // Menghentikan eksekusi script
    }

?>