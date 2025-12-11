<?php
// session_start(); <-- jangan panggil di sini karena sudah di index.php

// Logout handler
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: logindokter.php");
    exit;
}

// Jika sudah login, arahkan ke homepage
if (isset($_SESSION['dokter_logged_in']) && $_SESSION['dokter_logged_in'] === true) {
    header("Location: homepagedokter.php");
    exit;
}

require_once __DIR__ . "/template/header_dokter.php";
?>

<div class="container" style="max-width: 450px; margin-top: 80px;">
    <h2 class="text-center mb-4">Login Dokter</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="../index.php?aksi=loginProses" method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
</div>

<?php require_once __DIR__ . "/template/footer_dokter.php"; ?>
