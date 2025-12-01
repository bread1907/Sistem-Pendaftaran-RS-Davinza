<?php
// =============================
// SESSION
// =============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =============================
// KONEKSI DATABASE
// =============================
include __DIR__ . "/../koneksi.php"; // pastikan path benar

// =============================
// PROSES LOGIN
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT * FROM pasien WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // =============================
                // SET SESSION
                // =============================
                $_SESSION['nik']           = $user['nik'];
                $_SESSION['pasien_id']     = $user['pasien_id'];
                $_SESSION['username']      = $user['username'];
                $_SESSION['login_success'] = "Selamat datang, " . htmlspecialchars($user['username']);

                header("Location: index.php?action=homepage");
                exit;
            } else {
                $_SESSION['login_error'] = "Password salah!";
            }
        } else {
            $_SESSION['login_error'] = "Email tidak ditemukan!";
        }
    } else {
        $_SESSION['login_error'] = "Email dan Password wajib diisi!";
    }

    // Redirect ke login jika ada error
    header("Location: index.php?action=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RS Davinza | Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="Style/login-style.css">
</head>
<body>

<!-- POPUP LOGIN ERROR -->
<?php if (!empty($_SESSION['login_error'])): ?>
<div class="modal fade show" style="display:block; background:rgba(0,0,0,0.5);">
  <div class="modal-dialog">
    <div class="modal-content p-4 text-center">
      <h4 class="text-danger">Login Gagal!</h4>
      <p><?= htmlspecialchars($_SESSION['login_error']); ?></p>
      <button class="btn btn-primary mt-2" onclick="window.location='index.php?action=login'">Kembali</button>
    </div>
  </div>
</div>
<?php unset($_SESSION['login_error']); endif; ?>

<!-- POPUP LOGIN SUCCESS -->
<?php if (!empty($_SESSION['login_success'])): ?>
<div class="modal fade show" style="display:block; background:rgba(0,0,0,0.5);">
  <div class="modal-dialog">
    <div class="modal-content p-4 text-center">
      <h4 class="text-success">✔ Login Berhasil!</h4>
      <p><?= $_SESSION['login_success']; ?></p>
      <button class="btn btn-primary mt-2" onclick="window.location='index.php?action=homepage'">Lanjut</button>
    </div>
  </div>
</div>
<?php unset($_SESSION['login_success']); endif; ?>

<!-- Header -->
<?php include __DIR__ . "/Halaman/header.php"; ?>

<div class="main-content">
  <div class="row g-0 h-100 w-100">

    <div class="col-md-6 left-img d-none d-md-block"></div>

    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="card card-login shadow p-4">

        <div class="text-center mb-4">
          <i class="fas fa-user-circle fa-3x" style="color: #0077C0;"></i>
        </div>

        <h2 class="text-center fw-bold mb-3">Selamat Datang Kembali!</h2>
        <p class="text-center text-muted mb-4">Silakan login dengan kredensial yang benar</p>

        <form action="index.php?action=login" method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>

          <p class="text-center mt-4">
            Belum punya akun? 
            <a href="index.php?action=register" class="fw-semibold" style="color:#4c3ecb;">Register</a>
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
