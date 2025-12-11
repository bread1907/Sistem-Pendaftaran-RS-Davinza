<?php
// session_start(); <-- jangan panggil di sini

if (!isset($_SESSION['dokter_logged_in']) || $_SESSION['dokter_logged_in'] !== true) {
    header("Location: logindokter.php");
    exit;
}

$current = 'home';   // <<< TAMBAHKAN INI

require_once __DIR__ . "/template/header_dokter.php";
?>

<div class="container mt-4">
    <h2>Selamat datang, <?= htmlspecialchars($_SESSION['dokter_nama']); ?></h2>
    <p>Spesialis: <?= htmlspecialchars($_SESSION['dokter_spesialis']); ?></p>
    <a href="logindokter.php?logout=1" class="btn btn-danger">Logout</a>
</div>

<?php require_once __DIR__ . "/template/footer_dokter.php"; ?>
