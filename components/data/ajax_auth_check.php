<?php
    
    // mengecek apakah session belum pernah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // jika session belum aktif, maka mulai session baru
    }

    // muat konfigurasi untuk akses BASE_URL & Koneksi
    include __DIR__.'/../../config/config.php';

    
    // ========================== SESSION ============================
    $username = $_SESSION['username'];
    $role     = $_SESSION['level'];
    $nama     = $_SESSION['nama'];
    $level    = $_SESSION['level'];


    // ========================== HELPERS ============================
    function logAktivitas($koneksi, $username, $role, $aksi, $detail)
    {
        if (empty($username) || empty($role) || empty($aksi)) return;

        $stmt = $koneksi->prepare("
            INSERT INTO riwayat_aktivitas (username, role, aksi, detail, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");

        if (!$stmt) return;

        $stmt->bind_param("ssss", $username, $role, $aksi, $detail);
        $stmt->execute();
        $stmt->close();
    }


    // =========================== TIMEOUT ===========================
    if (isset($_GET['action']) && $_GET['action'] === 'force_logout') {
        // Log User: Timeout
        if (!isset($_SESSION['__timeout_logged'])) {
            logAktivitas($koneksi, $username, $role, 'Timeout', "$nama telah di Logout paksa oleh Sistem");
            $_SESSION['__timeout_logged'] = true;
        }
        session_unset(); session_destroy();
        echo json_encode(['status'=>'auto_timeout']); exit;
    }

    // Cek session valid atau tidak
    if (!isset($_SESSION['email']) || !isset($_SESSION['level']) || !isset($_SESSION['loggedin']) || $_SESSION['loggedin']!==true) {
        session_unset(); session_destroy();
        echo json_encode(['status'=>'auto_timeout']); exit;
    }


    // ===================== UPDATE LAST ACTIVITY ====================
    $_SESSION['LAST_ACTIVITY'] = time();
    echo json_encode(['status'=>'ok']);
    exit;



    // ======================= DELETED ACCOUNT =======================

    // Tentukan tabel berdasarkan level
    if ($level === 'admin' || $level === 'pekerja') {
        $table = 'akun_pekerja';
    } else {
        $table = 'akun_pasien';
    }

    // Cek apakah akun masih ada
    $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE email='$email' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Jika data tidak ada maka hapus Session loggedin (akun dikeluarkan secara paksa)
    if (!$data) {
        logAktivitas($koneksi, $username, $role, 'Akun Dihapus', "Akun a/n. $nama telah Dihapus, karena dianggap melanggar ketentuan Poliklinik");
        session_unset(); session_destroy();
        echo json_encode(['status' => 'auto_deleted']); exit;
    }

    // Return JSON
    header('Content-Type: application/json');

?>