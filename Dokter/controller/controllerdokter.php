<?php
require_once __DIR__ . "/../model/modeldokter.php";
require_once __DIR__ . "/../model/jadwalmodel.php";

class DokterController {

    private $model;
    private $conn; // ✅ tambahan

    public function __construct($conn) {
        $this->conn = $conn; // ✅ tambahan
        $this->model = new DokterModel($conn);
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        include 'Halaman/logindokter.php';
    }

    public function LoginProses() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include 'Halaman/logindokter.php';
            return;
        }

        $username = trim($_POST['username'] ?? '');
        $nip      = trim($_POST['nip'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $nip === '' || $password === '') {
            $_SESSION['login_error'] = "Semua field wajib diisi!";
            header("Location: index.php?aksi=login");
            exit;
        }

        // ✅ FIXED LINE 36
        $dokter = $this->model->getByUsernameNip($username, $nip);

        if (!$dokter) {
            $_SESSION['login_error'] = "Username atau NIP tidak ditemukan!";
            header("Location: index.php?aksi=login");
            exit;
        }

        if (!password_verify($password, $dokter['password'])) {
            $_SESSION['login_error'] = "Username, NIP, atau Password salah!";
            header("Location: index.php?aksi=login");
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['dokter_login'] = true;
        $_SESSION['dokter_id']    = $dokter['dokter_id'];
        $_SESSION['dokter_nama']  = $dokter['nama'];
        $_SESSION['dokter_nip']   = $dokter['nip'];
        $_SESSION['dokter_user'] = $dokter['username'];

        $_SESSION['login_success'] = "Selamat datang, Dr. " . $dokter['nama'] . "!";

        header("Location: index.php?aksi=homepagedokter");
        exit;
    }

    public function homepage() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['dokter_login'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        include 'Halaman/homepagedokter.php';
    }


    // ✅ tambahan method untuk dokter melihat daftar pasien sesuai jadwal temu
    public function daftarPasien() {

        // Pastikan session aktif
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah dokter sudah login
        if (empty($_SESSION['dokter_login']) || empty($_SESSION['dokter_id'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        // Ambil data daftar pasien berdasarkan jadwal temu dokter
        $jadwalModel = new JadwalModel($this->conn);
        $data = $jadwalModel->getPasienByDokter((int) $_SESSION['dokter_id']);

        // Tampilkan halaman daftar pasien dokter
        include 'Halaman/halaman_daftar_pasien.php';
    }

    public function formRekamMedis() {

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['dokter_login'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        $dokter_id = $_GET['dokter_id'] ?? null;
        $pasien_id = $_GET['pasien_id'] ?? null;

        include 'Halaman/form_rekam_medis.php';
    }

    public function simpanRekamMedis() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['dokter_login']) || empty($_SESSION['dokter_id'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        require_once __DIR__ . '/../model/rekammedismodel.php';
        $model = new RekamMedisModel($this->conn);

        $dokter_id = (int) $_SESSION['dokter_id'];       // ✅ dari session
        $pasien_id = (int) ($_POST['pasien_id'] ?? 0);   // ✅ dari form

        $diagnosa   = trim($_POST['diagnosa'] ?? '');
        $tindakan   = trim($_POST['tindakan'] ?? '');
        $resep_obat = trim($_POST['resep_obat'] ?? '');
        $catatan    = trim($_POST['catatan'] ?? '');

        $model->insertRekamMedis($dokter_id, $pasien_id, $diagnosa, $tindakan, $resep_obat, $catatan);

        header("Location: index.php?aksi=riwayatrekammedis");
        exit;
    }

    public function riwayatRekamMedis() {

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['dokter_login']) || empty($_SESSION['dokter_id'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        require_once __DIR__ . '/../model/rekammedismodel.php';
        $model = new RekamMedisModel($this->conn);

        $data = $model->getRiwayatByDokter($_SESSION['dokter_id']);

        include 'Halaman/riwayat_rekam_medis.php';
    }

    public function logout() {

        // Pastikan session aktif
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Hapus semua data session
        $_SESSION = [];

        // Hapus cookie session (lebih aman)
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Hancurkan session
        session_destroy();

        // Redirect ke login dokter
        header("Location: index.php?aksi=login");
        exit;
    }
}