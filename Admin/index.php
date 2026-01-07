<?php
session_start();
include "../koneksi.php";
include "../controller/admincontroller.php";

$admincontroller = new AdminController($conn); // ⬅ kirim koneksi DB

$action = $_GET['action'] ?? 'admin_login';

// Proteksi: hanya blok halaman selain admin_login
if (!isset($_SESSION['admin_username']) && $action !== 'admin_login') {
    header("Location: index.php?action=admin_login");
    exit;
}

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
    case 'status_dokter':
        $admincontroller->StatusDokter();
        break;
    case 'get_dokter':
        $admincontroller->getDokter();
        break;
    case 'update_dokter':
        $admincontroller->updateDokter();   // sama persis namanya
        break;
    case 'delete_dokter':
        $admincontroller->deleteDokter();
        break;
    case 'tambah_dokter':
        $admincontroller->TambahDokter();
        break;
    case 'lihat_pasien':
        $admincontroller->LihatPasien();
        break;
    case 'pengaturan':
        $admincontroller->Pengaturan();
        break;
    case 'hapus_pasien':
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $admincontroller->HapusPasien($id);
        } else {
            echo "<script>
                    alert('ID pasien tidak diberikan.');
                    window.location.href = 'index.php?action=lihat_pasien';
                </script>";
        }
        break;
    default:
        $admincontroller->LoginPage();
        break;
}
?>