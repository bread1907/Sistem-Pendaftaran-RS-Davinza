<?php
$host     = "localhost";   // Server MySQL
$user     = "root";        // Username default XAMPP
$pass     = "";            // Password default XAMPP = kosong
$db       = "davinza";  // Ganti sesuai nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
