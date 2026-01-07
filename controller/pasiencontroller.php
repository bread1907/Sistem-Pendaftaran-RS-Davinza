<?php
class PasienController
{
    private $conn;
    private $pasienModel;
    private MailService $mailService;

    public function __construct($conn, MailService $mailService)
    {
        require_once __DIR__ . '/../Model/PasienModel.php';

        if (!$conn) {
            die("Koneksi database tidak ditemukan.");
        }

        $this->conn = $conn;
        $this->pasienModel = new PasienModel($conn);
        $this->mailService = $mailService; // ✅ SEKARANG ADA
    }

    // ================= REGISTER ===================
    // public function Register()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //         include "View/Register.php";
    //         return;
    //     }

    //     $email = trim($_POST['email']);
    //     $username = trim($_POST['username']);
    //     $password = $_POST['password'];
    //     $confirm = $_POST['confirm_password'];
    //     $hashed_password =
    //     $tanggal_lahir = $_POST['tanggal_lahir'];
    //     $jenis_kelamin = $_POST['jenis_kelamin'];
    //     $alamat = trim($_POST['alamat']);
    //     $no_hp = trim($_POST['no_hp']);
    //     $nik = trim($_POST['nik']);

    //     $errors = [];

    //     if (
    //         empty($email) || empty($username) || empty($password) ||
    //         empty($confirm) || empty($tanggal_lahir) ||
    //         empty($jenis_kelamin) || empty($alamat) ||
    //         empty($no_hp) || empty($nik)
    //     ) {
    //         $errors[] = "Semua field wajib diisi!";
    //     }

    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $errors[] = "Email tidak valid!";
    //     }

    //     if ($this->pasienModel->cekEmail($email)) {
    //         $errors[] = "Email sudah terdaftar!";
    //     }

    //     if (strlen($password) < 8) {
    //         $errors[] = "Password minimal 8 karakter!";
    //     }

    //     if ($password !== $confirm) {
    //         $errors[] = "Konfirmasi password tidak cocok!";
    //     }

    //     if (!empty($errors)) {
    //         $_SESSION['register_errors'] = $errors;
    //         header("Location: index.php?action=register");
    //         exit;
    //     }

    //     // SIMPAN KE DATABASE (AKTIFKAN JIKA SUDAH SIAP)
    //     /*
    //     $this->pasienModel->insert([
    //         'email' => $email,
    //         'username' => $username,
    //         'password' => password_hash($password, PASSWORD_DEFAULT),
    //         'tanggal_lahir' => $tanggal_lahir,
    //         'jenis_kelamin' => $jenis_kelamin,
    //         'alamat' => $alamat,
    //         'no_hp' => $no_hp,
    //         'nik' => $nik
    //     ]);
    //     */

    //     $_SESSION['popup_success'] = "Registrasi berhasil!";
    //     header("Location: index.php?action=login");
    //     exit;
    // }

    public function Register()
    {
        include "View/Register.php";
    }

    public function KirimKodeVerifikasi()
    {
        if (!isset($_POST['register'])) {
            header("Location: index.php?action=register");
            exit;
        }

        // ambil data
        $data = [
            'nik' => trim($_POST['nik']),
            'email' => trim($_POST['email']),
            'username' => trim($_POST['username']),
            'password' => $_POST['password'],
            'confirm' => $_POST['confirm_password'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'jenis_kelamin' => $_POST['jenis_kelamin'],
            'alamat' => trim($_POST['alamat']),
            'no_hp' => trim($_POST['no_hp']),
        ];

        $errors = [];

        if (in_array('', $data, true)) {
            $errors[] = "Semua field wajib diisi.";
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid.";
        }

        if ($this->pasienModel->cekEmail($data['email'])) {
            $errors[] = "Email sudah terdaftar.";
        }

        if (strlen($data['password']) < 8) {
            $errors[] = "Password minimal 8 karakter.";
        }

        if ($data['password'] !== $data['confirm']) {
            $errors[] = "Konfirmasi password tidak cocok.";
        }

        if ($errors) {
            $_SESSION['register_errors'] = $errors;
            header("Location: index.php?action=register");
            exit;
        }

        // simpan data ke SESSION
        $_SESSION['register_data'] = $data;
        $_SESSION['reg_email'] = $data['email'];

        // buat & simpan kode
        $kode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = date('Y-m-d H:i:s', time() + 600);

        $this->pasienModel->simpanKodeVerifikasi($data['email'], $kode, $expiresAt);
        $this->mailService->kirimKodeVerifikasi($data['email'], $kode);

        header("Location: index.php?action=verif_email_page");
        exit;
    }

    public function RegisterVerifyCode()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit_kode'])) {
            header("Location: index.php?action=verif_email_page");
            exit;
        }

