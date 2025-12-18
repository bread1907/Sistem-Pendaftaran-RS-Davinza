<?php
require '../koneksi.php'; // koneksi ke database

$username = 'Dinda';
$password = 'Radeon5000';
$nama     = 'Dinda Salsabila';

// HASH PASSWORD
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// INSERT
$query = "INSERT INTO admin (username, password, nama) VALUES (?, ?, ?)";
$stmt  = $conn->prepare($query);
$stmt->bind_param("sss", $username, $hashed_password, $nama);

if ($stmt->execute()) {
    echo "Admin berhasil dibuat";
} else {
    echo "Gagal: " . $stmt->error;
}
