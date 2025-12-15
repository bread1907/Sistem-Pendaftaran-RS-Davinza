<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

global $conn;

// Pastikan koneksi database tersedia dan valid
if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Koneksi database tidak tersedia atau tidak valid. Periksa file koneksi Anda.");
}

// Ambil data dokter berdasarkan session
$dokter_id = $_SESSION['dokter_id'] ?? null;
if (!$dokter_id || !is_numeric($dokter_id)) {
    header("Location: index.php?aksi=login"); // Redirect jika tidak login atau ID tidak valid
    exit;
}

$query_dokter = "SELECT nama, spesialis, hari_praktek, jam_mulai, jam_selesai FROM dokter WHERE dokter_id = ?";
$stmt = $conn->prepare($query_dokter);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $dokter_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$result_dokter = $stmt->get_result();
$dokter = $result_dokter->fetch_assoc();
$stmt->close();

if (!$dokter) {
    die("Data dokter tidak ditemukan untuk ID: " . htmlspecialchars($dokter_id));
}

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

// Cek apakah hari ini adalah hari praktek
$hari_ini = $hari[date('l')];
$hari_praktek = explode(', ', $dokter['hari_praktek']);
$is_praktek_hari_ini = in_array($hari_ini, $hari_praktek);

// Statistik berdasarkan tabel jadwal_temu (jumlah pasien hari ini dan bulan ini)
$statistik = ['pasien_hari_ini' => 0, 'pasien_bulan_ini' => 0];
$query_statistik_hari = "SELECT COUNT(*) AS pasien_hari_ini FROM jadwal_temu WHERE DATE(tanggal_temu) = CURDATE() AND dokter_id = ? AND status IN ('Pending', 'Confirmed')"; // Filter status aktif
$query_statistik_bulan = "SELECT COUNT(*) AS pasien_bulan_ini FROM jadwal_temu WHERE MONTH(tanggal_temu) = MONTH(CURDATE()) AND YEAR(tanggal_temu) = YEAR(CURDATE()) AND dokter_id = ? AND status IN ('Pending', 'Confirmed')"; // Filter status aktif

// Query hari ini
$stmt_hari = $conn->prepare($query_statistik_hari);
if ($stmt_hari) {
    $stmt_hari->bind_param("i", $dokter_id);
    if ($stmt_hari->execute()) {
        $result_hari = $stmt_hari->get_result();
        $statistik['pasien_hari_ini'] = $result_hari->fetch_assoc()['pasien_hari_ini'];
    }
    $stmt_hari->close();
} else {
    error_log("Query hari ini gagal: " . $conn->error);
}

// Query bulan ini
$stmt_bulan = $conn->prepare($query_statistik_bulan);
if ($stmt_bulan) {
    $stmt_bulan->bind_param("i", $dokter_id);
    if ($stmt_bulan->execute()) {
        $result_bulan = $stmt_bulan->get_result();
        $statistik['pasien_bulan_ini'] = $result_bulan->fetch_assoc()['pasien_bulan_ini'];
    }
    $stmt_bulan->close();
} else {
    error_log("Query bulan ini gagal: " . $conn->error);
}

include __DIR__ . "/template/header_dokter.php";
?>

<div class="container py-4">
    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1 text-primary">
            <i class="bi bi-person-circle"></i> Selamat Datang, Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?>
        </h2>
        <div class="text-muted">
            <?= $hari[date('l')] ?>, <?= date('d F Y') ?> | Spesialis: <?= htmlspecialchars($dokter['spesialis']); ?>
        </div>
    </div>

    <!-- DASHBOARD UTAMA -->
    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-2 text-success">
                        <i class="bi bi-clipboard-data"></i> Dashboard Dokter RS Davinza
                    </h5>
                    <p class="text-muted mb-3">
                        Kelola jadwal, periksa daftar pasien, dan berikan pelayanan medis terbaik untuk kesehatan pasien.
                    </p>
                    <a href="index.php?aksi=daftarpasiendokter" class="btn btn-primary">
                        <i class="bi bi-list-ul"></i> Lihat Daftar Pasien
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- STATISTIK RINGKAS -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-check text-info" style="font-size: 2rem;"></i>
                    <h5 class="fw-bold mt-2">Pasien Hari Ini</h5>
                    <p class="text-muted mb-0 fs-4 fw-bold text-primary"><?= $statistik['pasien_hari_ini']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-success" style="font-size: 2rem;"></i>
                    <h5 class="fw-bold mt-2">Pasien Bulan Ini</h5>
                    <p class="text-muted mb-0 fs-4 fw-bold text-success"><?= $statistik['pasien_bulan_ini']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- JADWAL HARI INI -->
    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2 text-warning">
                        <i class="bi bi-clock"></i> Jadwal Hari Ini
                    </h5>
                    <p class="text-muted mb-3">
                        Hari Praktek: <?= htmlspecialchars($dokter['hari_praktek']); ?> | Jam: <?= htmlspecialchars($dokter['jam_mulai']); ?> - <?= htmlspecialchars($dokter['jam_selesai']); ?>
                    </p>
                    <?php if ($is_praktek_hari_ini): ?>
                        <span class="badge bg-success fs-6">Aktif - Anda sedang praktek hari ini</span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6">Tidak Aktif - Hari libur</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MENU TAMBAHAN -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-2 text-success">
                        <i class="bi bi-file-earmark-medical"></i> Riwayat Rekam Medis
                    </h5>
                    <p class="text-muted mb-3">
                        Akses riwayat diagnosis, tindakan medis, dan catatan kesehatan pasien yang pernah ditangani.
                    </p>
                    <a href="index.php?aksi=riwayatrekammedis" class="btn btn-outline-success">
                        <i class="bi bi-eye"></i> Lihat Rekam Medis
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-2 text-primary">
                        <i class="bi bi-person-badge"></i> Profil Dokter
                    </h5>
                    <p class="text-muted mb-3">
                        Kelola informasi akun, data pribadi, dan pengaturan profil Anda.
                    </p>
                    <span class="badge bg-secondary">Coming Soon</span>
                </div>
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2 text-danger">
                        <i class="bi bi-bell"></i> Notifikasi Penting
                    </h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-info-circle text-info"></i> Ingatkan pasien untuk vaksinasi rutin.</li>
                        <li><i class="bi bi-exclamation-triangle text-warning"></i> Sistem akan diperbarui pada pukul 22:00 WIB.</li>
                        <!-- Tambahkan notifikasi dinamis dari database jika diperlukan -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ILUSTRASI -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <img
                src="https://img.freepik.com/free-vector/doctor-character-background_1270-84.jpg"
                alt="Ilustrasi Dokter Profesional"
                class="img-fluid mb-3 rounded"
                style="max-height: 220px; object-fit: cover;"
            >
            <h5 class="fw-bold text-primary">
                Pelayanan Medis Profesional & Terpercaya
            </h5>
            <p class="text-muted mb-0">
                RS Davinza berkomitmen memberikan layanan kesehatan terbaik dengan sistem terintegrasi, modern, dan berfokus pada keselamatan pasien.
            </p>
        </div>
    </div>

    <!-- LOGOUT -->
    <div class="text-end">
        <a href="index.php?aksi=logout" class="btn btn-outline-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
