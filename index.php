<?php
session_start();
include "koneksi.php";

include "controller/pasiencontroller.php";

$pasiencontroller = new PasienController();
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
    default:
        $pasiencontroller->Homepage();
        break;
}
