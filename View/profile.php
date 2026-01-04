<?php include __DIR__ . "/Halaman/header.php"; ?>

<style>
/* ===== FORCE CLICK FIX (ANTI OVERLAY) ===== */
.table-responsive,
.table-responsive * {
    pointer-events: auto !important;
}

button, a {
    pointer-events: auto !important;
    position: relative !important;
    z-index: 9999 !important;
}
</style>

<div class="container my-5">
    <h2 class="mb-4 text-primary fw-bold">Profil Saya</h2>

<?php
if (!isset($_SESSION['pasien_id'])) {
    echo "<div class='alert alert-warning'>Silakan login terlebih dahulu.</div>";
} else {
    require_once __DIR__ . '/../Model/PasienModel.php';
    require_once __DIR__ . '/../Model/JadwalModel.php';
    global $conn;

    $pasienModel = new PasienModel($conn);
    $jadwalModel = new JadwalTemu($conn);

    $user = $pasienModel->getById($_SESSION['pasien_id']);
    $janjiTemu = $jadwalModel->getByPasienId($_SESSION['pasien_id']);
?>

<!-- ================= PROFIL ================= -->
<div class="card mb-5 shadow-lg border-0 rounded-4"
     style="background: linear-gradient(135deg, #6CC1FF, #3A8DFF); color:white;">
    <div class="card-body p-5">
        <div class="d-flex align-items-center gap-4">
            <div class="rounded-circle bg-white text-primary d-flex justify-content-center align-items-center"
                 style="width:80px; height:80px; font-size:36px;">
                <?= strtoupper($user['username'][0]); ?>
            </div>
            <div>
                <h3 class="fw-bold mb-1"><?= htmlspecialchars($user['username']); ?></h3>
                <p class="mb-0"><?= htmlspecialchars($user['email']); ?></p>
                <p class="mb-0"><?= htmlspecialchars($user['no_hp']); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- ================= JADWAL ================= -->
<h3 class="mb-3 text-primary fw-bold">Daftar Janji Temu</h3>

<div class="table-responsive">
<table class="table table-hover table-bordered bg-white">
<thead class="table-primary text-center">
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Jam</th>
    <th>Dokter</th>
    <th>Status</th>
    <th>Antrian</th>
    <th>Hasil Diagnosa</th>
</tr>
</thead>

<tbody class="text-center">
<?php
$no = 1;
if (!empty($janjiTemu)):
foreach ($janjiTemu as $jt):
$status = strtolower($jt['status']);
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $jt['tanggal_temu'] ?></td>
    <td><?= $jt['jam_temu'] ?></td>
    <td><?= $jt['nama'] ?? '-' ?></td>
    <td><?= ucfirst($jt['status']) ?></td>
    <td><?= $jt['nomor_antrian'] ?></td>
    <td>
        <?php if ($status === 'selesai'): ?>
            <button type="button"
                onclick="downloadPDF(<?= (int)$jt['jadwal_id'] ?>)"
                class="btn btn-success btn-sm">
                Download PDF
            </button>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; else: ?>
<tr>
    <td colspan="7">Belum ada janji temu</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

<?php } ?>
</div>

<script>
function downloadPDF(id) {
    console.log("klik", id);
    window.location.href = "download_diagnosa.php?jadwal_id=" + id;
}
</script>

<?php include __DIR__ . "/Halaman/footer.php"; ?>
