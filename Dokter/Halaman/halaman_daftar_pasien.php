<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Pastikan dokter sudah login
if (!isset($_SESSION['dokter_nama']) || !isset($_SESSION['dokter_id'])) {
    header("Location: index.php?aksi=login");
    exit;
}

include __DIR__ . "/template/header_dokter.php";

// Ambil spesialis dari session atau database (asumsikan diset saat login)
$spesialis = $_SESSION['dokter_spesialis'] ?? 'Umum'; // Ganti jika spesialis disimpan di session

// Hitung jumlah pasien hari ini (opsional, dari tabel jadwal_temu)
global $conn;
$pasien_hari_ini = 0;
if (isset($conn) && $conn instanceof mysqli) {
    $query_hari = "SELECT COUNT(*) AS count FROM jadwal_temu WHERE DATE(tanggal_temu) = CURDATE() AND dokter_id = ? AND status IN ('Pending', 'Confirmed')";
    $stmt = $conn->prepare($query_hari);
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['dokter_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $pasien_hari_ini = $result->fetch_assoc()['count'];
        $stmt->close();
    }
}
?>

<div class="container py-4">
    <!-- HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-primary">
                <i class="bi bi-list-ul"></i> Daftar Pasien Sesuai Jadwal Temu
            </h3>
            <div class="text-muted">
                Login sebagai: <b>Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?></b> | Spesialis: <?= htmlspecialchars($spesialis); ?>
            </div>
            <div class="text-muted small">
                Pasien Hari Ini: <span class="badge bg-info"><?= $pasien_hari_ini; ?></span>
            </div>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="index.php?aksi=homepagedokter" class="btn btn-outline-primary">
                <i class="bi bi-house"></i> Home
            </a>
            <a href="index.php?aksi=logout" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama pasien, tanggal, atau status...">
                </div>
                <div class="col-md-6">
                    <select id="statusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="selesai">Selesai</option>
                        <!-- Tambahkan opsi status lain jika ada -->
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (!isset($data) || !$data): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i> Data jadwal tidak ditemukan atau query gagal. Silakan coba lagi atau hubungi admin.
                </div>
            <?php else: ?>
                <?php if (mysqli_num_rows($data) === 0): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle"></i> Belum ada pasien terjadwal untuk dokter ini hari ini.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="patientTable">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th>No HP</th>
                                    <th class="d-none d-lg-table-cell">NIK</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>No Antrian</th>
                                    <th>Status</th>
                                    <th>Keluhan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                                    <?php
                                        $status = strtolower($row['status']);
                                        $badge = 'secondary';
                                        $badge_text = 'Tidak Diketahui';
                                        if (in_array($status, ['pending', 'menunggu'])) {
                                            $badge = 'warning';
                                            $badge_text = 'Menunggu';
                                        } elseif ($status === 'selesai') {
                                            $badge = 'success';
                                            $badge_text = 'Selesai';
                                        } elseif ($status === 'confirmed') {
                                            $badge = 'info';
                                            $badge_text = 'Dikonfirmasi';
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($row['username']) ?></strong>
                                        </td>
                                        <td class="d-none d-md-table-cell"><?= htmlspecialchars($row['email']) ?></td>
                                        <td>
                                            <a href="tel:<?= htmlspecialchars($row['no_hp']) ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone"></i> <?= htmlspecialchars($row['no_hp']) ?>
                                            </a>
                                        </td>
                                        <td class="d-none d-lg-table-cell"><?= htmlspecialchars($row['nik']) ?></td>
                                        <td>
                                            <i class="bi bi-calendar"></i> <?= htmlspecialchars($row['tanggal_temu']) ?>
                                        </td>
                                        <td>
                                            <i class="bi bi-clock"></i> <?= htmlspecialchars($row['jam_temu']) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary fs-6"><?= htmlspecialchars($row['nomor_antrian']) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $badge ?>">
                                                <?= htmlspecialchars($badge_text) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <em><?= htmlspecialchars($row['keluhan']) ?></em>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" 
                                               href="index.php?aksi=formrekammedis&jadwal_id=<?= urlencode($row['jadwal_id']) ?>&pasien_id=<?= urlencode($row['pasien_id']) ?>"
                                               data-bs-toggle="tooltip" title="Isi Diagnosa untuk Pasien Ini">
                                                <i class="bi bi-pencil-square"></i> Isi Diagnosa
                                            </a>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// JavaScript sederhana untuk filter real-time
document.getElementById('searchInput').addEventListener('keyup', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);

function filterTable() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const statusValue = document.getElementById('statusFilter').value.toLowerCase();
    const table = document.getElementById('patientTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;

        // Cek nama pasien, tanggal, atau status
        const name = cells[1].textContent.toLowerCase();
        const date = cells[5].textContent.toLowerCase();
        const status = cells[8].textContent.toLowerCase();

        if ((name.includes(searchValue) || date.includes(searchValue)) && (statusValue === '' || status.includes(statusValue))) {
            match = true;
        }

        rows[i].style.display = match ? '' : 'none';
    }
}

// Inisialisasi tooltip Bootstrap
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
