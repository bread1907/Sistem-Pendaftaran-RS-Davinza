<?php
session_start();

require_once "../koneksi.php";
require_once __DIR__ . "/controller/controllerdokter.php";

$controller = new DokterController($conn);

$aksi = strtolower($_GET['aksi'] ?? 'login');

switch ($aksi) {
    case 'login':
        $controller->login();
        break;

    case 'loginproses':
        $controller->LoginProses(); // method kamu
        break;

    case 'homepagedokter':
        $controller->homepage();
        break;

    case 'daftarpasiendokter':
        $controller->daftarPasien();
        break;

    case 'logout':
        $controller->logout();
        break;
    case 'formrekammedis':
        $controller->formRekamMedis();
        break;

    case 'simpanrekammedis':
        $controller->simpanRekamMedis();
        break;

    case 'riwayatrekammedis':
        $controller->riwayatRekamMedis();
        break;

    default:
        $controller->login();
        break;
}
