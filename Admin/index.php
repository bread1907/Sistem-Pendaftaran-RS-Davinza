<?php
    session_start();
    include "../koneksi.php";

    include "../controller/admincontroller.php";

    $admincontroller = new AdminController($conn);

    $action = $_GET['action'] ?? 'admin_login';

    switch($action){
        case 'admin_login':
            $admincontroller->LoginPage();
            break;
        default:
            $admincontroller->LoginPage();
            break;
    }

?>