        $email = $_SESSION['reg_email'] ?? null;
        $data = $_SESSION['register_data'] ?? null;

        if (!$email || !$data) {
            $_SESSION['error'] = "Sesi registrasi berakhir.";
            header("Location: index.php?action=register");
            exit;
        }

        $kode = trim($_POST['kode']);

        if ($kode === '') {
            $_SESSION['error'] = "Kode wajib diisi.";
            header("Location: index.php?action=verif_email_page");
            exit;
        }

        $record = $this->pasienModel->cariKodeVerifikasi($email, $kode);

        if (!$record || $record['is_used'] || strtotime($record['expires_at']) < time()) {
            $_SESSION['error'] = "Kode verifikasi tidak valid.";
            header("Location: index.php?action=verif_email_page");
            exit;
        }

        if ($this->pasienModel->cekEmail($data['email'])) {
            $_SESSION['error'] = "Akun sudah terdaftar.";
            header("Location: index.php?action=login");
            exit;
        }

        error_log("INSERT PASIEN DIJALANKAN");

        // INSERT PASIEN
        $this->pasienModel->insert([
            'nik' => $data['nik'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp']
        ]);

        // ✅ TANDAI EMAIL SUDAH TERVERIFIKASI
        $this->pasienModel->setEmailVerified($data['email']);

        // TANDAI KODE TERPAKAI
        $this->pasienModel->tandaiKodeTerpakai($record['id']);

        unset($_SESSION['register_data'], $_SESSION['reg_email']);

        $_SESSION['popup_success'] = "Registrasi berhasil. Silakan login.";
        header("Location: index.php?action=login");
        exit;
    }

    // ================= LOGIN ===================
    public function Login(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include "View/Login.php";
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['login_error'] = "Email dan password wajib diisi.";
            header("Location: index.php?action=login");
            exit;
        }

        $user = $this->pasienModel->getByEmail($email);

        // 1️⃣ user tidak ada
        if (!$user) {
            $_SESSION['login_error'] = "Email atau Password salah!";
            header("Location: index.php?action=login");
            exit;
        }

        // 2️⃣ password salah
        if (!password_verify($password, $user['password'])) {
            $_SESSION['login_error'] = "Email atau Password salah!";
            header("Location: index.php?action=login");
            exit;
        }

        // 3️⃣ belum verifikasi email
        if ((int) $user['email_verified'] === 0) {
            $_SESSION['error'] = "Silakan verifikasi email terlebih dahulu.";
            header("Location: index.php?action=login");
            exit;
        }

        // 4️⃣ login sukses
        $_SESSION['pasien_id'] = $user['pasien_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nik'] = $user['nik'];

        header("Location: index.php?action=homepage");
        exit;
    }

    public function VerifEmailPage()
    {
        if (!isset($_SESSION['reg_email'])) {
            header('Location: index.php?action=register');
            exit;
        }

        include "View/VerifEmail.php";
    }



    public function Logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?action=homepage");
        exit;
    }

    // ================= HALAMAN ===================
    public function Homepage()
    {
        include "View/Homepage.php";
    }
    public function Tentang()
    {
        include "View/Tentangkami.php";
    }
    public function Layanan()
    {
        include "View/layanan.php";
    }
    public function Profile()
    {
        include "View/profile.php";
    }
    public function Fasilitas()
    {
        include "View/fasilitas.php";
    }
    public function Emergency()
    {
        include "View/emergencycall.php";
    }
    public function Temu()
    {
        if (!isset($_SESSION['pasien_id'])) {
            echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href='index.php';</script>";
            exit;
        }
        include "View/jadwal_temu.php";
    }
}
