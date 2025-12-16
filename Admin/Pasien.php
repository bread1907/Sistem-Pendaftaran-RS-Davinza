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
    <?php include __DIR__ . "/Halaman_Admin/header_admin.php"; ?> <!-- Header terpisah -->

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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" placeholder="Cari pasien..." style="width: 300px;">
                        <select class="form-control" style="width: 150px;">
                            <option>Semua Status</option>
                            <option>Aktif</option>
                            <option>Tidak Aktif</option>
                            <option>Rawat Inap</option>
                        </select>
                    </div>
                    <button class="btn custom-bg text-white" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                        <i class="bi bi-person-plus"></i> Tambah Pasien
                    </button>
                </div>

                <!-- Patients Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
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
                                    <tr>
                                        <td>P001</td>
                                        <td>Siti Aminah</td>
                                        <td>35</td>
                                        <td>Perempuan</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>Dr. Ahmad Santoso</td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning me-1">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P002</td>
                                        <td>Budi Santoso</td>
                                        <td>28</td>
                                        <td>Laki-laki</td>
                                        <td><span class="badge bg-warning">Rawat Inap</span></td>
                                        <td>Dr. Sari Indah</td>
                                        <td>2024-01-14</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning me-1">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P003</td>
                                        <td>Maya Sari</td>
                                        <td>45</td>
                                        <td>Perempuan</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>Dr. Budi Setiawan</td>
                                        <td>2024-01-13</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning me-1">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P004</td>
                                        <td>Ahmad Rahman</td>
                                        <td>52</td>
                                        <td>Laki-laki</td>
                                        <td><span class="badge bg-secondary">Tidak Aktif</span></td>
                                        <td>Dr. Maya Putri</td>
                                        <td>2023-12-20</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning me-1">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Patient Modal -->
                <div class="modal fade" id="addPatientModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Pasien Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Usia</label>
                                            <input type="number" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <select class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option>Laki-laki</option>
                                                <option>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">No. Telepon</label>
                                            <input type="tel" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea class="form-control" rows="2" required></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Dokter Penanggung Jawab</label>
                                            <select class="form-control" required>
                                                <option value="">Pilih Dokter</option>
                                                <option>Dr. Ahmad Santoso</option>
                                                <option>Dr. Sari Indah</option>
                                                <option>Dr. Budi Setiawan</option>
                                                <option>Dr. Maya Putri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Riwayat Medis</label>
                                        <textarea class="form-control" rows="3" placeholder="Masukkan riwayat penyakit, alergi, dll."></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn custom-bg text-white">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
