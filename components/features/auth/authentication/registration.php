<?php

    session_start();
    include __DIR__ . '/../../../../config/config.php';

    function filter_gmail_email($raw_email) {
        // lowercase
        $val = strtolower(trim($raw_email));

        // hanya izinkan karakter gmail
        $val = preg_replace('/[^a-z0-9.@]/', '', $val);

        // cegah lebih dari satu @
        $parts = explode('@', $val);
        if (count($parts) > 2) {
            $val = $parts[0] . '@' . implode('', array_slice($parts, 1));
        }

        // rapikan local & domain
        if (strpos($val, '@') !== false) {
            [$local, $domain] = explode('@', $val, 2);

            // cegah titik beruntun di local
            $local = preg_replace('/\.{2,}/', '.', $local);

            // domain hanya huruf & titik
            $domain = preg_replace('/[^a-z.]/', '', $domain);

            $val = $local . '@' . $domain;
        }

        // batas panjang
        if (strlen($val) > 45) {
            $val = substr($val, 0, 45);
        }

        return $val;
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = strtolower(preg_replace('/[^a-z0-9]/i', '', $_POST['register-username']));
        $name = ucwords(strtolower(trim($_POST['register-name'])));
        $email = filter_gmail_email($_POST['register-email'] ?? '');
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

        /* ===========================================================
        VALIDASI USERNAME & EMAIL (REVISI)
        =========================================================== */

        // --- Cek username unik (khusus akun_pasien) ---
        $stmt = $koneksi->prepare("
            SELECT username 
            FROM akun_pasien 
            WHERE username = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_username);
        $stmt->fetch();
        $stmt->close();

        if ($db_username) {
            header("Location: " . BASE_URL . "index.php?pesan=username_terdaftar&modal=registration");
            exit;
        }

        // --- Cek email unik di akun_pasien & akun_pekerja ---
        $stmt = $koneksi->prepare("
            SELECT email FROM akun_pasien WHERE email = ?
            UNION
            SELECT email FROM akun_pekerja WHERE email = ?
            LIMIT 1
        ");
        $stmt->bind_param("ss", $email, $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_email);
        $stmt->fetch();
        $stmt->close();

        if ($db_email) {
            header("Location: " . BASE_URL . "index.php?pesan=email_terdaftar&modal=registration");
            exit;
        }

        /* ===========================================================
        END VALIDASI
        =========================================================== */

        // --- Hash password ---
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // --- Insert ke DB ---
        $role_id = 3; // role pasien
        $stmt = $koneksi->prepare("
            INSERT INTO akun_pasien (email, nama, username, password, role_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
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