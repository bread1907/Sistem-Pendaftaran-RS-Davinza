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
        case 'logout':
            $admincontroller->Logout();
            break;
        case 'lihat_dokter':
            $admincontroller->LihatDokter();
            break;
        case 'lihat_pasien':
            $admincontroller->LihatPasien();
            break;
        case 'pengaturan':
            $admincontroller->Pengaturan();
            break;
        default:
            $admincontroller->LoginPage();
            break;
    }
?>