<?php
session_start();

// Hanya dokter yang login yang bisa mengakses
if (!isset($_SESSION['dokter_id'])) {
    header("Location: logindokter.php");
    exit;
}

// Load header template
require_once __DIR__ . "/template/header_dokter.php";
$current = 'home';
?>

<div class="wrapper container mt-4">

    <!-- Welcome Card -->
    <div class="card mb-4 shadow-sm text-center" style="background: #00629B; color: white; border-radius: 12px;">
        <div class="card-body">
            <h2>Selamat Datang, Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?>!</h2>
            <p>Dashboard dokter RS Davinza</p>
        </div>
    </div>

    <!-- Menu Fitur Sesuai Use Case -->
    <div class="row g-4">

        <!-- Jadwal Pasien Hari Ini -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-calendar-check fa-2x mb-3 text-success"></i>
                    <h5 class="card-title">Jadwal Pasien Hari Ini</h5>
                    <p class="card-text">Lihat daftar pasien sesuai jadwal temu.</p>
                    <a href="jadwaldokter.php" class="btn btn-success">Buka</a>
                </div>
            </div>
        </div>

        <!-- Input Diagnosa & Tindakan -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-notes-medical fa-2x mb-3 text-warning"></i>
                    <h5 class="card-title">Input Diagnosa & Tindakan</h5>
                    <p class="card-text">Isi diagnosa, resep obat, tindakan, dan saran lanjutan pasien.</p>
                    <a href="input_diagnosa.php" class="btn btn-warning text-white">Buka</a>
                </div>
            </div>
        </div>

        <!-- Rekam Medis Pasien -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-file-medical fa-2x mb-3 text-danger"></i>
                    <h5 class="card-title">Rekam Medis Pasien</h5>
                    <p class="card-text">Akses dan perbarui riwayat rekam medis digital pasien.</p>
                    <a href="rekammedis.php" class="btn btn-danger">Buka</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Logout Button -->
<div class="container text-end mt-4">
    <a href="logoutdokter.php" class="btn btn-danger">Logout</a>
</div>

<?php
require_once __DIR__ . "/template/footer_dokter.php";
?>
