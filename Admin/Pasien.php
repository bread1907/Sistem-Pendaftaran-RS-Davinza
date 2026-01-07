<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pasien</title>

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
    <?php include __DIR__ . "/Halaman_Admin/header_admin.php"; ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <!-- Sidebar dipindah ke sini -->
            <?php include __DIR__ . "/Halaman_Admin/sidebar_admin.php"; ?>

            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Manajemen Pasien - Davinza Hospital</h3>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Pasien</h5>
                                <h2 class="text-primary">1,247</h2>
                                <p class="text-success">+8% bulan ini</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Pasien Aktif</h5>
                                <h2 class="text-success">892</h2>
                                <p class="text-muted">71% dari total</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Kunjungan Hari Ini</h5>
                                <h2 class="text-warning">67</h2>
                                <p class="text-muted">23 menunggu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Rata-rata Usia</h5>
                                <h2 class="text-info">42</h2>
                                <p class="text-muted">Tahun</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <form method="GET" class="row g-2 mb-3">
                    <input type="hidden" name="action" value="lihat_pasien">

                    <div class="col-md-2">
                        <label class="form-label mb-1">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="belum_pernah" <?= isset($_GET['status']) && $_GET['status'] === 'belum_pernah' ? 'selected' : ''; ?>>Belum Pernah Berkunjung</option>
                            <option value="pending" <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="selesai" <?= isset($_GET['status']) && $_GET['status'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="batal" <?= isset($_GET['status']) && $_GET['status'] === 'batal' ? 'selected' : ''; ?>>Batal</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua</option>
                            <option value="L" <?= isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] === 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Urutkan Nama</label>
                        <select name="sort" class="form-select">
                            <option value="a-z" <?= isset($_GET['sort']) && $_GET['sort'] === 'a-z' ? 'selected' : ''; ?>>A-Z</option>
                            <option value="z-a" <?= isset($_GET['sort']) && $_GET['sort'] === 'z-a' ? 'selected' : ''; ?>>Z-A</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark me-2"><i class="bi bi-search"></i></button>
                        <a href="index.php?action=lihat_pasien" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>

                <!-- Patients Table -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama</th>
                                    <th>Usia</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Dokter</th>
                                    <th>Kunjungan Terakhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pasienList)): ?>
                                    <?php foreach ($pasienList as $p): ?>
                                        <?php
                                        // mapping jenis kelamin
                                        $jk = $p['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($p['jenis_kelamin'] === 'P' ? 'Perempuan' : $p['jenis_kelamin']);

                                        // status: kalau belum pernah punya jadwal_temu
                                        if (empty($p['kunjungan_terakhir_tgl'])) {
                                            $status = 'Belum pernah berkunjung';
                                            $badgeClass = 'bg-secondary';
                                            $kunjunganTerakhir = '-';
                                            $dokterTerakhir = '-';
                                        } else {
                                            $status = $p['status_terakhir']; // pending / selesai / batal
                                            $badgeClass = match ($status) {
                                                'selesai' => 'bg-success',
                                                'pending' => 'bg-warning',
                                                'batal' => 'bg-danger',
                                                default => 'bg-secondary',
                                            };
                                            $dokterTerakhir = $p['dokter_terakhir'] ?? '-';
                                            $kunjunganTerakhir = $p['kunjungan_terakhir_tgl'] . ' ' . substr($p['kunjungan_terakhir_jam'], 0, 5);
                                        }
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($p['nama']) ?></td>
                                            <?php
                                            $usia = $p['usia'];
                                            ?>
                                            <td>
                                                <?= $usia !== null ? (int) $usia . ' th' : '-' ?>
                                            </td>

                                            <td><?= htmlspecialchars($jk) ?></td>
                                            <td>
                                                <span class="badge <?= $badgeClass ?>">
                                                    <?= htmlspecialchars($status) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($dokterTerakhir) ?></td>
                                            <td><?= htmlspecialchars($kunjunganTerakhir) ?></td>
                                            <td>
                                                <!-- contoh aksi: detail & rekam medis -->
                                                <!-- Tombol contoh -->
                                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal"
                                                    data-bs-target="#detailPasienModal<?= $p['pasien_id'] ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>


                                                <form action="index.php?action=hapus_pasien&id=<?= $p['pasien_id'] ?>" method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus pasien ini?');">
                                                    <input type="hidden" name="pasien_id"
                                                        value="<?= htmlspecialchars($p['pasien_id']) ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada data pasien.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Modal Detail Pasien -->
                        <?php foreach ($pasienList as $p): ?>
                            <div class="modal fade" id="detailPasienModal<?= $p['pasien_id'] ?>" tabindex="-1"
                                aria-hidden="true">

                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pasien</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?= htmlspecialchars($p['nama']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Lahir</th>
                                                    <td><?= htmlspecialchars($p['tanggal_lahir']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Kelamin</th>
                                                    <td><?= $p['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No HP</th>
                                                    <td><?= htmlspecialchars($p['no_hp']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?= htmlspecialchars($p['alamat']) ?></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>

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