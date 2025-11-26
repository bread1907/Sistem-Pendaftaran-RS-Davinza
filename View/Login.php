<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Davinza | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Tambahan untuk ikon -->

    <link rel="stylesheet" href="../Style/login-style.css">
</head>

<body>
    <!-- Header -->
    <?php include __DIR__ . "/Halaman/header.php"; ?>

    <div class="main-content">
        <div class="row g-0 h-100 w-100">
            <!-- Bagian kiri gambar -->
            <div class="col-md-6 left-img d-none d-md-block"></div>

            <!-- Bagian kanan form login -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="card card-login shadow">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-3x" style="color: #0077C0;"></i> <!-- Ikon avatar -->
                    </div>
                    <h2 class="text-center fw-bold mb-3">Selamat Datang Kembali!</h2>
                    <p class="text-center text-muted mb-4">Silakan login dengan kredensial yang benar</p>

                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="Masukkan email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary eee w-100 mt-3">Login</button>

                        <p class="text-center mt-4">
                            Belum punya akun?
                            <a href="#" class="fw-semibold" style="color:#4c3ecb;">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Section tambahan biar ramai -->
    <div class="additional-section">
        <h3>Mengapa Memilih Kami?</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h5>Keamanan Terjamin</h5>
                    <p>Data Anda dilindungi dengan enkripsi tingkat tinggi untuk privasi maksimal.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-rocket"></i>
                    <h5>Akses Cepat</h5>
                    <p>Login instan dan navigasi yang mudah untuk pengalaman pengguna terbaik.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h5>Komunitas Besar</h5>
                    <p>Bergabunglah dengan ribuan pengguna yang sudah mempercayai platform kami.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/Halaman/footer.php"; ?>
</body>
</html>
