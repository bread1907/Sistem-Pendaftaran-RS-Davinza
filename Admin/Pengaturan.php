<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan</title>

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
                <h3 class="mb-4">Pengaturan</h3>

                <!-- General -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Pengaturan Umum</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#pengaturan-modal">
                                <i class="bi bi-pencil-square"></i>Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Nama Rumah Sakit</h6>
                        <p class="card-text">Davinza Hospital</p>
                        <h6 class="card-subtitle mb-1 fw-bold">Tentang Kami</h6>
                        <p class="card-text">Rumah sakit terdepan dalam pelayanan kesehatan dengan fasilitas modern dan tenaga medis profesional.</p>
                    </div>
                </div>

                <!-- Hospital Settings -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Pengaturan Rumah Sakit</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#hospital-modal">
                                <i class="bi bi-pencil-square"></i>Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Jam Operasional</h6>
                        <p class="card-text">24 Jam</p>
                        <h6 class="card-subtitle mb-1 fw-bold">Kontak Darurat</h6>
                        <p class="card-text">+62 123 456 7890</p>
                        <h6 class="card-subtitle mb-1 fw-bold">Alamat</h6>
                        <p class="card-text">Jl. Kesehatan No. 123, Kota Medis</p>
                    </div>
                </div>

                <!-- User Management -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Manajemen Pengguna</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#user-modal">
                                <i class="bi bi-pencil-square"></i>Kelola
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Total Dokter</h6>
                        <p class="card-text">15</p>
                        <h6 class="card-subtitle mb-1 fw-bold">Total Pasien Terdaftar</h6>
                        <p class="card-text">500</p>
                        <h6 class="card-subtitle mb-1 fw-bold">Admin Aktif</h6>
                        <p class="card-text">3</p>
                    </div>
                </div>

                <!-- System Configurations -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Konfigurasi Sistem</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#system-modal">
                                <i class="bi bi-pencil-square"></i>Konfigurasi
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Mode Pemeliharaan</h6>
                        <p class="card-text">Nonaktif</p>
                        <h6 class="card-subtitle mb-1 fw-bold">Backup Otomatis</h6>
                        <p class="card-text">Aktif - Setiap 24 Jam</p>
                        <h6 class="card-subtitle mb-1 fw-bold">Notifikasi Email</h6>
                        <p class="card-text">Aktif</p>
                    </div>
                </div>

                <div class="modal fade" id="pengaturan-modal" data-bs-backdrop="static" data-bs-keyboard="true"
                    tabindex="-1" aria-labelledby="pengaturan-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <form>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Pengaturan Umum</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Davinza Hospital</label>
                                        <input type="text" name="site_title"class="form-control shadow-none">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tentang Kami</label>
                                        <textarea name="site_about" class="form-control shadow-none" rows="6"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn text-white custom-bg shadow-none">Simpan</button>
                                    <!-- Sekarang custom-bg terapply -->
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

</body>

</html>