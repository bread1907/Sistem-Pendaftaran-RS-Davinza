<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . "/template/header_dokter.php";
?>

<div class="container py-4">
  <h3 class="mb-3">Riwayat Rekam Medis Pasien</h3>

  <a href="index.php?aksi=homepagedokter" class="btn btn-outline-primary mb-3">
    Kembali ke Home
  </a>

  <div class="card shadow-sm">
    <div class="card-body">

      <?php if (!$data || mysqli_num_rows($data) === 0): ?>
        <div class="alert alert-warning">
          Belum ada data rekam medis.
        </div>
      <?php else: ?>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>Diagnosa</th>
              <th>Tindakan</th>
              <th>Resep</th>
              <th>Catatan</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['diagnosa']) ?></td>
              <td><?= htmlspecialchars($row['tindakan']) ?></td>
              <td><?= htmlspecialchars($row['resep_obat']) ?></td>
              <td><?= htmlspecialchars($row['catatan']) ?></td>
              <td><?= htmlspecialchars($row['waktu_input']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <?php endif; ?>

    </div>
  </div>
</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
