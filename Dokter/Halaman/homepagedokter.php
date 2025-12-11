<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Amankan halaman: Jika dokter belum login → redirect
//if (!isset($_SESSION['dokter_id'])) {
    //header("Location: index.php?action=HomepageDokter");
    //exit;
//}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Dokter - RS Davinza</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

<?php include __DIR__ . "/header.php"; ?>

<div class="container py-5">

    <!-- HEADER DOKTER -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Selamat Datang, Dr. <?= $_SESSION['dokter_nama'] ?? "Dokter"; ?></h1>
        <p class="text-secondary fs-5">
            Spesialis: <?= $_SESSION['spesialis'] ?? "-"; ?>
        </p>

        <?php if (isset($_SESSION['login_success'])): ?>
            <div class="alert alert-success mt-3"><?= $_SESSION['login_success']; ?></div>
            <?php unset($_SESSION['login_success']); ?>
        <?php endif; ?>
    </div>

    <!-- CARD STATISTIK -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="p-4 bg-primary text-white rounded-4 shadow">
                <h3>35</h3>
                <p>Janji Temu Hari Ini</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-success text-white rounded-4 shadow">
                <h3>120</h3>
                <p>Total Pasien Minggu Ini</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-info text-white rounded-4 shadow">
                <h3>98%</h3>
                <p>Kepuasan Pasien</p>
            </div>
        </div>
    </div>

    <!-- MENU DOKTER -->
    <div class="mt-5">
        <h3 class="fw-bold mb-4">Menu Dokter</h3>

        <div class="row g-4">

            <!-- DAFTAR PASIEN SESUAI JADWAL -->
            <div class="col-md-4">
                <a href="index.php?action=jadwaltemu_dokter" class="text-decoration-none">
                    <div class="p-4 border rounded-4 shadow-sm text-center">
                        <h5>Daftar Pasien (Jadwal Temu)</h5>
                    </div>
                </a>
            </div>

            <!-- INPUT DIAGNOSA & RESEP -->
            <div class="col-md-4">
                <a href="index.php?action=input_diagnosa" class="text-decoration-none">
                    <div class="p-4 border rounded-4 shadow-sm text-center">
                        <h5>Input Diagnosa & Resep</h5>
                    </div>
                </a>
            </div>

            <!-- RIWAYAT REKAM MEDIS -->
            <div class="col-md-4">
                <a href="index.php?action=rekam_medis" class="text-decoration-none">
                    <div class="p-4 border rounded-4 shadow-sm text-center">
                        <h5>Riwayat Rekam Medis Pasien</h5>
                    </div>
                </a>
            </div>

            <!-- PROFIL DOKTER -->
            <div class="col-md-4">
                <a href="index.php?action=profil_dokter" class="text-decoration-none">
                    <div class="p-4 border rounded-4 shadow-sm text-center">
                        <h5>Profil Saya</h5>
                    </div>
                </a>
            </div>

        </div>
    </div>

</div>

<?php include __DIR__ . "/footer.php"; ?>

</body>
</html>
