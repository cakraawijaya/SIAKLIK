<?php

    // ===========================================================================================
    // CEK SESSION
    // ===========================================================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }


    // ===========================================================================================
    // KONEKSI & AKSES BASE_URL
    // ===========================================================================================
    require_once __DIR__ . '/../../../../config/config.php';


    // ===========================================================================================
    // FUNGSI FILTER EMAIL
    // ===========================================================================================
    function filter_email($raw_email) {

        // Mengubah seluruh karakter menjadi huruf kecil
        // Kemudian menghapus spasi di awal & akhir string
        $val = strtolower(trim($raw_email));

        // Menghapus semua karakter selain :
        // Huruf (a-z), Angka (0-9), Titik (.), dan Simbol @
        $val = preg_replace('/[^a-z0-9.@]/', '', $val);

        // Memecah string email berdasarkan karakter "@"
        $parts = explode('@', $val);

        // Jika terdapat lebih dari satu "@", maka :
        if (count($parts) > 2) {

            // Ambil bagian pertama sebagai local-part
            // Gabungkan sisanya tanpa "@"
            $val = $parts[0] . '@' . implode('', array_slice($parts, 1));
        }

        // Jika string email mengandung karakter "@",
        // Digunakan !== false agar posisi 0 tetap dianggap valid
        if (strpos($val, '@') !== false) {

            // Memisahkan local-part dan domain
            [$local, $domain] = explode('@', $val, 2);

            // Mengganti titik berturut-turut (..) menjadi satu titik (.)
            $local = preg_replace('/\.{2,}/', '.', $local);

            // Menghapus karakter selain huruf dan titik pada domain
            $domain = preg_replace('/[^a-z.]/', '', $domain);

            // Menggabungkan kembali local dan domain
            $val = $local . '@' . $domain;
        }

        // Jika panjang email lebih dari 45 karakter, maka :
        if (strlen($val) > 45) {
            $val = substr($val, 0, 45); // Potong email hingga maksimal 45 karakter
        }

        return $val; // Mengembalikan email yang sudah difilter
    }


    // ===========================================================================================
    // PROSES HANYA DIJALANKAN JIKA REQUEST = POST
    // ===========================================================================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /* =================================== INPUT DATA ================================ */
        // Mengambil data username dari form :
        // Menghapus karakter selain huruf & angka, lalu mengubah ke huruf kecil
        $username = strtolower(preg_replace('/[^a-z0-9]/i', '', $_POST['register-username']));

        // Mengambil data nama dari form :
        // Menghapus spasi berlebih, mengubah ke huruf kecil, lalu kapital di setiap kata
        $name = ucwords(strtolower(trim($_POST['register-name'])));

        // Mengambil data email dari form dan di-filter secara otomatis
        $email = filter_email($_POST['register-email'] ?? '');

        // Mengambil data password dari form
        $password = $_POST['register-password'];

        // Mengambil data konfirmasi password dari form
        $confirm_password = $_POST['register-confirm-password'];

        // Mengambil data input captcha dari user
        $captcha_input = trim($_POST['kode']);

        // ID captcha khusus untuk registrasi pasien
        $captcha_id = 'registrasi_pasien';


        /* =============================== VALIDASI CAPTCHA ============================== */
        // Jika session captcha kosong atau input captcha tidak sama, maka :
        if (empty($_SESSION["captcha_" . $captcha_id]) || strcasecmp($captcha_input, $_SESSION["captcha_" . $captcha_id]) !== 0) {

            // Hapus captcha dari session
            unset($_SESSION["captcha_" . $captcha_id]);

            // Redirect ke modal registration pasien
            // Hal ini disertai dengan pesan = Captcha salah!
            header("Location: " . BASE_URL . "index.php?pesan=gagal&modal=registration");
            exit; // Menghentikan eksekusi script
        }


        /* =============================== VALIDASI PASSWORD ============================= */
        // Jika password dan konfirmasinya tidak sama, maka :
        if ($password !== $confirm_password) {

            // Redirect ke modal registration pasien
            // Hal ini disertai dengan pesan = Password tidak sesuai!
            header("Location: " . BASE_URL . "index.php?pesan=password_tidak_sesuai&modal=registration");
            exit; // Menghentikan eksekusi script
        }

        // Jika panjang minimal password kurang dari 8 karakter, maka :
        if (strlen($password) < 8) {

            // Redirect ke modal registration pasien
            // Hal ini disertai dengan pesan = Password terlalu singkat!
            header("Location: " . BASE_URL . "index.php?pesan=password_singkat&modal=registration");
            exit; // Menghentikan eksekusi script
        }

        // Jika password tidak ada karakter spesial yang dipakai, maka :
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {

            // Redirect ke modal registration pasien
            // Hal ini disertai dengan pesan = Password kurang kuat!
            header("Location: " . BASE_URL . "index.php?pesan=password_lemah&modal=registration");
            exit; // Menghentikan eksekusi script
        }


        /* ================================= VALIDASI EMAIL ============================== */
        // Query ini digunakan untuk mengecek email yang ada di dua tabel sekaligus
        $stmt = $koneksi->prepare("
            SELECT email FROM akun_pasien WHERE email = ?
            UNION
            SELECT email FROM akun_pekerja WHERE email = ?
            LIMIT 1
        ");

        $stmt->bind_param("ss", $email, $email); // Mengikat parameter email ke query
        $stmt->execute();                        // Menjalankan query
        $stmt->store_result();                   // Menyimpan hasil query
        $stmt->bind_result($db_email);           // Mengikat hasil query ke variabel
        $stmt->fetch();                          // Mengambil data hasil query
        $stmt->close();                          // Menutup statement

        // Jika email ditemukan di salah satu tabel, maka :
        if ($db_email) {

            // Redirect ke modal registration pasien
            // Hal ini disertai dengan pesan = Email sudah terdaftar!
            header("Location: " . BASE_URL . "index.php?pesan=email_terdaftar&modal=registration");
            exit; // Menghentikan eksekusi script
        }


        /* =============================== VALIDASI USERNAME ============================= */
        // Query ini digunakan untuk mengecek username yang ada di dua tabel sekaligus
        $stmt = $koneksi->prepare("
            SELECT username FROM akun_pasien WHERE username = ?
            UNION
            SELECT username FROM akun_pekerja WHERE username = ?
            LIMIT 1
        ");

        $stmt->bind_param("ss", $username, $username);  // Mengikat parameter username ke query
        $stmt->execute();                               // Menjalankan query
        $stmt->store_result();                          // Menyimpan hasil query
        $stmt->bind_result($db_username);               // Mengikat hasil query ke variabel
        $stmt->fetch();                                 // Mengambil data hasil query
        $stmt->close();                                 // Menutup statement

        // Jika username ditemukan di salah satu tabel, maka :
        if ($db_username) {

            // Redirect ke modal registration pasien
            // Hal ini disertai dengan pesan = Username sudah terdaftar!
            header("Location: " . BASE_URL . "index.php?pesan=username_terdaftar&modal=registration");
            exit; // Menghentikan eksekusi script
        }


        /* ================================ INSERT DATABASE ============================== */
        // Menghapus captcha dari session setelah valid
        unset($_SESSION["captcha_" . $captcha_id]);

        // Hash password menggunakan algoritma BCRYPT
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Menentukan role ID untuk pasien
        $role_id = 3;

        // Query ini digunakan untuk insert data pasien baru
        $stmt = $koneksi->prepare("
            INSERT INTO akun_pasien (email, nama, username, password, role_id) 
            VALUES (?, ?, ?, ?, ?)
        ");

        // Mengikat semua data ke query
        $stmt->bind_param("ssssi", $email, $name, $username, $password_hash, $role_id);

        // Menjalankan query insert
        if ($stmt->execute()) {

            $stmt->close();     // Menutup statement
            $koneksi->close();  // Menutup koneksi database

            // Redirect ke modal login pasien
            // Hal ini disertai dengan pesan = Pendaftaran akun berhasil!
            header("Location: " . BASE_URL . "index.php?pesan=registration_sukses&modal=pasien");
            exit; // Menghentikan eksekusi script

        } else { // Jika selain itu, maka :

            $stmt->close();     // Menutup statement
            $koneksi->close();  // Menutup koneksi database

            // Redirect ke modal registration pasien
            // Hal ini disertai dengan pesan = Akses ditolak!
            header("Location: " . BASE_URL . "index.php?pesan=error&modal=registration");
            exit; // Menghentikan eksekusi script
        }
    }

?>