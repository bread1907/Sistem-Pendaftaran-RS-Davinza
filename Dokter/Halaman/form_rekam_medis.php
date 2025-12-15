<?php include __DIR__ . "/template/header_dokter.php"; ?>

<div class="container mt-4">
  <h3>Input Rekam Medis</h3>

  <form method="POST" action="index.php?aksi=simpanrekammedis">

    <!-- <input type="hidden" name="dokter_id" value="<?= $dokter_id ?>"> -->
    <input type="hidden" name="pasien_id" value="<?= $pasien_id ?>">

    <div class="mb-3">
      <label>Diagnosa</label>
      <input type="text" name="diagnosa" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Tindakan Medis</label>
      <input type="text" name="tindakan" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Resep Obat</label>
      <input type="text" name="resep_obat" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Catatan / Saran</label>
      <textarea name="catatan" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-success">
      Simpan Rekam Medis
    </button>
    <a href="index.php?aksi=daftarpasiendokter" class="btn btn-secondary">
      Kembali
    </a>
  </form>
</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
