<?php
session_start();
include __DIR__ . '/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = strtolower(preg_replace('/[^a-z0-9]/i', '', $_POST['register-username']));
    $name = ucwords(strtolower(trim($_POST['register-name'])));
    $email = strtolower(trim($_POST['register-email']));
    $password = $_POST['register-password'];
    $confirm_password = $_POST['register-confirm-password'];
    $captcha_input = trim($_POST['kode']);
    $captcha_id = 'registrasi_pasien';

    // --- Validasi captcha ---
    if (empty($_SESSION["captcha_" . $captcha_id]) || strcasecmp($captcha_input, $_SESSION["captcha_" . $captcha_id]) !== 0) {
        unset($_SESSION["captcha_" . $captcha_id]);
        header("Location: " . BASE_URL . "index.php?pesan=gagal&modal=registration");
        exit;
    }
    unset($_SESSION["captcha_" . $captcha_id]);

    // --- Validasi password ---
    if ($password !== $confirm_password) {
        header("Location: " . BASE_URL . "index.php?pesan=password_tidak_sesuai&modal=registration");
        exit;
    }
    if (strlen($password) < 8) {
        header("Location: " . BASE_URL . "index.php?pesan=password_singkat&modal=registration");
        exit;
    }
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        header("Location: " . BASE_URL . "index.php?pesan=password_lemah&modal=registration");
        exit;
    }

    // --- Cek username/email unik ---
    $stmt = $koneksi->prepare("SELECT username, email FROM akun_pasien WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_username, $db_email);

    $username_exists = false;
    $email_exists = false;

    while ($stmt->fetch()) {
        if ($db_username === $username) $username_exists = true;
        if ($db_email === $email) $email_exists = true;
    }

    $stmt->close();

    if ($email_exists) {
        header("Location: " . BASE_URL . "index.php?pesan=email_terdaftar&modal=registration");
        exit;
    }

    if ($username_exists) {
        header("Location: " . BASE_URL . "index.php?pesan=username_terdaftar&modal=registration");
        exit;
    }

    // --- Hash password ---
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // --- Insert ke DB ---
    $role_id = 3; // role pasien
    $stmt = $koneksi->prepare("INSERT INTO akun_pasien (email, nama, username, password, role_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $email, $name, $username, $password_hash, $role_id);

    if ($stmt->execute()) {
        $stmt->close();
        $koneksi->close();
        // Registrasi sukses -> redirect ke modal login pasien
        header("Location: " . BASE_URL . "index.php?pesan=registration_sukses&modal=pasien");
        exit;
    } else {
        $error = urlencode($stmt->error);
        $stmt->close();
        $koneksi->close();
        header("Location: " . BASE_URL . "index.php?pesan=error&modal=registration&error=$error");
        exit;
    }
}
?>