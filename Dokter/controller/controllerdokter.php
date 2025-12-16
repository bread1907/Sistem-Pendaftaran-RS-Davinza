<?php
require_once __DIR__ . "/../model/modeldokter.php";
require_once __DIR__ . "/../model/jadwalmodel.php";
require_once __DIR__ . "/../model/rekammedismodel.php";

class DokterController {

    private $conn;
    private $model;

    public function __construct($conn) {
        $this->conn  = $conn;
        $this->model = new DokterModel($conn);
    }

    // ================= LOGIN =================
    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        include 'Halaman/logindokter.php';
    }

    public function LoginProses() {
        if (session_status() === PHP_SESSION_NONE) session_start();
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

        $dokter = $this->model->getByUsernameNip($username, $nip);

        if (!$dokter || !password_verify($password, $dokter['password'])) {
            $_SESSION['login_error'] = "Username, NIP, atau Password salah!";
            header("Location: index.php?aksi=login");
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['dokter_login'] = true;
        $_SESSION['dokter_id']    = $dokter['dokter_id'];
        $_SESSION['dokter_nama']  = $dokter['nama'];

        header("Location: index.php?aksi=homepagedokter");
        exit;
    }

    public function homepage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['dokter_login'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        include 'Halaman/homepagedokter.php';
    }

    // ================= DAFTAR PASIEN =================
    public function daftarPasien() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['dokter_login'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        $jadwalModel = new JadwalModel($this->conn);
        $data = $jadwalModel->getPasienByDokter($_SESSION['dokter_id']);

        include 'Halaman/halaman_daftar_pasien.php';
    }

    // ================= FORM REKAM MEDIS =================
public function formRekamMedis() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['dokter_login'])) {
        header("Location: index.php?aksi=login");
        exit;
    }

    $jadwal_id = $_GET['jadwal_id'] ?? null;
    $pasien_id = $_GET['pasien_id'] ?? null;

    if (!$jadwal_id || !$pasien_id) {
        die("Data tidak lengkap");
    }

    // Ambil data rekam medis jika sudah ada
    $rmModel = new RekamMedisModel($this->conn);
    $existing = $rmModel->getByPasienDokter($pasien_id, $_SESSION['dokter_id']);

    include 'Halaman/form_rekam_medis.php';
}


    // ================= SIMPAN REKAM MEDIS =================
public function simpanRekamMedis() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['dokter_login'])) {
        header("Location: index.php?aksi=login");
        exit;
    }

    $dokter_id = $_SESSION['dokter_id'];
    $pasien_id = $_POST['pasien_id'] ?? null;
    $jadwal_id = $_POST['jadwal_id'] ?? null;
    $status    = $_POST['status'] ?? null;
    $diagnosa  = trim($_POST['diagnosa'] ?? '');
    $tindakan  = trim($_POST['tindakan'] ?? '');
    $resep     = trim($_POST['resep_obat'] ?? '');
    $catatan   = trim($_POST['catatan'] ?? '');

    if (!$pasien_id || !$jadwal_id || $diagnosa === '' || $tindakan === '' || !$status) {
        die("Data tidak lengkap");
    }

    $rmModel = new RekamMedisModel($this->conn);
    $existing = $rmModel->getByPasienDokter($pasien_id, $dokter_id);

    if ($existing) {
        // update jika sudah ada
        $rmModel->updateRekamMedis(
            $existing['rekam_id'],
            $diagnosa,
            $tindakan,
            $resep,
            $catatan
        );
    } else {
        // insert baru
        $rmModel->insertRekamMedis(
            $dokter_id,
            $pasien_id,
            $diagnosa,
            $tindakan,
            $resep,
            $catatan
        );
    }

    // update status jadwal
    $jadwalModel = new JadwalModel($this->conn);
    $jadwalModel->updateStatusJadwal($jadwal_id, $status);

    header("Location: index.php?aksi=daftarpasiendokter");
    exit;
}



    // ================= LOGOUT =================
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location: index.php?aksi=login");
        exit;
    }

    // ================= RIWAYAT REKAM MEDIS =================
    public function riwayatRekamMedis() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['dokter_login']) || empty($_SESSION['dokter_id'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        $rmModel = new RekamMedisModel($this->conn);
        $data = $rmModel->getRiwayatByDokter($_SESSION['dokter_id']);

        include 'Halaman/riwayat_rekam_medis.php';
    }
}
