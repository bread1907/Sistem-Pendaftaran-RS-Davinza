<?php
require_once __DIR__ . "/../model/modeldokter.php";

class DokterController {

    private $model;

    public function __construct($conn) {
        $this->model = new DokterModel($conn);
    }

    public function loginProses() {
        $username = trim($_POST['username'] ?? '');
        $nip      = trim($_POST['nip'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $dokter = $this->model->cekLogin($username, $nip, $password);

        if ($dokter) {
            $_SESSION['dokter_login'] = true;
            $_SESSION['dokter_id']    = $dokter['dokter_id'];
            $_SESSION['dokter_nama']  = $dokter['nama'];
            header("Location: Halaman/homepagedokter.php");
            exit;
        }

        $_SESSION['error'] = "Username, NIP, atau Password salah!";
        header("Location: index.php");
        exit;
    }
}