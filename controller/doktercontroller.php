<?php

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

        // Jika sudah login → redirect ke homepage
        if (isset($_SESSION['dokter_id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        include "View/LoginDokter.php";
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

        if (!isset($_SESSION['dokter_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        include "View/HomepageDokter.php";
    }

    // ======================================
    // 4. LOGOUT
    // ======================================
    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    // ===============================
// 5. HOMEPAGE DOKTER
// ===============================
public function HomepageDokter() {

    // Jika belum login sebagai dokter → kembali ke halaman login dokter
    if (!isset($_SESSION['dokter_id'])) {
        include __DIR__ . "Dokter/Halaman/homepagedokter.php";
        return;
    }

    // Jika sudah login → tampilkan dashboard dokter
    include __DIR__ . "Dokter/Halaman/homepagedokter.php";
}

}
