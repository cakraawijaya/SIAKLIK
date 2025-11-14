<?php

    session_start();

    // Ambil id captcha dari query string, default 'default'
    $captcha_id = $_GET['id'] ?? 'default';

    // Fungsi generate captcha
    function acakCaptcha($length = 5) {
        $kode = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        $pass = [];
        $panjangkode = strlen($kode) - 1;
        for ($i = 0; $i < $length; $i++) {
            $pass[] = $kode[rand(0, $panjangkode)];
        }
        return implode('', $pass);
    }

    // Generate kode baru
    $code = acakCaptcha();

    // Simpan di session sesuai id
    $_SESSION["captcha_" . $captcha_id] = $code;

    // Ukuran captcha
    $width = 173;
    $height = 50;
    $image = imagecreatetruecolor($width, $height);

    // Warna background & teks
    $bgc = imagecolorallocate($image, 22, 86, 165);
    $text_color = imagecolorallocate($image, 223, 230, 233);
    $line_color = imagecolorallocate($image, 255, 255, 255);

    // Fill background
    imagefill($image, 0, 0, $bgc);

    // Tambahkan noise garis
    for ($i = 0; $i < 5; $i++) {
        imageline($image, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $line_color);
    }

    // Path font TTF
    $font_path = __DIR__ . '/../../public/assets/font/arial-font/arial.ttf';

    // Tulis captcha huruf per huruf dengan rotasi
    for ($i = 0; $i < strlen($code); $i++) {
        $angle = rand(-15, 15);
        $x = 15 + ($i * 30);
        $y = 35 + rand(-5,5);
        imagettftext($image, 20, $angle, $x, $y, $text_color, $font_path, $code[$i]);
    }

    // Output
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);

?>