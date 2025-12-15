<?php
include __DIR__ . "/template/header_dokter.php";
?>

<div class="container mt-5">
    <h1>Selamat Datang, <?= $_SESSION['dokter_nama']; ?></h1>
    <p>Login berhasil.</p>

    <div class="row mt-4 g-3">

        <div class="col-md-4">
            <a href="index.php?aksi=daftarpasiendokter" class="btn btn-primary w-100">
                Daftar Pasien
            </a>
        </div>

        <div class="col-md-4">
            <a href="index.php?aksi=riwayatrekammedis" class="btn btn-success w-100">
                Riwayat Rekam Medis
            </a>
        </div>

        <div class="col-md-4">
            <a href="index.php?aksi=logout" class="btn btn-danger w-100">
                Logout
            </a>
        </div>

    </div>
</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
