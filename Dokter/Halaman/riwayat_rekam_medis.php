<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Pastikan dokter sudah login
if (!isset($_SESSION['dokter_nama']) || !isset($_SESSION['dokter_id'])) {
    header("Location: index.php?aksi=login");
    exit;
}

include __DIR__ . "/template/header_dokter.php";

// Ambil spesialis dari session
$spesialis = $_SESSION['dokter_spesialis'] ?? 'Umum';

// Hitung total rekam medis
global $conn;
$total_rekam = 0;
if (isset($conn) && $conn instanceof mysqli) {
    $query_total = "SELECT COUNT(*) AS count FROM rekam_medis WHERE dokter_id = ?";
    $stmt = $conn->prepare($query_total);
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['dokter_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $total_rekam = $result->fetch_assoc()['count'];
        $stmt->close();
    }
}
?>

<div class="container py-4">
    <!-- HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-primary">
                <i class="bi bi-file-earmark-medical"></i> Riwayat Rekam Medis Pasien
            </h3>
            <div class="text-muted">
                Login sebagai: <b>Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?></b> |
                Spesialis: <?= htmlspecialchars($spesialis); ?>
            </div>
            <div class="text-muted small">
                Total Rekam Medis:
                <span class="badge bg-success"><?= $total_rekam; ?></span>
            </div>
        </div>

        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="index.php?aksi=homepagedokter" class="btn btn-outline-primary">
                <i class="bi bi-house"></i> Kembali ke Home
            </a>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <input type="text" id="searchInput" class="form-control"
                   placeholder="Cari berdasarkan nama pasien, diagnosa, atau tanggal...">
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (!$data || mysqli_num_rows($data) === 0): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle"></i>
                    Belum ada data rekam medis untuk pasien yang ditangani.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="medicalRecordTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Diagnosa</th>
                                <th>Tindakan</th>
                                <th class="d-none d-md-table-cell">Resep</th>
                                <th class="d-none d-lg-table-cell">Catatan</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['username']) ?></strong></td>
                                <td>
                                    <span class="badge bg-danger">
                                        <?= htmlspecialchars($row['diagnosa']) ?>
                                    </span>
                                </td>
                                <td><em><?= htmlspecialchars($row['tindakan']) ?></em></td>
                                <td class="d-none d-md-table-cell">
                                    <?= htmlspecialchars($row['resep_obat']) ?>
                                </td>
                                <td class="d-none d-lg-table-cell text-muted">
                                    <?= htmlspecialchars($row['catatan']) ?>
                                </td>
                                <td>
                                    <i class="bi bi-clock"></i>
                                    <?= htmlspecialchars($row['waktu_input']) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Filter tabel rekam medis
document.getElementById('searchInput').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll('#medicalRecordTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
