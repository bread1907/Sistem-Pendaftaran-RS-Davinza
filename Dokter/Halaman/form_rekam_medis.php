<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . "/template/header_dokter.php";

// Pastikan $existing ada, gunakan operator null coalescing
$status_existing = $existing['status'] ?? '';
?>

<div class="container mt-4">
  <h3>Input Rekam Medis</h3>

  <form method="POST" action="index.php?aksi=simpanrekammedis">
    <input type="hidden" name="pasien_id" value="<?= htmlspecialchars($pasien_id); ?>">
    <input type="hidden" name="jadwal_id" value="<?= htmlspecialchars($jadwal_id); ?>"> <!-- HARUS ADA -->

    <div class="mb-3">
      <label>Diagnosa</label>
      <input type="text" name="diagnosa" class="form-control" required
             value="<?= htmlspecialchars($existing['diagnosa'] ?? ''); ?>">
    </div>

    <div class="mb-3">
      <label>Tindakan Medis</label>
      <input type="text" name="tindakan" class="form-control" required
             value="<?= htmlspecialchars($existing['tindakan'] ?? ''); ?>">
    </div>

    <div class="mb-3">
      <label>Resep Obat</label>
      <input type="text" name="resep_obat" class="form-control"
             value="<?= htmlspecialchars($existing['resep_obat'] ?? ''); ?>">
    </div>

    <div class="mb-3">
      <label>Catatan</label>
      <textarea name="catatan" class="form-control"><?= htmlspecialchars($existing['catatan'] ?? ''); ?></textarea>
    </div>

    <div class="mb-3">
      <label>Status Jadwal</label>
      <select name="status" class="form-select" required>
        <option value="Pending" <?= ($status_existing == 'Pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="Selesai" <?= ($status_existing == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="index.php?aksi=daftarpasiendokter" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
