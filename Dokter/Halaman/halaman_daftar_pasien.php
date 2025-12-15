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
      <a href="index.php?aksi=homepagedokter" class="btn btn-outline-primary">
        Home
      </a>
      <a href="index.php?aksi=logout" class="btn btn-outline-danger">
        Logout
      </a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      <?php if (!isset($data) || !$data): ?>
        <div class="alert alert-danger mb-0">
          Data jadwal tidak ditemukan / query gagal.
        </div>

      <?php else: ?>
        <?php $jumlah = mysqli_num_rows($data); ?>

        <?php if ($jumlah === 0): ?>
          <div class="alert alert-warning mb-0">
            Belum ada pasien terjadwal untuk dokter ini.
          </div>
        <?php else: ?>

          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 60px;">No</th>
                  <th>Nama/Username</th>
                  <th>Email</th>
                  <th>No HP</th>
                  <th>NIK</th>
                  <th>Tanggal</th>
                  <th>Jam</th>
                  <th>No Antrian</th>
                  <th>Status</th>
                  <th>Keluhan</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($data)) : ?>

                  <?php
                    $status = strtolower(trim($row['status'] ?? ''));
                    // badge default
                    $badge = 'secondary';

                    // kamu bisa sesuaikan status yang dipakai di DB
                    if (in_array($status, ['selesai', 'done', 'completed'])) $badge = 'success';
                    else if (in_array($status, ['pending', 'menunggu', 'proses'])) $badge = 'warning';
                    else if (in_array($status, ['batal', 'cancel'])) $badge = 'danger';
                  ?>

                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['username'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['no_hp'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['nik'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['tanggal_temu'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['jam_temu'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['nomor_antrian'] ?? '-') ?></td>
                    <td>
                      <span class="badge bg-<?= $badge ?>">
                        <?= htmlspecialchars($row['status'] ?? '-') ?>
                      </span>
                    </td>
                    <td style="min-width:220px; white-space: normal;">
                      <?= htmlspecialchars($row['keluhan'] ?? '-') ?>
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
