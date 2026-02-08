<?php

	// ===========================================================================================
	// KONFIGURASI DAN INISIALISASI KONEKSI DATABASE
	// ===========================================================================================
	// File ini bertugas untuk:
	// - Mengatur kredensial database
	// - Memulai session jika belum aktif
	// - Membuat koneksi database menggunakan MySQLi
	// - Menangani error koneksi secara terkontrol

	// Aktifkan mode pelaporan error MySQLi agar error dilempar sebagai exception
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// Konfigurasi kredensial database
	$host = "localhost";
	$username = "root";
	$password = "";
	$namadb = "siaklik_db";

    // Mengecek apakah session belum pernah dimulai
	// Session digunakan untuk menyimpan pesan error jika koneksi gagal
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Jika session belum aktif, maka mulai session baru
    }

	// Mencoba untuk memproses :
	try {

		// Koneksi database
		$koneksi = mysqli_connect($host, $username, $password, $namadb);

		// Set karakter encoding ke UTF-8 untuk mendukung karakter multibahasa
		mysqli_set_charset($koneksi, "utf8");
	} 

	// Menangkap exception jika terjadi kesalahan pada proses database
	catch (mysqli_sql_exception $e) {

		// Mencatat detail error ke log server untuk keperluan debugging
        error_log("Database error: " . $e->getMessage());

		// Simpan pesan error ke dalam session
		$_SESSION['error_message'] = $e->getMessage();

		// Redirect ke halaman notifikasi error database
		header("Location: " . BASE_URL . "components/pages/system/error/database_notification.php");
		exit; // Menghentikan eksekusi script
	}

?>