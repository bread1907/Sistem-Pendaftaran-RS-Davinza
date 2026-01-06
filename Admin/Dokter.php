<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Dokter</title>

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
                                <h2 class="text-primary"><?= $totalDoctors ?></h2>
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
                                <h2 class="text-warning"><?= $totalSpecializations ?></h2>
                                <p class="text-muted">Spesialisasi berbeda</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Rata-rata Pasien/Hari</h5>
                                <h2 class="text-info"><?= $averagePatientsPerDay ?></h2>
                                <p class="text-muted">Per dokter</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="GET" class="row g-2 mb-3">
                    <input type="hidden" name="action" value="lihat_dokter">

                    <div class="col-md-3">
                        <label class="form-label mb-1">Spesialis</label>
                        <select name="spesialis" class="form-select">
                            <option value="">Semua</option>
                            <?php foreach ($listSpesialis as $sp): ?>
                                <option value="<?= htmlspecialchars($sp); ?>" <?= isset($_GET['spesialis']) && $_GET['spesialis'] === $sp ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($sp); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Hari</label>
                        <select name="hari" class="form-select">
                            <option value="">Semua</option>
                            <?php
                            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                            foreach ($hariList as $h): ?>
                                <option value="<?= $h; ?>" <?= (($_GET['hari'] ?? '') === $h) ? 'selected' : ''; ?>>
                                    <?= $h; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark me-2"><i class="bi bi-search"></i></button>
                        <a href="index.php?action=lihat_dokter" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>


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
                                <?php if (!empty($dokterList) && is_array($dokterList)): ?>
                                    <?php foreach ($dokterList as $d): ?>
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
                                                <!-- Eye: modal detail -->
                                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailDokter<?= htmlspecialchars($d['dokter_id']) ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Pencil: modal edit -->
                                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditDokter<?= htmlspecialchars($d['dokter_id']) ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Trash: delete -->
                                                <form action="index.php?action=hapus_dokter" method="post" class="d-inline"
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
                                        <td colspan="4" class="text-center text-muted">Belum ada data dokter.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                        <?php foreach ($dokterList as $d): ?>

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
                                                        <img src="../Pictures/Dokter/<?= htmlspecialchars($d['foto']) ?>"
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
                                        <form action="index.php?action=update_dokter" method="post"
                                            enctype="multipart/form-data">
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
                                                        <input type="text" class="form-control"
                                                            value="<?= htmlspecialchars($d['no_str']) ?>" readonly>
                                                        <input type="hidden" name="no_str"
                                                            value="<?= htmlspecialchars($d['no_str']) ?>">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" name="username" class="form-control"
                                                            value="<?= htmlspecialchars($d['username']) ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">NIP</label>
                                                        <input type="text" class="form-control"
                                                            value="<?= htmlspecialchars($d['nip']) ?>" readonly>
                                                        <input type="hidden" name="nip"
                                                            value="<?= htmlspecialchars($d['nip']) ?>">
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
            </div>
        </div>
    </div>
</body>

</html>

<!-- <script>
    setInterval(() => {
        fetch('index.php?action=status_dokter')
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
</script> -->