<?php
session_start();
include "koneksi.php";

require_once "library/MailService.php";
require_once "controller/pasiencontroller.php";
require_once "controller/jadwalcontroller.php";
require_once "controller/doktercontroller.php";

$mailService = new MailService();

$pasiencontroller = new PasienController($conn, $mailService);
$doktercontroller = new DokterController($conn);
$jadwalcontroller = new JadwalController($conn);

$action = $_GET['action'] ?? 'homepage';

switch ($action) {
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
    case 'emergency':
        $pasiencontroller->Emergency();
        break;
    case 'temukandokter':
        $doktercontroller->Temukan();
        break;
    case 'verifikasi':
        $pasiencontroller->KirimKodeVerifikasi();
        break;
    case 'verif_email_page':
        $pasiencontroller->VerifEmailPage();
        break;
    case 'verif_email':
        $pasiencontroller->RegisterVerifyCode();
        break;
    case 'homepage':
        $pasiencontroller->Homepage();
    default:
        $pasiencontroller->Homepage();
        break;
}
