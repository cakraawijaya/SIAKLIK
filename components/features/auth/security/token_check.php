<?php

    // ===========================================================================================
    // KONEKSI & AKSES BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/../../../../config/config.php';


    // ===========================================================================================
    // INPUT DATA
    // ===========================================================================================
    // Mengambil email dari URL lalu mengamankannya sebelum data dipakai dalam query database
    // Jika tidak ada data, maka diisi string kosong
    $email = isset($_GET['email']) ? mysqli_real_escape_string($koneksi, $_GET['email']) : '';

    // Mengambil token dari URL lalu mengamankannya sebelum data dipakai dalam query database
    // Jika tidak ada data, maka diisi string kosong
    $token = isset($_GET['token']) ? mysqli_real_escape_string($koneksi, $_GET['token']) : '';


    // ===========================================================================================
    // FLAG
    // ===========================================================================================
    // Variabel penanda untuk menentukan apakah modal reset password boleh ditampilkan
    // Default: tidak ditampilkan (false)
    $showModal = false;


    // ===========================================================================================
    // CEK TOKEN
    // ===========================================================================================
    // Jika email dan token ada, maka lakukan beberapa hal sebagai berikut :
    if (!empty($email) && !empty($token)) {

        // Query ini digunakan untuk memvalidasi token reset password
        // Berdasarkan kombinasi email dan token pada tabel password_resets
        $res = mysqli_query(
            $koneksi,
            "SELECT * FROM password_resets WHERE email='$email' AND token='$token'"
        );

        // Jika data ditemukan (berarti token valid), maka :
        if (mysqli_num_rows($res) > 0) {

            // Set variabel menjadi true, sehingga modal reset password dapat ditampilkan
            $showModal = true;

        } else { // Jika token tidak ditemukan atau sudah tidak valid, maka :

            // Redirect ke modal reset password
            // Hal ini disertai dengan pesan = Token invalid atau kadaluarsa!
            header("Location: " . BASE_URL . "index.php?pesan=token_invalid&modal=reset_password");
            exit; // Menghentikan eksekusi script
        }
    }

?>