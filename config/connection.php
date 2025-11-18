<?php

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$host = "localhost";
	$username = "root";
	$password = "";
	$namadb = "siaklik_db";

	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	try {
		$koneksi = mysqli_connect($host, $username, $password, $namadb);
		mysqli_set_charset($koneksi, "utf8");
	} catch (mysqli_sql_exception $e) {
		$_SESSION['error_message'] = $e->getMessage();
		header("Location: " . BASE_URL . "components/pages/error/database_notification.php");
		exit;
	}

?>