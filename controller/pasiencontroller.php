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

        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];
        $hashed_password =
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = trim($_POST['alamat']);
        $no_hp = trim($_POST['no_hp']);
        $nik = trim($_POST['nik']);

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

    public function Masuk() {
        if (!isset($_POST['register'])) {
            return;
        }

        $email         = trim($_POST['email']);
        $username      = trim($_POST['username']);
        $password      = $_POST['password'];
        $confirm       = $_POST['confirm_password'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat        = trim($_POST['alamat']);
        $no_hp         = trim($_POST['no_hp']);
        $nik           = trim($_POST['nik']);

        $errors = [];

        if (empty($email) || empty($username) || empty($password) || empty($confirm)
            || empty($tanggal_lahir) || empty($jenis_kelamin) || empty($alamat)
            || empty($no_hp) || empty($nik)
        ) {
            $errors[] = "Semua field harus diisi dengan benar!";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid!";
        }
        if ($this->pasienModel->cekEmail($email)) {
            $errors[] = "Email sudah terdaftar!";
        }
        if (strlen($password) < 8) {
            $errors[] = "Password harus terdiri dari minimal 8 karakter!";
        }
        if ($password !== $confirm) {
            $errors[] = "Konfirmasi password tidak cocok!";
        }

        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            header("Location: index.php?action=register");
            exit;
        }

        // 1) SIMPAN DATA PASIEN
        $insert = $this->pasienModel->insert([
            'nik'           => $nik,
            'email'         => $email,
            'username'      => $username,
            'password'      => password_hash($password, PASSWORD_DEFAULT),
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat'        => $alamat,
            'no_hp'         => $no_hp
        ]);

        if (!$insert) {
            $_SESSION['popup_fail'] = "Registrasi gagal.";
            header("Location: index.php?action=register");
            exit;
        }

        // 2) BUAT KODE VERIFIKASI DAN SIMPAN DI TABEL email_verifikasi
        $kode      = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = date('Y-m-d H:i:s', time() + 10 * 60); // 10 menit

        $this->pasienModel->simpanKodeVerifikasi($email, $kode, $expiresAt);

        // 3) KIRIM EMAIL KODE (AMBIL DARI TABEL email_verifikasi LEWAT $kode YANG BARU DIBUAT)
        $ok = $this->mailService->kirimKodeVerifikasi($email, $kode);

        if (!$ok) {
            $_SESSION['popup_fail'] = "Registrasi berhasil, tapi gagal mengirim email verifikasi.";
            header("Location: index.php?action=register");
            exit;
        }

        // 4) SIMPAN DI SESSION BIAR VerifEmail.php TAHU EMAIL NYA
        $_SESSION['reg_email'] = $email;

        header("Location: View/VerifEmail.php");
        exit;
    }

    public function RegisterVerifyCode() {
        $email = $_SESSION['reg_email'] ?? null;
        if (!$email) {
            $_SESSION['register_errors'] = ['Sesi registrasi berakhir. Silakan daftar ulang.'];
            header('Location: index.php?action=register');
            exit;
        }

        $kode = trim($_POST['kode'] ?? '');

        // AMBIL KODE DARI TABEL email_verifikasi
        $record = $this->pasienModel->cariKodeVerifikasi($email, $kode);

        if (!$record) {
            $_SESSION['error'] = 'Kode verifikasi salah.';
            header('Location: View/VerifEmail.php');
            exit;
        }

        if ($record['is_used']) {
            $_SESSION['error'] = 'Kode ini sudah digunakan.';
            header('Location: View/VerifEmail.php');
            exit;
        }

        if (strtotime($record['expires_at']) < time()) {
            $_SESSION['error'] = 'Kode verifikasi sudah kadaluarsa.';
            header('Location: View/VerifEmail.php');
            exit;
        }

        // tandai kode terpakai
        $this->pasienModel->tandaiKodeTerpakai($record['id']);

        // di sini kamu bisa set kolom di tabel pasien, misal email_verified = 1
        // atau langsung redirect ke login / homepage
        $_SESSION['popup_success'] = "Email berhasil diverifikasi, silakan login.";
        header('Location: index.php?action=login');
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
