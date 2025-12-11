<?php
// Mengimpor file controller dan koneksi
include "controller/controllerdokter.php";
include "../koneksi.php"; // Pastikan ini adalah file yang mengatur koneksi ke database

// Membuat objek koneksi ke database
// Jika kamu menggunakan PDO di koneksi, maka $conn adalah objek PDO
$doktercontroller = new DokterController($conn); // Mengirimkan koneksi ke konstruktor

// Mendapatkan parameter 'action' dari URL atau default ke 'login'
$action = $_GET['action'] ?? 'login';

// Memilih aksi yang sesuai berdasarkan parameter 'action'
switch ($action) {
    case 'login':
        $doktercontroller->LoginDokter(); // Memanggil metode login
        break;
    case 'HomepageDokter':
        $doktercontroller->home(); // Memanggil metode home untuk halaman utama dokter
        break;
    default:
        // Bisa juga menambahkan pengaturan untuk default action jika diperlukan
        echo "Aksi tidak dikenali!";
        break;
}
?>
