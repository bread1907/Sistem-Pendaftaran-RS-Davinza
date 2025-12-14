<?php
session_start();
require_once "../koneksi.php";
require_once "controller/controllerdokter.php";

$controller = new DokterController($conn);

$aksi = $_GET['aksi'] ?? 'login';

switch($aksi){
    case 'loginProses':
        $controller->loginProses();
        break;
    case 'homepagedokter':
        $controller->homepage();
        break;
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
}?>
