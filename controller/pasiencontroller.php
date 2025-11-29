<?php
class PasienController {
    private $pasienModel;

    public function __construct() {
        require_once __DIR__ . '/../Model/PasienModel.php';
        global $conn;

        if (!$conn) {
            die("Koneksi database tidak ditemukan.");
        }

        $this->pasienModel = new PasienModel($conn);
    }

    // ================= REGISTER ===================
    public function Register() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include "View/Register.php";
            return;
        }

        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm  = $_POST['confirm_password'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = trim($_POST['alamat']);
        $no_hp = trim($_POST['no_hp']);

        $errors = [];

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
            $_SESSION['popup_error'] = $errors;
            header("Location: index.php?action=register");
            exit;
        }

        // INSERT DATA
        $insert = $this->pasienModel->insert([
            'email' => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
            'no_hp' => $no_hp
        ]);

        if ($insert) {
            $_SESSION['popup_success'] = "Registrasi berhasil! Silakan login.";
        } else {
            $_SESSION['popup_fail'] = "Registrasi gagal.";
        }

        header("Location: index.php?action=register");
        exit;
    }


    // ================= LOGIN ===================
public function Login() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        include "View/Login.php";
        return;
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Ambil data pasien berdasarkan email
    $user = $this->pasienModel->getByEmail($email);

    if (!$user) {
        $_SESSION['login_error'] = "Email tidak ditemukan!";
        header("Location: index.php?action=login");
        exit;
    }

    // Cek password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_error'] = "Password salah!";
        header("Location: index.php?action=login");
        exit;
    }

    // SIMPAN SESSION LOGIN (fix!)
    $_SESSION['user_id']   = $user['pasien_id'];   // FIX
    $_SESSION['username']  = $user['username'];    // FIX

    $_SESSION['login_success'] = "Selamat datang, " . $user['username'] . "!";

    header("Location: index.php?action=homepage");
    exit;
}
public function Logout() {
    session_start();

    // Hapus semua session
    session_unset();
    session_destroy();

    // Arahkan kembali ke homepage
    header("Location: index.php?action=homepage");
    exit;
}



    // ================= HALAMAN HOME ===================
    public function Homepage() {
        include "View/Homepage.php";
    }
    public function Tentang(){
        include "View/Tentangkami.php";
    }
}
