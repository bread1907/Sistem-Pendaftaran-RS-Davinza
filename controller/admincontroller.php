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

    public function Login()
    {
        if (isset($_POST['login'])) {
            $username = $_POST['admin_name'];
            $password = $_POST['admin_pass'];

            $result = $this->model->login($username, $password);

            if ($result) {
                session_regenerate_id(true);

                $_SESSION['admin_username'] = $result['username'];
                $_SESSION['admin_login'] = true;

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
        include "../Admin/Dashboard.php";
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
