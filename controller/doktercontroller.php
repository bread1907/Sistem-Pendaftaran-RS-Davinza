<?php
session_start();

class DokterController {

    private $model;

    public function __construct($conn) {
        require_once __DIR__ . "/../model/DokterModel.php";
        $this->model = new DokterModel($conn);
    }

    // ======================================
    // 1. TAMPILKAN LOGIN DOKTER
    // ======================================
    public function login() {

        // Jika sudah login → langsung ke homepage dokter
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
        $password = $_POST['password'] ?? '';

        $dokter = $this->model->login($username, $password);

        if ($dokter) {
            $_SESSION['dokter_id'] = $dokter['dokter_id'];
            $_SESSION['nama_dokter'] = $dokter['nama'];

            header("Location: index.php?page=home");
            exit;
        } else {
            $_SESSION['error'] = "Username atau password salah!";
            header("Location: index.php?page=login");
            exit;
        }
    }

    // ======================================
    // 3. HALAMAN HOMEPAGE DOKTER
    // ======================================
    public function home() {

        // Cek login
        if (!isset($_SESSION['dokter_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        include __DIR__ . "/../Dokter/Halaman/homepagedokter.php";
    }

    // ======================================
    // 4. LOGOUT
    // ======================================
    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
