<?php
session_start(); // Hanya di sini

// Load koneksi database
include "../koneksi.php"; 

// Load controller
include "controller/controllerdokter.php";

$doktercontroller = new DokterController($conn);

// Jika sudah login, tampilkan homepage, jika belum tampilkan login
if (isset($_SESSION['dokter_logged_in']) && $_SESSION['dokter_logged_in'] === true) {
    $doktercontroller->home();
} else {
    $doktercontroller->LoginDokter();
}
?>
