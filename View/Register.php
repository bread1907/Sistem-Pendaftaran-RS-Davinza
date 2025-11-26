<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Davinza | Daftar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Tambahan untuk ikon -->

    <link rel="stylesheet" href="../Style/register-style.css">
    
</head>

<body>
    <?php include "links.php"; ?>

    <!-- Header -->
    <?php include __DIR__ . "/Halaman/header.php"; ?>

    <div class="main-content">
        <div class="row g-0 h-100 w-100">
            <!-- Bagian kiri gambar -->
            <div class="col-md-6 left-img d-none d-md-block"></div>
            <!-- Bagian kanan form register -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="card card-register shadow">
                    
                    <h2 class="text-center fw-bold mb-3">Daftar Akun Baru</h2>
                    <p class="text-center text-muted mb-4">Isi data Anda dengan lengkap untuk membuat akun</p>
                    <form>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Nama</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control shadow-none"
                                            placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="number" class="form-control shadow-none" placeholder="Masukkan NIK"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Nomor Telepon aktif</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="number" class="form-control shadow-none"
                                            placeholder="Masukkan nomor telepon" required>
                                    </div>
                                </div>
                                <div class="col-md-12 p-0 mb-3">
                                    <label class="form-label">Alamat</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <textarea class="form-control shadow-none" rows="2"
                                            placeholder="Masukkan alamat lengkap" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control shadow-none"
                                            placeholder="Masukkan kata sandi" required>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Konfirmasi Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control shadow-none"
                                            placeholder="Konfirmasi kata sandi" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
                        <p class="text-center mt-4">
                            Sudah punya akun?
                            <a href="login.php" class="fw-semibold"
                                style="color:#0077C0; transition: color 0.3s;">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/Halaman/footer.php"; ?>
</body>

</html>