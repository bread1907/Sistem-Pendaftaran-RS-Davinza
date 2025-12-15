<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

global $conn;

include __DIR__ . "/template/header_dokter.php";

// Konversi hari ke Bahasa Indonesia
$hari = [
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu'
];
?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            Selamat Datang, Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?>
        </h2>
        <div class="text-muted">
            <?= $hari[date('l')] ?>, <?= date('d F Y') ?>
        </div>
    </div>

    <!-- DASHBOARD UTAMA -->
    <div class="row g-4 mb-4">

        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">Dashboard Dokter RS Davinza</h5>
                    <p class="text-muted mb-3">
                        Silakan memeriksa daftar pasien sesuai jadwal temu
                        dan memberikan pelayanan medis terbaik.
                    </p>
                    <a href="index.php?aksi=daftarpasiendokter" class="btn btn-primary">
                        Lihat Daftar Pasien
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- MENU TAMBAHAN -->
    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">Riwayat Rekam Medis</h5>
                    <p class="text-muted mb-3">
                        Lihat riwayat diagnosa dan tindakan medis pasien
                        yang pernah ditangani.
                    </p>
                    <a href="index.php?aksi=riwayatrekammedis" class="btn btn-outline-success">
                        Lihat Rekam Medis
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">Profil Dokter</h5>
                    <p class="text-muted mb-3">
                        Informasi akun dan data pribadi dokter.
                    </p>
                    <span class="badge bg-secondary">Coming Soon</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ILUSTRASI -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <img
                src="https://img.freepik.com/free-vector/doctor-character-background_1270-84.jpg"
                alt="Dokter"
                class="img-fluid mb-3"
                style="max-height: 220px;"
            >
            <h5 class="fw-bold">
                Pelayanan Medis Profesional & Terpercaya
            </h5>
            <p class="text-muted mb-0">
                RS Davinza berkomitmen memberikan layanan kesehatan terbaik
                dengan sistem terintegrasi dan modern.
            </p>
        </div>
    </div>

    <!-- LOGOUT -->
    <div class="text-end">
        <a href="index.php?aksi=logout" class="btn btn-outline-danger">
            Logout
        </a>
    </div>

</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
