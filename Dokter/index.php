<?php
session_start();

include "../koneksi.php";
include "controller/controllerdokter.php";

$doktercontroller = new DokterController($conn);

// ROUTER
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] === 'loginProses') {
        $doktercontroller->loginProses();
        exit;
    }
}

// Jika sudah login, tampilkan homepage, jika belum tampilkan login
if (isset($_SESSION['dokter_logged_in']) && $_SESSION['dokter_logged_in'] === true) {
    $doktercontroller->home();
} else {
    $doktercontroller->LoginDokter();
}

?>
