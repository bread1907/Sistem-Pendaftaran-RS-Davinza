<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Davinza | Daftar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style/register-style.css">
</head>

<body>

<!-- ====================== POPUP ===================== -->

<?php if (isset($_SESSION['popup_success'])): ?>
<div class="modal fade show" style="display:block; background:rgba(0,0,0,0.7);">
  <div class="modal-dialog">
    <div class="modal-content text-center p-4">
      <h4 class="text-success mb-3">✔ Berhasil!</h4>
      <p><?= $_SESSION['popup_success']; ?></p>
      <a href="index.php?action=login" class="btn btn-primary mt-2">Login Sekarang</a>
    </div>
  </div>
</div>
<?php unset($_SESSION['popup_success']); endif; ?>


<?php if (isset($_SESSION['popup_error'])): ?>
<div class="modal fade show" style="display:block; background:rgba(0,0,0,0.7);">
  <div class="modal-dialog">
    <div class="modal-content p-4">
      <h4 class="text-danger">⚠ Periksa Form Anda</h4>
      <ul>
        <?php foreach ($_SESSION['popup_error'] as $err): ?>
            <li><?= $err ?></li>
        <?php endforeach; ?>
      </ul>
      <button class="btn btn-danger mt-2" onclick="window.location='index.php?action=register'">Tutup</button>
    </div>
  </div>
</div>
<?php unset($_SESSION['popup_error']); endif; ?>


<?php if (isset($_SESSION['popup_fail'])): ?>
<script>alert("Registrasi gagal, silakan coba lagi.");</script>
<?php unset($_SESSION['popup_fail']); endif; ?>

<!-- =================== END POPUP =================== -->


<?php include "koneksi.php"; ?>
<?php include "links.php"; ?>
<?php include __DIR__ . "/Halaman/header.php"; ?>


<div class="main-content">
    <div class="row g-0 h-100 w-100">

        <div class="col-md-6 left-img d-none d-md-block"></div>

        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card card-register shadow">

                <h2 class="text-center fw-bold mb-3">Daftar Akun Baru</h2>
                <p class="text-center text-muted mb-4">Isi data Anda dengan lengkap</p>

                <form action="index.php?action=register" method="POST">

                    <div class="container-fluid">
                        <div class="row">    

                            <!-- Email -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control shadow-none" required>
                                </div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="username" class="form-control shadow-none" required>
                                </div>
                            </div>

                            <!-- NIK -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">NIK</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="nik" class="form-control shadow-none" maxlength="20" required>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Nomor HP</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="no_hp" class="form-control shadow-none" required>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" name="tanggal_lahir" class="form-control shadow-none" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select name="jenis_kelamin" class="form-select shadow-none" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="col-md-12 p-0 mb-3">
                                <label class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    <textarea name="alamat" class="form-control shadow-none" required></textarea>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control shadow-none" required>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="confirm_password" class="form-control shadow-none" required>
                                </div>
                            </div>

                        </div>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary w-100 mt-3">Daftar</button>

                    <p class="text-center mt-4">
                        Sudah punya akun?
                        <a href="index.php?action=login">Login</a>
                    </p>

                </form>

            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . "/Halaman/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
