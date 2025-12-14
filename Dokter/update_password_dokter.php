<?php
include "../koneksi.php";

// Ambil semua dokter
$result = mysqli_query($conn, "SELECT dokter_id, nama FROM dokter");

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $dokter_id = $row['dokter_id'];
    $nama_lengkap = trim($row['nama']);

    // Ambil nama depan dari nama lengkap
    $nama_depan = explode(" ", $nama_lengkap)[1] ?? explode(" ", $nama_lengkap)[0];
    
    // Buat password default: namadepan + 123
    $password_plain = strtolower($nama_depan) . "123";

    // Hash password
    $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

    // Update database
    $update = mysqli_query($conn, "UPDATE dokter SET password='$password_hash' WHERE dokter_id=$dokter_id");

    if ($update) {
        echo "Password dokter ID $dokter_id berhasil diupdate. Password: $password_plain<br>";
    } else {
        echo "Gagal update dokter ID $dokter_id: " . mysqli_error($conn) . "<br>";
    }
}

echo "<br>Semua password dokter berhasil diupdate!";
