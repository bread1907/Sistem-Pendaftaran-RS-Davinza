<?php
session_start();
include "koneksi.php";

include "controller/pasiencontroller.php";
include "controller/jadwalcontroller.php";
include "controller/doktercontroller.php";

$pasiencontroller = new PasienController($conn);
$doktercontroller = new DokterController($conn);
$jadwalcontroller = new JadwalController($conn);

$action = $_GET['action'] ?? 'homepage';

switch($action){
    case 'register':
        $pasiencontroller->Register();
        break;
    case 'login':
        $pasiencontroller->Login();
        break;
    case 'logout':
        $pasiencontroller->Logout();
        break;
    case 'tentangkami':
        $pasiencontroller->Tentang();
        break;
    case 'layanan':
        $pasiencontroller->Layanan();
        break;
    case 'janjitemu':
        $jadwalcontroller->save();
        break;
    case 'profile':
        $pasiencontroller->Profile();
        break;
    case 'fasilitas':
        $pasiencontroller->Fasilitas();
        break;
    case 'emergency':
        $pasiencontroller->Emergency();
        break;
    case 'temukandokter':
        $doktercontroller->Temukan();
        break;
    default:
        $pasiencontroller->Homepage();
        break;
}
?>
