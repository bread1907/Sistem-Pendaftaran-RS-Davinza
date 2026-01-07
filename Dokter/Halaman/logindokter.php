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
            Login Dokter
        </h2>
        <p class="text-muted">
            Sistem Informasi RS Davinza – Akses Khusus Dokter
        </p>
    </div>

    <!-- ALERT ERROR -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['login_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <!-- FORM LOGIN -->
    <form method="POST" action="index.php?aksi=loginProses"
          class="card p-4 shadow-sm border-0" id="loginForm">

        <div class="mb-3">
            <label for="username" class="form-label fw-semibold">
                Username
            </label>
            <input type="text" name="username" id="username"
                   class="form-control"
                   placeholder="Masukkan username"
                   required>
            <div class="invalid-feedback">
                Username wajib diisi.
            </div>
        </div>

        <div class="mb-3">
            <label for="nip" class="form-label fw-semibold">
                NIP
            </label>
            <input type="text" name="nip" id="nip"
                   class="form-control"
                   placeholder="Masukkan NIP"
                   required>
            <div class="invalid-feedback">
                NIP wajib diisi.
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">
                Password
            </label>
            <input type="password" name="password" id="password"
                   class="form-control"
                   placeholder="Masukkan password"
                   required minlength="6">
            <div class="invalid-feedback">
                Password minimal 6 karakter.
            </div>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                Login
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function (e) {
    const fields = ['username', 'nip', 'password'];
    let valid = true;

    fields.forEach(id => {
        const el = document.getElementById(id);
        el.classList.remove('is-invalid');

        if (!el.value.trim() || (id === 'password' && el.value.length < 6)) {
            el.classList.add('is-invalid');
            valid = false;
        }
    });

    if (!valid) e.preventDefault();
});
</script>

<?php include __DIR__ . "/template/footer_dokter.php"; ?>
