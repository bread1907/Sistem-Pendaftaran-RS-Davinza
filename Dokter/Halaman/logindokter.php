<?php
include __DIR__ . "/template/header_dokter.php";
?>

<div class="container" style="max-width: 450px; margin-top: 80px;">
    <h2 class="text-center mb-4">Login Dokter</h2>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?aksi=loginproses" class="card p-4 shadow-sm">

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

<?php include __DIR__ . "/template/footer_dokter.php"; ?>