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
$doctors = $dokterModel->getAll();

// Function to get current day in Indonesian
function getCurrentDayIndonesian() {
    $days = [
        1 => 'Sen', // Monday
        2 => 'Sel', // Tuesday
        3 => 'Rab', // Wednesday
        4 => 'Kam', // Thursday
        5 => 'Jum', // Friday
        6 => 'Sab', // Saturday
        7 => 'Min'  // Sunday
    ];
    return $days[date('N')];
}

// Function to check if doctor is available today
function isDoctorAvailableToday($hari_praktek) {
    if (empty($hari_praktek)) return false;
    $currentDay = getCurrentDayIndonesian();
    $availableDays = explode(', ', $hari_praktek);
    return in_array($currentDay, $availableDays);
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
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Spesialisasi</th>
                                        <th>Jadwal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($doctor = mysqli_fetch_assoc($doctors)) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($doctor['dokter_id']); ?></td>
                                        <td><?php echo htmlspecialchars($doctor['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($doctor['spesialis']); ?></td>
                                        <td><?php echo htmlspecialchars($doctor['hari_praktek'] ?? '-'); ?></td>
                                        <td><span class="badge bg-success">Aktif</span></td>
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
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Doctor Modal -->
                <div class="modal fade" id="addDoctorModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Dokter Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Spesialisasi</label>
                                            <select class="form-control" required>
                                                <option value="">Pilih Spesialisasi</option>
                                                <option>Umum</option>
                                                <option>Jantung</option>
                                                <option>Kandungan</option>
                                                <option>Anak</option>
                                                <option>Mata</option>
                                                <option>Gigi</option>
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
                                    <div class="mb-3">
                                        <label class="form-label">Jadwal Praktik</label>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="senin">
                                                    <label class="form-check-label" for="senin">Sen</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selasa">
                                                    <label class="form-check-label" for="selasa">Sel</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="rabu">
                                                    <label class="form-check-label" for="rabu">Rab</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="kamis">
                                                    <label class="form-check-label" for="kamis">Kam</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="jumat">
                                                    <label class="form-check-label" for="jumat">Jum</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="sabtu">
                                                    <label class="form-check-label" for="sabtu">Sab</label>
                                                </div>
                                            </div>
                                        </div>
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
