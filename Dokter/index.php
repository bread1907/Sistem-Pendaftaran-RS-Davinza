<?php
session_start();
require_once "../koneksi.php";
require_once "controller/controllerdokter.php";

$controller = new DokterController($conn);

$aksi = $_GET['aksi'] ?? '';

if ($aksi === 'loginProses') {
    $controller->loginProses();
    exit;
} elseif ($aksi === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Jika sudah login, redirect ke homepage
if (isset($_SESSION['dokter_login']) && $_SESSION['dokter_login'] === true) {
    header("Location: Halaman/homepagedokter.php");
    exit;
}

// Tampilkan halaman login
include "Halaman/logindokter.php";
