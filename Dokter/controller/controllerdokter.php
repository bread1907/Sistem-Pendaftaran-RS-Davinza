<?php
require_once __DIR__ . "/../model/modeldokter.php";

class DokterController {

    private $model;

    public function __construct($conn) {
        $this->model = new DokterModel($conn);
    }

    public function LoginDokter() {
        include __DIR__ . "/../Halaman/logindokter.php";
    }

    public function loginProses() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $nip = $_POST['nip'] ?? '';
            $password = $_POST['password'] ?? '';

            $dokter = $this->model->cekLogin($username, $nip, $password);

            if ($dokter) {
                $_SESSION['dokter_logged_in'] = true;
                $_SESSION['dokter_id'] = $dokter['dokter_id'];
                $_SESSION['dokter_nama'] = $dokter['nama'];
                $_SESSION['dokter_spesialis'] = $dokter['spesialis'];

                header("Location: /Sistem-Pendaftaran-RS-Davinza/Dokter/Halaman/homepagedokter.php");
                exit;
            } else {
                $_SESSION['error'] = "Username, NIP, atau password salah!";
                header("Location: /Sistem-Pendaftaran-RS-Davinza/Dokter/Halaman/logindokter.php");
                exit;
            }
        }
    }

    public function home() {
        if (!isset($_SESSION['dokter_logged_in']) || $_SESSION['dokter_logged_in'] !== true) {
            header("Location: /Sistem-Pendaftaran-RS-Davinza/Dokter/Halaman/logindokter.php");
            exit;
        }
        include __DIR__ . "/../Halaman/homepagedokter.php";
    }
}
?>
