<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Pasien</title>
</head>
<body>

<h2>Daftar Pasien Sesuai Jadwal Temu</h2>

<p>
  Login sebagai: <b><?= htmlspecialchars($_SESSION['dokter_nama'] ?? 'Dokter') ?></b>
  | <a href="index.php?aksi=homepagedokter">Home</a>
  | <a href="index.php?aksi=logout">Logout</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>No</th>
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

  <?php
  $no = 1;
  while ($row = mysqli_fetch_assoc($data)) :
  ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['username']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['no_hp']) ?></td>
      <td><?= htmlspecialchars($row['nik'] ?? '-') ?></td>
      <td><?= htmlspecialchars($row['tanggal_temu']) ?></td>
      <td><?= htmlspecialchars($row['jam_temu']) ?></td>
      <td><?= htmlspecialchars($row['nomor_antrian']) ?></td>
      <td><?= htmlspecialchars($row['status']) ?></td>
      <td><?= htmlspecialchars($row['keluhan'] ?? '-') ?></td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
