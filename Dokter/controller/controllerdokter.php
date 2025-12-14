<?php
require_once __DIR__ . "/../model/modeldokter.php";

class DokterController {

    private $model;

    public function __construct($conn) {
        $this->model = new DokterModel($conn);
    }

    public function login() {
        include 'Halaman/logindokter.php';
    }

    public function LoginProses() {

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
        include 'Halaman/homepagedokter.php';
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
