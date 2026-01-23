<?php

    // ===========================================================================================
    // CEK SESSION
    // ===========================================================================================
    // Mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }


    // ===========================================================================================
    // AMBIL ID CAPTCHA DARI QUERY STRING
    // ===========================================================================================
    // Digunakan untuk membedakan captcha jika ada lebih dari satu form
    $captcha_id = $_GET['id'] ?? 'default';


    // ===========================================================================================
    // FUNGSI GENERATE CAPTCHA
    // ===========================================================================================
    // Fungsi untuk membuat kode captcha acak (huruf & angka tertentu)
    function acakCaptcha($length = 5) {

        // Kumpulan karakter yang digunakan (tanpa O, I, 0, 1 agar tidak ambigu)
        $kode = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

        $pass = []; // Array penampung karakter captcha
        $panjangkode = strlen($kode) - 1; // Panjang karakter dikurangi 1 (untuk index array)

        // Loop untuk membentuk captcha sesuai panjang yang diminta
        for ($i = 0; $i < $length; $i++) {

            $pass[] = $kode[rand(0, $panjangkode)]; // Ambil 1 karakter acak dari string $kode
        }

        return implode('', $pass); // Gabungkan array menjadi string dan kembalikan
    }


    // ===========================================================================================
    // GENERATE & SIMPAN CAPTCHA KE SESSION
    // ===========================================================================================
    // Membuat kode captcha baru
    $code = acakCaptcha();

    // Simpan di session sesuai id
    $_SESSION["captcha_" . $captcha_id] = $code;


    // ===========================================================================================
    // INISIALISASI GAMBAR CAPTCHA
    // ===========================================================================================
    // Ukuran captcha
    $width = 173;   // Menentukan lebar gambar captcha (px)
    $height = 50;   // Menentukan tinggi gambar captcha (px)

    // Membuat gambar kosong
    $image = imagecreatetruecolor($width, $height);


    // ===========================================================================================
    // SET WARNA CAPTCHA
    // ===========================================================================================
    // Warna background (RGB)
    $bgc = imagecolorallocate($image, 22, 86, 165);

    // Warna teks captcha (RGB)
    $text_color = imagecolorallocate($image, 223, 230, 233);

    // Warna garis noise (RGB)
    $line_color = imagecolorallocate($image, 255, 255, 255);


    // ===========================================================================================
    // ISI BACKGROUND GAMBAR
    // ===========================================================================================
    // Mengisi background dengan warna dasar
    imagefill($image, 0, 0, $bgc);


    // ===========================================================================================
    // TAMBAHKAN NOISE (GARIS ACAK)
    // ===========================================================================================
    // Membuat captcha lebih sulit dibaca bot
    for ($i = 0; $i < 5; $i++) {

        // Menggambar garis acak di dalam gambar
        imageline(
            $image,                // Resource gambar
            rand(0, $width),       // Titik X awal
            rand(0, $height),      // Titik Y awal
            rand(0, $width),       // Titik X akhir
            rand(0, $height),      // Titik Y akhir
            $line_color            // Warna garis
        );
    }


    // ===========================================================================================
    // SET PATH FONT
    // ===========================================================================================
    // Lokasi file font TTF yang digunakan
    $font_path = __DIR__ . '/../../../../public/assets/font/arial-font/arial.ttf';


    // ===========================================================================================
    // TULIS TEKS CAPTCHA KE GAMBAR
    // ===========================================================================================
    // Menulis huruf captcha satu per satu dengan rotasi acak
    for ($i = 0; $i < strlen($code); $i++) {
        $angle = rand(-15, 15);           // Rotasi huruf
        $x     = 15 + ($i * 30);          // Posisi horizontal
        $y     = 35 + rand(-5, 5);        // Posisi vertikal

        // Menulis huruf ke gambar menggunakan font TTF
        imagettftext(
            $image,                // Resource gambar
            20,                    // Ukuran font
            $angle,                // Sudut rotasi
            $x,                    // Posisi X
            $y,                    // Posisi Y
            $text_color,           // Warna teks
            $font_path,            // Path font
            $code[$i]              // Karakter yang ditulis
        );
    }


    // ===========================================================================================
    // OUTPUT GAMBAR CAPTCHA
    // ===========================================================================================
    header('Content-Type: image/png');  // Set header sebagai gambar PNG
    imagepng($image);                   // Tampilkan gambar captcha


    // ===========================================================================================
    // BERSIHKAN MEMORY (OPSIONAL)
    // ===========================================================================================
    // imageDestroy($image);

?>