<?php

class DokterController {

    private $model;

    public function __construct() {

        // ============================
        // LOAD KONEKSI DATABASE
        // ============================
        require_once __DIR__ . "../../koneksi.php";

        // ============================
        // LOAD MODEL DOKTER
        // ============================
        require_once __DIR__ . "/../model/doktermodel.php";

        // gunakan koneksi global
        global $conn;

        // inisialisasi model
        $this->model = new DokterModel($conn);
    }

    // ===============================
    // 1. LIST DOKTER UNTUK VIEW
    // ===============================
    public function Temukan() {
        $spesialis = $_GET['spesialis'] ?? null;

        if ($spesialis) {
            $dokter = $this->model->getBySpesialis($spesialis);
        } else {
            $dokter = $this->model->getAll();
        }

        include __DIR__ . "/../View/temukandokter.php";
    }


    // ===============================
    // 2. FORM TAMBAH DOKTER
    // ===============================
    public function Add() {
        include __DIR__ . "/../View/dokter/add.php";
    }

    // ===============================
    // 3. INSERT DOKTER BARU
    // ===============================
    public function Store() {
        if (!empty($_POST)) {
            $this->model->insert($_POST);
        }
        header("Location: index.php?action=dokter_list");
        exit;
    }

    // ===============================
    // 4. DELETE DOKTER
    // ===============================
    public function Delete() {
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);
        }
        header("Location: index.php?action=dokter_list");
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

?>
