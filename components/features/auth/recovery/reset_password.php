<?php

    // ===========================================================================================
    // KONEKSI & AKSES BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/../../../../config/config.php';


    // ===========================================================================================
    // PROSES HANYA DIJALANKAN JIKA REQUEST = POST
    // ===========================================================================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /* =================================== INPUT DATA ================================ */
        // Mengambil email dari hidden input form
        $email = $_POST['email'];

        // Mengamankan email dari SQL Injection
        $email = mysqli_real_escape_string($koneksi, $email);

        // Mengambil token dari hidden input form
        $token = $_POST['token'];

        // Mengambil password baru dari form
        $password = $_POST['reset-password'];

        // Mengambil konfirmasi password baru dari form
        $confirm_password = $_POST['reset-confirm-password'];


        /* =================================== CEK TOKEN ================================= */
        // Query ini digunakan untuk mengecek email dan token yang ada di tabel password_resets
        $stmt = $koneksi->prepare("
            SELECT email FROM password_resets 
            WHERE email = ? AND token = ?
            LIMIT 1
        ");

        $stmt->bind_param("ss", $email, $token);  // Mengikat parameter email dan token ke query
        $stmt->execute();                         // Menjalankan query
        $stmt->store_result();                    // Menyimpan hasil query
        $stmt->bind_result($db_email);            // Mengikat hasil query ke variabel
        $stmt->fetch();                           // Mengambil data hasil query
        $stmt->close();                           // Menutup statement

        // Jika token tidak ditemukan atau tidak valid
        if (!$db_email) {

            // Redirect ke modal reset password
            // Hal ini disertai dengan pesan = Token invalid atau kadaluarsa!
            header("Location: " . BASE_URL . "index.php?pesan=token_invalid&modal=reset_password");
            exit; // Menghentikan eksekusi script
        }


        /* =============================== VALIDASI PASSWORD ============================= */
        // Jika password dan konfirmasinya tidak sama, maka :
        if ($password !== $confirm_password) {

            // Redirect ke modal reset password
            // Hal ini disertai dengan pesan = Password tidak sesuai!
            header("Location: " . BASE_URL . "index.php?pesan=password_tidak_sesuai&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit; // Menghentikan eksekusi script
        }

        // Jika panjang minimal password kurang dari 8 karakter, maka :
        if (strlen($password) < 8) {

            // Redirect ke modal reset password
            // Hal ini disertai dengan pesan = Password terlalu singkat!
            header("Location: " . BASE_URL . "index.php?pesan=password_singkat&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit; // Menghentikan eksekusi script
        }

        // Jika password tidak ada karakter spesial yang dipakai, maka :
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {

            // Redirect ke modal reset password
            // Hal ini disertai dengan pesan = Password kurang kuat!
            header("Location: " . BASE_URL . "index.php?pesan=password_lemah&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit; // Menghentikan eksekusi script
        }


        /* =============================== CEK PASSWORD LAMA ============================= */
        // Query ini digunakan untuk mengambil password lama user
        $stmt = $koneksi->prepare("
            SELECT password FROM akun_pasien 
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $email);           // Mengikat parameter email ke query
        $stmt->execute();                         // Menjalankan query
        $stmt->store_result();                    // Menyimpan hasil query
        $stmt->bind_result($password_lama);       // Mengikat hasil query ke variabel
        $stmt->fetch();                           // Mengambil data hasil query
        $stmt->close();                           // Menutup statement

        // Jika password lama ada dan password baru sama dengan password lama, maka :
        if ($password_lama && password_verify($password, $password_lama)) {

            // Redirect ke modal reset password
            // Hal ini disertai dengan pesan = Password sudah terpakai!
            header("Location: " . BASE_URL . "index.php?pesan=password_sudah_ada&modal=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit; // Menghentikan eksekusi script
        }


        /* ================================ UPDATE PASSWORD ============================== */
        // Hash password baru menggunakan algoritma BCRYPT
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Query ini digunakan untuk update password user
        $stmt = $koneksi->prepare("
            UPDATE akun_pasien 
            SET password = ? 
            WHERE email = ?
        ");

        // Mengikat parameter password hash dan email ke query
        $stmt->bind_param("ss", $password_hash, $email);

        // Menjalankan query update password
        if (!$stmt->execute()) {

            // Menyimpan pesan error sebelum koneksi ditutup
            $error_message = $koneksi->error;

            // Menutup statement
            $stmt->close();

            // Menutup koneksi database
            $koneksi->close();

            // Menghentikan script dan menampilkan error SQL
            die("SQL Error saat update password: " . $error_message);
        }

        // Menutup statement jika query berhasil
        $stmt->close();


        /* ================================== HAPUS TOKEN ================================ */
        // Query ini digunakan untuk menghapus token reset password
        $stmt = $koneksi->prepare("
            DELETE FROM password_resets 
            WHERE email = ?
        ");

        $stmt->bind_param("s", $email);           // Mengikat parameter email ke query
        $stmt->execute();                         // Menjalankan query
        $stmt->close();                           // Menutup statement
        $koneksi->close();                        // Menutup koneksi database


        /* ================================= REDIRECT MODAL ============================== */
        // Redirect ke modal login pasien
        // Hal ini disertai dengan pesan = Password berhasil direset!
        header("Location: " . BASE_URL . "index.php?pesan=reset_sukses");
        exit; // Menghentikan eksekusi script
    }

?>