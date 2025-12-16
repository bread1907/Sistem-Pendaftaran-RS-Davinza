<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

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
    <?php include __DIR__ . "/Halaman_Admin/header_admin.php"; ?>  <!-- Header terpisah -->

    <div class="container-fluid" id="main-content">
        <div class="row">
            <!-- Sidebar dipindah ke sini -->
             <?php include __DIR__ . "/Halaman_Admin/sidebar_admin.php"; ?>

            <!-- Konten sejajar di kanan -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Dashboard Admin - Davinza Hospital</h3>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Pasien</h5>
                                <h2 class="text-primary"><?php echo number_format($totalPatients); ?></h2>
                                <p class="text-success">+12% dari bulan lalu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Dokter Aktif</h5>
                                <h2 class="text-success"><?php echo $totalDoctors; ?></h2>
                                <p class="text-muted">Semua spesialis tersedia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Janji Temu Hari Ini</h5>
                                <h2 class="text-warning"><?php echo $appointmentsToday; ?></h2>
                                <p class="text-muted"><?php echo $completedToday; ?> selesai</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Keterisian Kamar</h5>
                                <h2 class="text-danger"><?php echo $roomOccupancy['percentage']; ?>%</h2>
                                <p class="text-muted"><?php echo $roomOccupancy['occupied']; ?> dari <?php echo $roomOccupancy['total']; ?> kamar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Aksi Cepat</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <button class="btn custom-bg text-white w-100">
                                            <i class="bi bi-person-plus"></i> Tambah Dokter
                                        </button>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button class="btn btn-success w-100">
                                            <i class="bi bi-calendar-plus"></i> Jadwalkan Janji
                                        </button>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button class="btn btn-warning w-100">
                                            <i class="bi bi-gear"></i> Pengaturan Sistem
                                        </button>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button class="btn btn-info w-100">
                                            <i class="bi bi-file-earmark-text"></i> Laporan Bulanan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities and Chart -->
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Kunjungan Pasien (30 Hari Terakhir)</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="patientChart" height="200"></canvas>
                                <p class="text-muted mt-3">Grafik kunjungan pasien menunjukkan peningkatan 15% dibandingkan bulan sebelumnya.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Notifikasi Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">2 jam yang lalu</small>
                                    <p>Janji temu dengan Dr. Sari dibatalkan</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">4 jam yang lalu</small>
                                    <p>5 kamar baru tersedia di lantai 3</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">6 jam yang lalu</small>
                                    <p>Laporan bulanan telah dibuat</p>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">Lihat Semua</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Department Stats -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Popularitas Departemen</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    $colors = ['bg-primary', 'bg-success', 'bg-warning'];
                                    foreach ($departmentStats as $index => $dept) {
                                        $percentage = $dept['percentage'];
                                        echo '<div class="col-md-4">';
                                        echo '<h6>' . htmlspecialchars($dept['name']) . '</h6>';
                                        echo '<div class="progress mb-3">';
                                        echo '<div class="progress-bar ' . $colors[$index] . '" style="width: ' . $percentage . '%">' . $percentage . '%</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>