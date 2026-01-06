<?php

session_start();
include __DIR__ . '/../../../../config/config.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // cek email di DB
    $query = mysqli_query($koneksi, "SELECT * FROM akun_pasien WHERE email='$email'");
    if (mysqli_num_rows($query) == 0) {
        header("Location: " . BASE_URL . "index.php?pesan=email_salah&modal=forgot_password");
        exit;
    }

    // buat token
    $token = bin2hex(random_bytes(32));

    // simpan token di DB
    mysqli_query($koneksi, "REPLACE INTO password_resets(email, token, created_at) VALUES('$email', '$token', NOW())");

    // kirim email pakai PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'wtechnoid@gmail.com';
    $mail->Password   = 'unftesuqxtcpsvsh';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('from@example.com', 'SIAKLIK');
    $mail->addAddress($email, 'User');

    $mail->isHTML(true);
    $mail->Subject = 'Reset Password SIAKLIK';
    $resetLink = BASE_URL . "?email=$email&token=$token";
    $mail->Body = "
        <h4>Reset Password</h4>
        <p>Klik link berikut untuk mereset password Anda:</p>
        <a href='$resetLink'>$resetLink</a>
        <p>Jika tidak meminta reset, abaikan email ini.</p>
    ";

    if ($mail->send()) {
        header("Location: " . BASE_URL . "index.php?pesan=reset_terkirim");
        exit;
    } else {
        header("Location: " . BASE_URL . "index.php?pesan=gagal_email&modal=forgot_password");
        exit;
    }

    header("Location: " . BASE_URL);
    exit;
}

?>