<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . "/template/header_dokter.php";
?>

<div class="container py-4">

  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
      <h3 class="mb-1">Daftar Pasien Sesuai Jadwal Temu</h3>
      <div class="text-muted">
        Login sebagai: <b><?= htmlspecialchars($_SESSION['dokter_nama'] ?? 'Dokter') ?></b>
      </div>
    </div>

    <div class="d-flex gap-2 mt-2 mt-md-0">
      <a href="index.php?aksi=homepagedokter" class="btn btn-outline-primary">Home</a>
      <a href="index.php?aksi=logout" class="btn btn-outline-danger">Logout</a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      <?php if (!isset($data) || !$data): ?>
        <div class="alert alert-danger">
          Data jadwal tidak ditemukan / query gagal.
        </div>

      <?php else: ?>
        <?php if (mysqli_num_rows($data) === 0): ?>
          <div class="alert alert-warning">
            Belum ada pasien terjadwal untuk dokter ini.
          </div>
        <?php else: ?>

        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Email</th>
                <th>No HP</th>
                <th>NIK</th>
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
                  if (in_array($status, ['pending','menunggu'])) $badge = 'warning';
                  elseif ($status === 'selesai') $badge = 'success';
                ?>

                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= htmlspecialchars($row['no_hp']) ?></td>
                  <td><?= htmlspecialchars($row['nik']) ?></td>
                  <td><?= htmlspecialchars($row['tanggal_temu']) ?></td>
                  <td><?= htmlspecialchars($row['jam_temu']) ?></td>
                  <td><?= htmlspecialchars($row['nomor_antrian']) ?></td>
                  <td>
                    <span class="badge bg-<?= $badge ?>">
                      <?= htmlspecialchars($row['status']) ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($row['keluhan']) ?></td>

                  <!-- ✅ TOMBOL ISI DIAGNOSA -->
                  <td>
  <a class="btn btn-sm btn-primary"
     href="index.php?aksi=formrekammedis&jadwal_id=<?= urlencode($row['jadwal_id']) ?>&pasien_id=<?= urlencode($row['pasien_id']) ?>">
    Isi Diagnosa
  </a>
</td>

                </tr>

              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <?php endif; ?>
      <?php endif; ?>

    </div>
  </div>

</div>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
