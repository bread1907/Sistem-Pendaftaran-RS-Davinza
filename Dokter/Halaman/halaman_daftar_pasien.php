<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['dokter_login'])) {
    header("Location: index.php?aksi=login");
    exit;
}

include __DIR__ . "/template/header_dokter.php";

/* ================= KELOMPOK DATA PER BULAN ================= */
$jadwal_per_bulan = [];

if (isset($data) && $data) {
    while ($row = mysqli_fetch_assoc($data)) {
        $bulan = date('Y-m', strtotime($row['tanggal_temu']));
        $jadwal_per_bulan[$bulan][] = $row;
    }
}
?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary">
                <i class="bi bi-calendar3"></i> Daftar Pasien per Bulan
            </h3>
            <div class="text-muted">
                Dokter: <b>Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?></b>
            </div>
        </div>
        <a href="index.php?aksi=logout" class="btn btn-outline-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    <!-- FILTER -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control"
                           placeholder="Cari nama pasien atau tanggal...">
                </div>
                <div class="col-md-6">
                    <select id="statusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($jadwal_per_bulan)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-info-circle"></i> Belum ada jadwal pasien.
        </div>
    <?php else: ?>

        <?php foreach ($jadwal_per_bulan as $bulan => $rows): ?>
            <?php $nama_bulan = date('F Y', strtotime($bulan . '-01')); ?>

            <!-- CARD BULAN -->
            <div class="card shadow-sm mb-4 bulan-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-event"></i> <?= $nama_bulan ?>
                    </h5>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle patientTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Antrian</th>
                                <th>Status</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($rows as $row): ?>
                                <?php
                                    $status = strtolower($row['status']);
                                    $badge  = $status === 'selesai' ? 'success' : 'warning';
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="nama"><?= htmlspecialchars($row['username']); ?></td>
                                    <td class="tanggal"><?= htmlspecialchars($row['tanggal_temu']); ?></td>
                                    <td><?= htmlspecialchars($row['jam_temu']); ?></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($row['nomor_antrian']); ?>
                                        </span>
                                    </td>
                                    <td class="status">
                                        <span class="badge bg-<?= $badge ?>">
                                            <?= htmlspecialchars($row['status']); ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($row['keluhan']); ?></td>
                                    <td>
                                        <!-- TOMBOL DIAGNOSA SELALU ADA -->
                                        <a
                                            href="index.php?aksi=formrekammedis&jadwal_id=<?= urlencode($row['jadwal_id']); ?>&pasien_id=<?= urlencode($row['pasien_id']); ?>"
                                            class="btn btn-sm btn-primary mb-1"
                                        >
                                            <i class="bi bi-pencil-square"></i> Isi Diagnosa
                                        </a>

                                        <?php if ($status === 'selesai'): ?>
                                            <div>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Selesai
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>

</div>

<script>
function filterAllTables() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value.toLowerCase();

    document.querySelectorAll('.patientTable tbody tr').forEach(row => {
        const nama = row.querySelector('.nama').textContent.toLowerCase();
        const tanggal = row.querySelector('.tanggal').textContent.toLowerCase();
        const rowStatus = row.querySelector('.status').textContent.toLowerCase();

        const matchSearch = nama.includes(search) || tanggal.includes(search);
        const matchStatus = status === '' || rowStatus.includes(status);

        row.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}

document.getElementById('searchInput').addEventListener('keyup', filterAllTables);
document.getElementById('statusFilter').addEventListener('change', filterAllTables);
</script>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
