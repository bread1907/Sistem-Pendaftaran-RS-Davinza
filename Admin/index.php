<?php
    session_start();
    include "../koneksi.php";
    include "../controller/admincontroller.php";

    $admincontroller = new AdminController($conn); // ⬅ kirim koneksi DB

    $action = $_GET['action'] ?? 'admin_login';

    switch ($action) {
        case 'admin_login':
            $admincontroller->Login();
            break;
        case 'dashboard':
            $admincontroller->Dashboard();
            break;
        default:
            $admincontroller->LoginPage();
            break;
    }
?>