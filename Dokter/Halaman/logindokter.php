<?php
include __DIR__ . "/template/header_dokter.php";
?>

<div class="container" style="max-width: 500px; margin-top: 80px;">
    <!-- HEADER -->
    <div class="text-center mb-4">
        <img
            src="https://img.freepik.com/free-vector/doctor-character-background_1270-84.jpg"
            alt="Ilustrasi Dokter"
            class="img-fluid mb-3 rounded-circle"
            style="max-height: 120px; object-fit: cover; border: 3px solid #007bff;"
        >
        <h2 class="fw-bold text-primary">
            <i class="bi bi-shield-lock"></i> Login Dokter
        </h2>
        <p class="text-muted">Masuk ke sistem RS Davinza untuk mengelola pasien dan rekam medis.</p>
    </div>

    <!-- ALERT ERROR -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($_SESSION['login_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <!-- FORM LOGIN -->
    <form method="POST" action="index.php?aksi=loginproses" class="card p-4 shadow-sm border-0" id="loginForm">
        <div class="mb-3">
            <label for="username" class="form-label fw-semibold">
                <i class="bi bi-person"></i> Username
            </label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username Anda" required>
            <div class="invalid-feedback">
                Username wajib diisi.
            </div>
        </div>

        <div class="mb-3">
            <label for="nip" class="form-label fw-semibold">
                <i class="bi bi-card-text"></i> NIP
            </label>
            <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP Anda" required>
            <div class="invalid-feedback">
                NIP wajib diisi.
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">
                <i class="bi bi-lock"></i> Password
            </label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required minlength="6">
            <div class="invalid-feedback">
                Password minimal 6 karakter.
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>
        </div>

        <div class="text-center mt-3">
            <a href="#" class="text-decoration-none text-muted small">
                <i class="bi bi-question-circle"></i> Lupa Password?
            </a>
        </div>
    </form>

    <!-- FOOTER LINK -->
    <div class="text-center mt-4">
        <p class="text-muted small">
            Belum memiliki akun? <a href="index.php?aksi=register" class="text-primary fw-semibold">Daftar Sekarang</a>
        </p>
    </div>
</div>

<script>
// Validasi sisi klien sederhana
document.getElementById('loginForm').addEventListener('submit', function(event) {
    const username = document.getElementById('username');
    const nip = document.getElementById('nip');
    const password = document.getElementById('password');
    let isValid = true;

    // Reset validasi
    username.classList.remove('is-invalid');
    nip.classList.remove('is-invalid');
    password.classList.remove('is-invalid');

    // Cek username
    if (!username.value.trim()) {
        username.classList.add('is-invalid');
        isValid = false;
    }

    // Cek NIP
    if (!nip.value.trim()) {
        nip.classList.add('is-invalid');
        isValid = false;
    }

    // Cek password
    if (password.value.length < 6) {
        password.classList.add('is-invalid');
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Cegah submit jika tidak valid
    }
});
</script>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
