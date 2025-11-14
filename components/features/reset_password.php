<?php
session_start();
require_once __DIR__ . '/../../config/config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $token = $_POST['token'];
    $password = $_POST['reset-password'];
    $password_confirm = $_POST['reset-confirm-password'];

    if($password !== $password_confirm){
        header("Location: " . BASE_URL . "index.php?pesan=password_tidak_sesuai&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
        exit;
    }

    // cek token
    $res = mysqli_query($koneksi, "SELECT * FROM password_resets WHERE email='$email' AND token='$token'");
    if(mysqli_num_rows($res) === 0){
        header("Location: " . BASE_URL . "index.php?pesan=token_invalid&modal=reset_password");
        exit;
    }

    // Cek apakah password baru sama dengan password lama
    $cek_user = mysqli_query($koneksi, "SELECT password FROM akun_pasien WHERE email='$email'");
    if(mysqli_num_rows($cek_user) > 0){
        $data_user = mysqli_fetch_assoc($cek_user);
        if(password_verify($password, $data_user['password'])){
            // Jika password baru sama dengan password lama
            header("Location: " . BASE_URL . "index.php?pesan=password_sudah_ada&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit;
        }
    }

    // update password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($koneksi, "UPDATE akun_pasien SET password='$password_hash' WHERE email='$email'");

    // hapus token
    mysqli_query($koneksi, "DELETE FROM password_resets WHERE email='$email'");

    header("Location: " . BASE_URL . "index.php?pesan=reset_sukses");
    exit;
}

?>