<?php
session_start();

class DokterController {

    private $model;

    public function __construct($conn) {
        // Load model dokter
        require_once __DIR__ . "/../model/DokterModel.php";
        $this->model = new DokterModel($conn);
    }

    // ======================================
    // 1. TAMPILKAN HALAMAN LOGIN DOKTER
    // ======================================
    public function login() {
        if (isset($_SESSION['dokter_id'])) {
            header("Location: index.php?page=home");
            exit;
        }
        include __DIR__ . "/../Dokter/Halaman/logindokter.php";
    }

    // ======================================
    // 2. PROSES LOGIN DOKTER
    // ======================================
    public function loginProses() {
        $username = $_POST['username'] ?? '';
        $nip = $_POST['nip'] ?? '';
        $password = $_POST['password'] ?? '';

        $dokter = $this->model->login($username, $nip, $password);

        if ($dokter) {
            $_SESSION['dokter_id'] = $dokter['dokter_id'];
            $_SESSION['dokter_nama'] = $dokter['nama'];
            $_SESSION['dokter_nip'] = $dokter['nip'];

            header("Location: index.php?page=home");
            exit;
        } else {
            $_SESSION['error'] = "Username, NIP, atau password salah!";
            header("Location: index.php?page=login");
            exit;
        }
    }

    // ======================================
    // 3. HALAMAN HOMEPAGE DOKTER (DASHBOARD)
    // ======================================
    public function home() {
        if (!isset($_SESSION['dokter_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        include __DIR__ . "/../Dokter/Halaman/homepagedokter.php";
    }

    // ======================================
    // 4. LOGOUT DOKTER
    // ======================================
    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    // ======================================
    // 5. DAFTAR PASIEN SESUAI JADWAL
    // ======================================
    public function daftarPasien($tanggal = null) {
        if (!isset($_SESSION['dokter_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $tanggal = $tanggal ?? date('Y-m-d'); 
        $dokter_id = $_SESSION['dokter_id'];
        $pasien = $this->model->getPasienByJadwal($dokter_id, $tanggal);

        include __DIR__ . "/../Dokter/Halaman/daftarpasien.php";
    }

    // ======================================
    // 6. INPUT DIAGNOSA / RESEP / TINDAKAN
    // ======================================
    public function inputDiagnosa($pasien_id = null) {
        if (!isset($_SESSION['dokter_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $diagnosa = $_POST['diagnosa'] ?? '';
            $resep = $_POST['resep'] ?? '';
            $tindakan = $_POST['tindakan'] ?? '';
            $saran = $_POST['saran'] ?? '';
            $pasien_id = $_POST['pasien_id'] ?? 0;

            $this->model->simpanDiagnosa($pasien_id, $_SESSION['dokter_id'], $diagnosa, $resep, $tindakan, $saran);

            $_SESSION['success'] = "Data diagnosa berhasil disimpan.";
            header("Location: index.php?page=daftar_pasien");
            exit;
        }

        $pasienData = $this->model->getPasienById($pasien_id);
        include __DIR__ . "/../Dokter/Halaman/input_diagnosa.php";
    }
}
