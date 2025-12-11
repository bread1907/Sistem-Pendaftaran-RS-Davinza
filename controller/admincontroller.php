<?php
class AdminController{

    private $model;

    public function __construct(){
        include_once "../model/AdminModel.php";
        global $conn;
        $this->model = new AdminModel($conn);
    }

    // halaman login admin
    public function LoginPage(){
        if (isset($_SESSION['admin_username'])) {
            header("Location: index.php?action=dashboard");
            exit;
        }

        include "../Admin/AdminLogin.php";
    }


    public function Login(){
        if (isset($_POST['login'])) {
            $username = $_POST['admin_name'];
            $password = $_POST['admin_pass'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $result = $this->model->login($username, $password);
            //var_dump($result); die(); // CEK APA YANG DIKEMBALIKAN

            if ($result) {
                // set session                
                $_SESSION['admin_username'] = $result['username'];

                // redirect to dashboard
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $msg = "Gagal! Username atau password salah!";
                $_SESSION['login_error'] = $msg;
                header("Location: index.php?action=admin_login");
                exit;
            }
        }
        include "../Admin/AdminLogin.php";
    }

    public function Dashboard(){
        include "../Admin/Dashboard.php";
    }

    public function Logout(){
        session_destroy();
        header("Location: index.php");
    }
}
