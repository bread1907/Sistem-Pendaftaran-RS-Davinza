<?php
class AdminController {

    private $model;

    public function __construct() {
        include_once "Model/AdminModel.php";
        global $conn;
        $this->model = new AdminModel($conn);
    }

    // halaman login admin
    public function LoginPage() {
        include "Views/admin/login.php";
    }

    public function Login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $admin = $this->model->login($username, $password);

        if ($admin) {
            $_SESSION['admin'] = $admin;
            header("Location: index.php?action=admin_dashboard");
        } else {
            echo "<script>alert('Login gagal'); window.location='index.php?action=admin_login';</script>";
        }
    }

    public function Dashboard() {
        include "Views/admin/dashboard.php";
    }

    public function Logout() {
        session_destroy();
        header("Location: index.php");
    }
}
