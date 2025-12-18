<?php
class AdminController
{

    private $model;

    public function __construct()
    {
        include_once "../model/AdminModel.php";
        global $conn;
        $this->model = new AdminModel($conn);
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



    public function Dashboard()
    {
        // Fetch dashboard statistics
        $totalPatients = $this->model->getTotalPatients();
        $totalDoctors = $this->model->getTotalDoctors();
        $appointmentsToday = $this->model->getAppointmentsToday();
        $completedToday = $this->model->getCompletedAppointmentsToday();
        $roomOccupancy = $this->model->getRoomOccupancy();
        $departmentStats = $this->model->getDepartmentStats();

        // Pass data to view
        $data = [
            'totalPatients' => $totalPatients,
            'totalDoctors' => $totalDoctors,
            'appointmentsToday' => $appointmentsToday,
            'completedToday' => $completedToday,
            'roomOccupancy' => $roomOccupancy,
            'departmentStats' => $departmentStats
        ];

        extract($data);
        include "../Admin/Dashboard.php";
    }

    public function Dokter()
    {
        // Fetch doctor statistics
        $totalDoctors = $this->model->getTotalDoctors();
        $totalSpecializations = $this->model->getTotalSpecializations();
        $averagePatientsPerDay = $this->model->getAveragePatientsPerDay();

        // Fetch all doctors
        include_once "../model/DokterModel.php";
        global $conn;
        $dokterModel = new DokterModel($conn);
        $doctors = $dokterModel->getAll();

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

    public function Pengaturan()
    {
        include "../Admin/Pengaturan.php";
    }

    public function Logout()
    {
        session_start();
        session_destroy();
        header("Location: index.php");
    }

}
