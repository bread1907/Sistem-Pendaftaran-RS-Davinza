<?php
session_start();
include "koneksi.php";

include "controller/pasiencontroller.php";
include "controller/jadwalcontroller.php";


$pasiencontroller = new PasienController();
$doktercontroller = new DokterController();
$jadwalcontroller = new JadwalController($conn); // kirim koneksi ke controller

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
        $pasiencontroller->Temu(); // menampilkan form jadwal
        break;
    case 'simpan_jadwal':
        $jadwalcontroller->save(); // mengeksekusi insert jadwal
        break;
    case 'profile':
        $pasiencontroller->Profile();
        break;
    case 'fasilitas':
        $pasiencontroller->Fasilitas();
        break;
    case 'temukandokter':
        $doktercontroller->Temukan();
        break;
    
    // case 'login_dokter':
    //     // membuka halaman login dokter
    //     require "View/Halaman/login_dokter.php";
    //     break;

    // case 'login_dokter_proses':
    //     // memproses login dokter
    //     require "Controller/LoginDokterController.php";
    //     break;

    // case 'homepage_dokter':
    //     // halaman dashboard dokter
    //     $doktercontroller->HomepageDokter();
    //     break;

    default:
        $pasiencontroller->Homepage();
        break;
}
?>
