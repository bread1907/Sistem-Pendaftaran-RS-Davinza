<?php
class PasienController
{
    private $conn;
    private $pasienModel;

    public function __construct($conn)
    {
        require_once __DIR__ . '/../Model/PasienModel.php';

        if (!$conn) {
            die("Koneksi database tidak ditemukan.");
        }

        $this->conn = $conn;
        $this->pasienModel = new PasienModel($conn);
    }

    // ================= REGISTER ===================
    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include "View/Register.php";
            return;
        }

        $email          = trim($_POST['email']);
        $username       = trim($_POST['username']);
        $password       = $_POST['password'];
        $confirm        = $_POST['confirm_password'];
        $tanggal_lahir  = $_POST['tanggal_lahir'];
        $jenis_kelamin  = $_POST['jenis_kelamin'];
        $alamat         = trim($_POST['alamat']);
        $no_hp          = trim($_POST['no_hp']);
        $nik            = trim($_POST['nik']);

        $errors = [];

        if (
            empty($email) || empty($username) || empty($password) ||
            empty($confirm) || empty($tanggal_lahir) ||
            empty($jenis_kelamin) || empty($alamat) ||
            empty($no_hp) || empty($nik)
        ) {
            $errors[] = "Semua field wajib diisi!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid!";
        }

        if ($this->pasienModel->cekEmail($email)) {
            $errors[] = "Email sudah terdaftar!";
        }

        if (strlen($password) < 8) {
            $errors[] = "Password minimal 8 karakter!";
        }

        if ($password !== $confirm) {
            $errors[] = "Konfirmasi password tidak cocok!";
        }

        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            header("Location: index.php?action=register");
            exit;
        }

        // SIMPAN KE DATABASE (AKTIFKAN JIKA SUDAH SIAP)
        /*
        $this->pasienModel->insert([
            'email' => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'nik' => $nik
        ]);
        */

        $_SESSION['popup_success'] = "Registrasi berhasil!";
        header("Location: index.php?action=login");
        exit;
    }

    // ================= LOGIN ===================
    public function Login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include "View/Login.php";
            return;
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $user = $this->pasienModel->getByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['login_error'] = "Email atau Password salah!";
            header("Location: index.php?action=login");
            exit;
        }

        $_SESSION['pasien_id'] = $user['pasien_id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['nik']       = $user['nik'];

        header("Location: index.php?action=homepage");
        exit;
    }

    public function Logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?action=homepage");
        exit;
    }

    // ================= HALAMAN ===================
    public function Homepage()  { include "View/Homepage.php"; }
    public function Tentang()   { include "View/Tentangkami.php"; }
    public function Layanan()   { include "View/layanan.php"; }
    public function Profile()   { include "View/profile.php"; }
    public function Fasilitas() { include "View/fasilitas.php"; }
    public function Emergency() { include "View/emergencycall.php"; }
}
