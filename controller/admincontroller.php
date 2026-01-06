<?php
class AdminController
{

    private $model;
    private $dokterModel;

    public function __construct()
    {
        include_once "../model/AdminModel.php";
        global $conn;
        $this->model = new AdminModel($conn);
        $this->dokterModel = new DokterModel($conn);
    }

    // halaman login admin
    public function LoginPage()
    {
        if (isset($_SESSION['admin_username'])) {
            header("Location: index.php?action=dashboard");
            exit;
        }

        include "../Admin/AdminLogin.php";
    }

    public function Login() {
        //session_start();

        if (isset($_POST['login'])) {
            $username = $_POST['admin_name'];
            $password = $_POST['admin_pass'];

            $admin = $this->model->login($username);

            if ($admin && password_verify($password, $admin['password'])) {

                session_regenerate_id(true); // AMAN

                $_SESSION['admin_login']    = true;
                $_SESSION['admin_id']       = $admin['admin_id'];
                $_SESSION['admin_username'] = $admin['username'];

                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $_SESSION['login_error'] = "Gagal! Username atau password salah!";
                header("Location: index.php?action=admin_login");
                exit;
            }
        }

        include "../Admin/AdminLogin.php";
    }

    public function Dashboard(){
        // Fetch dashboard statistics
        $totalPatients = $this->model->getTotalPatients();
        $totalDoctors = $this->model->getTotalDoctors();
        $appointmentsToday = $this->model->getAppointmentsToday();
        $completedToday = $this->model->getCompletedAppointmentsToday();
        $roomOccupancy = $this->model->getRoomOccupancy();
        //$departmentStats = $this->model->getDepartmentStats();

        // Pass data to view
        $data = [
            'totalPatients' => $totalPatients,
            'totalDoctors' => $totalDoctors,
            'appointmentsToday' => $appointmentsToday,
            'completedToday' => $completedToday,
            'roomOccupancy' => $roomOccupancy,
            //'departmentStats' => $departmentStats
        ];

        extract($data);
        include "../Admin/Dashboard.php";
    }

    public function LihatDokter() {
        $doctors = $this->dokterModel->getAllWithStatus();
        include "../Admin/Dokter.php";
    }

    // AJAX — detail dokter (eye & pencil)
    public function getDokter() {
        header('Content-Type: application/json');
        echo json_encode(
            $this->dokterModel->getById($_GET['id'])
        );
    }

    public function updateDokter() {
        $this->dokterModel->updateById($_POST);
        header("Location: index.php?action=lihat_dokter");
    }

    public function deleteDokter() {
        $this->dokterModel->deleteById($_GET['id']);
        header("Location: index.php?action=lihat_dokter");
    }

    public function StatusDokter() {
        header('Content-Type: application/json');
        echo json_encode($this->dokterModel->getAllWithStatus());
    }

    public function TambahDokter() {
        // simple validation
        if (empty($_POST['nama']) || empty($_POST['spesialis']) || empty($_POST['username']) || empty($_POST['password'])) {
            // bisa simpan flash message atau query string error
            header("Location: ../index.php?action=lihat_dokter");
            exit;
        }

        // mapping data
        $data = [
            'dokter_id'     => $_POST['dokter_id'] ?? null,
            'nama'          => $_POST['nama'] ?? '',
            'spesialis'     => $_POST['spesialis'] ?? '',
            'hari_praktek'  => $_POST['hari_praktek'] ?? '',
            'jam_mulai'     => $_POST['jam_mulai'] ?? '',
            'jam_selesai'   => $_POST['jam_selesai'] ?? '',
            'no_str'        => $_POST['no_str'] ?? '',
            'username'      => $_POST['username'] ?? '',
            'nip'           => $_POST['nip'] ?? '',
            'foto'          => $_POST['foto'] ?? '',
            'password'      => $_POST['password'] ?? '',
        ];

        $ok = $this->dokterModel->insert($data);

        // setelah insert, kembali ke list dokter
        header("Location: ../index.php?action=lihat_dokter");
        exit;
    }

    public function Dokter(){
        // Fetch doctor statistics
        $totalDoctors = $this->model->getTotalDoctors();
        $totalSpecializations = $this->model->getTotalSpecializations();
        $averagePatientsPerDay = $this->model->getAveragePatientsPerDay();

        // Fetch all doctors
        include_once "../model/DokterModel.php";
        global $conn;
        $dokterModel = new DokterModel($conn);
        $doctors = $dokterModel->getAllDokterWithStatus();

        // Pass data to view
        $data = [
            'totalDoctors' => $totalDoctors,
            'totalSpecializations' => $totalSpecializations,
            'averagePatientsPerDay' => $averagePatientsPerDay,
            'doctors' => $doctors
        ];

        extract($data);
        include "../Admin/Dokter.php";
    }

    public function Pengaturan(){
        include "../Admin/Pengaturan.php";
    }

    public function Logout(){
        session_start();
        session_destroy();
        header("Location: index.php");
    }

}
