<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Pastikan dokter sudah login
if (!isset($_SESSION['dokter_nama']) || !isset($_SESSION['dokter_id'])) {
    header("Location: index.php?aksi=login");
    exit;
}

include __DIR__ . "/template/header_dokter.php";

// Ambil spesialis dari session atau database (asumsikan diset saat login)
$spesialis = $_SESSION['dokter_spesialis'] ?? 'Umum';

// Hitung total rekam medis (opsional, dari tabel rekam_medis)
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
                Login sebagai: <b>Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?></b> | Spesialis: <?= htmlspecialchars($spesialis); ?>
            </div>
            <div class="text-muted small">
                Total Rekam Medis: <span class="badge bg-success"><?= $total_rekam; ?></span>
            </div>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="index.php?aksi=homepagedokter" class="btn btn-outline-primary">
                <i class="bi bi-house"></i> Kembali ke Home
            </a>
            <button class="btn btn-outline-secondary" onclick="exportToPDF()">
                <i class="bi bi-download"></i> Export PDF
            </button>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama pasien, diagnosa, atau tanggal...">
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (!$data || mysqli_num_rows($data) === 0): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle"></i> Belum ada data rekam medis untuk pasien yang ditangani.
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
                                    <td>
                                        <strong><?= htmlspecialchars($row['username']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger"><?= htmlspecialchars($row['diagnosa']) ?></span>
                                    </td>
                                    <td>
                                        <em><?= htmlspecialchars($row['tindakan']) ?></em>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <small><?= htmlspecialchars($row['resep_obat']) ?></small>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <small class="text-muted"><?= htmlspecialchars($row['catatan']) ?></small>
                                    </td>
                                    <td>
                                        <i class="bi bi-clock"></i> <?= htmlspecialchars($row['waktu_input']) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <!-- PAGINATION PLACEHOLDER (jika data banyak, implementasikan di controller) -->
                <nav aria-label="Pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <span class="page-link">Sebelumnya</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">Selanjutnya</span>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// JavaScript sederhana untuk filter
document.getElementById('searchInput').addEventListener('keyup', filterTable);

function filterTable() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const table = document.getElementById('medicalRecordTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;

        // Cek nama pasien, diagnosa, atau waktu
        const name = cells[1].textContent.toLowerCase();
        const diagnosis = cells[2].textContent.toLowerCase();
        const time = cells[6].textContent.toLowerCase();

        if (name.includes(searchValue) || diagnosis.includes(searchValue) || time.includes(searchValue)) {
            match = true;
        }

        rows[i].style.display = match ? '' : 'none';
    }
}

// Fungsi export placeholder
function exportToPDF() {
    alert('Fitur export PDF belum diimplementasikan. Silakan hubungi developer.');
}

// Inisialisasi tooltip Bootstrap (jika masih ada tooltip lain, tapi dihapus dari tabel)
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
