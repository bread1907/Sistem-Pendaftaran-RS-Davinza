<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Dokter</title>

    <?php
    include_once "../koneksi.php";
    include_once "../model/AdminModel.php";
    include_once "../model/DokterModel.php";

    $adminModel = new AdminModel($conn);
    $dokterModel = new DokterModel($conn);

    $totalDoctors = $adminModel->getTotalDoctors();
    $totalSpecializations = $adminModel->getTotalSpecializations();
    $averagePatientsPerDay = $adminModel->getAveragePatientsPerDay();

    // JANGAN override kalau sudah dikirim dari controller
    if (!isset($doctors)) {
        $doctors = $dokterModel->getAllWithStatus(); // fallback
    }
    ?>

    <?php include __DIR__ . "/Halaman_Admin/links.php"; ?>
    <link rel="stylesheet" href="Style_Admin/main.css">

    <style>
        html,
        body {
            height: 100%;
        }

        #sidepanel {
            position: sticky;
            top: 56px;
            height: calc(100vh - 56px);
        }
    </style>

</head>

<body class="bg-light">
    <?php include __DIR__ . "/Halaman_Admin/header_admin.php"; ?> <!-- Header terpisah -->

    <div class="container-fluid" id="main-content">
        <div class="row">
            <!-- Sidebar dipindah ke sini -->
            <?php include __DIR__ . "/Halaman_Admin/sidebar_admin.php"; ?>

            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Manajemen Dokter - Davinza Hospital</h3>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Dokter</h5>
                                <h2 class="text-primary"><?php echo $totalDoctors; ?></h2>
                                <p class="text-success">+2 bulan ini</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Dokter Aktif</h5>
                                <h2 class="text-success"><?php echo $totalDoctors; ?></h2>
                                <p class="text-muted">100% aktif</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Spesialis</h5>
                                <h2 class="text-warning"><?php echo $totalSpecializations; ?></h2>
                                <p class="text-muted">Spesialisasi berbeda</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Rata-rata Pasien/Hari</h5>
                                <h2 class="text-info"><?php echo $averagePatientsPerDay; ?></h2>
                                <p class="text-muted">Per dokter</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Doctor Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5>Daftar Dokter</h5>
                    <button class="btn custom-bg text-white" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
                        <i class="bi bi-person-plus"></i> Tambah Dokter
                    </button>
                </div>

                <!-- Doctors Table -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama</th>
                                    <th>Spesialis</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dokter-body">
                                <?php if (!empty($doctors) && is_array($doctors)): ?>
                                    <?php foreach ($doctors as $d): ?>
                                        <?php
                                        $status = $d['status_praktek'] ?? 'Tidak Praktek';
                                        $badgeClass = ($status === 'Praktek') ? 'bg-success' : 'bg-secondary';
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($d['nama']) ?></td>
                                            <td><?= htmlspecialchars($d['spesialis']) ?></td>
                                            <td>
                                                <span class="badge <?= $badgeClass ?>">
                                                    <?= htmlspecialchars($status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <!-- Eye: modal detail (read-only) -->
                                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailDokter<?= htmlspecialchars($d['dokter_id']) ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Pencil: modal edit (form submit normal POST) -->
                                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditDokter<?= htmlspecialchars($d['dokter_id']) ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Trash: delete via POST biasa -->
                                                <form action="../index.php?action=hapus_dokter" method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus dokter ini?');">
                                                    <input type="hidden" name="dokter_id"
                                                        value="<?= htmlspecialchars($d['dokter_id']) ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data dokter.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php foreach ($doctors as $d): ?>
                            <?php
                            $status = $d['status_praktek'] ?? 'Tidak Praktek';
                            $badgeClass = ($status === 'Praktek') ? 'bg-success' : 'bg-secondary';
                            ?>

                            <!-- MODAL DETAIL (eye) -->
                            <div class="modal fade" id="modalDetailDokter<?= htmlspecialchars($d['dokter_id']) ?>"
                                tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Dokter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center mb-3">
                                                    <?php if (!empty($d['foto'])): ?>
                                                        <img src="../uploads/dokter/<?= htmlspecialchars($d['foto']) ?>"
                                                            class="img-fluid rounded" alt="Foto Dokter">
                                                    <?php else: ?>
                                                        <div class="border rounded p-4 text-muted">Tidak ada foto</div>
                                                    <?php endif; ?>
                                                    <div class="mt-2">
                                                        <span class="badge <?= $badgeClass ?>">
                                                            <?= htmlspecialchars($status) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <th>Nama</th>
                                                            <td><?= htmlspecialchars($d['nama']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Spesialis</th>
                                                            <td><?= htmlspecialchars($d['spesialis']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hari Praktek</th>
                                                            <td><?= htmlspecialchars($d['hari_praktek']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Jam Praktek</th>
                                                            <td><?= htmlspecialchars($d['jam_mulai']) ?> -
                                                                <?= htmlspecialchars($d['jam_selesai']) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Username</th>
                                                            <td><?= htmlspecialchars($d['username']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>NIP</th>
                                                            <td><?= htmlspecialchars($d['nip']) ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL EDIT (pencil) -->
                            <div class="modal fade" id="modalEditDokter<?= htmlspecialchars($d['dokter_id']) ?>"
                                tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="../index.php?action=update_dokter" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Dokter</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="dokter_id"
                                                    value="<?= htmlspecialchars($d['dokter_id']) ?>">

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="nama" class="form-control"
                                                            value="<?= htmlspecialchars($d['nama']) ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Spesialis</label>
                                                        <input type="text" name="spesialis" class="form-control"
                                                            value="<?= htmlspecialchars($d['spesialis']) ?>" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Hari Praktek</label>
                                                        <input type="text" name="hari_praktek" class="form-control"
                                                            value="<?= htmlspecialchars($d['hari_praktek']) ?>" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Jam Mulai</label>
                                                        <input type="time" name="jam_mulai" class="form-control"
                                                            value="<?= htmlspecialchars($d['jam_mulai']) ?>" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Jam Selesai</label>
                                                        <input type="time" name="jam_selesai" class="form-control"
                                                            value="<?= htmlspecialchars($d['jam_selesai']) ?>" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">No STR</label>
                                                        <input type="text" name="no_str" class="form-control" disabled
                                                            value="<?= htmlspecialchars($d['no_str']) ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" name="username" class="form-control"
                                                            value="<?= htmlspecialchars($d['username']) ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">NIP</label>
                                                        <input type="text" name="nip" class="form-control" disabled
                                                            value="<?= htmlspecialchars($d['nip']) ?>" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Foto</label>
                                                    <input type="file" name="foto" class="form-control" accept="image/*"
                                                        value="<?= htmlspecialchars($d['foto']) ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


                    </div>
                </div>

                <!-- Add Doctor Modal -->
                <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="../index.php?action=tambah_dokter" method="post" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Dokter Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- dokter_id optional -->
                                    <input type="hidden" name="dokter_id">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Spesialis</label>
                                            <input type="text" name="spesialis" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hari Praktek</label>
                                            <input type="text" name="hari_praktek" class="form-control"
                                                placeholder="Contoh: Senin, Rabu, Jumat">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Jam Mulai</label>
                                            <input type="time" name="jam_mulai" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Jam Selesai</label>
                                            <input type="time" name="jam_selesai" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">No STR</label>
                                            <input type="text" name="no_str" class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">NIP</label>
                                            <input type="text" name="nip" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Foto</label>
                                              <input type="file" name="foto" class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn custom-bg text-white">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>

<script>
    setInterval(() => {
        fetch('../index.php?action=status_dokter')
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.forEach(d => {
                    html += `
                <tr>
                    <td>${d.nama}</td>
                    <td>${d.spesialis}</td>
                    <td>
                        <span class="badge ${d.status_praktek === 'Praktek'
                            ? 'bg-success'
                            : 'bg-secondary'}">
                            ${d.status_praktek}
                        </span>
                    </td>
                </tr>`;
                });
                document.getElementById('dokter-body').innerHTML = html;
            });
    }, 30000); // refresh tiap 30 detik
</script>