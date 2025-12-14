<?php
include __DIR__ . "/template/header_dokter.php";
?>

<div class="container mt-5">
    <h1>Selamat Datang, <?= $_SESSION['dokter_nama']; ?></h1>
    <p>Login berhasil.</p>
    <a href="../index.php?aksi=logout" class="btn btn-danger">Logout</a>
</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>