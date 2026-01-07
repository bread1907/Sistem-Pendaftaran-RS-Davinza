<?php
    session_start();
    $email = $_SESSION['reg_email'] ?? null;
    if (!$email) {
        header('Location: ../index.php?action=register');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Davinza | Verifikasi Email</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .blue-primary { color:#0077C0 !important; }
        .btn-daftar {
            color: #0077C0 !important;
            border: 2px solid #0077C0 !important;
            background-color: transparent !important;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-daftar:hover {
            background-color: #0077C0 !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . "/../koneksi.php"; ?>
    <?php include __DIR__ . "/links.php"; ?>
    <?php include __DIR__ . "/Halaman/header.php"; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Verifikasi Email</h3>
                        <p class="text-center">Kode verifikasi telah dikirim ke <strong><?= htmlspecialchars($email) ?></strong>.</p>

                        <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                        <?php endif; ?>

                        <form action="../index.php?action=register_verify_code" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kode Verifikasi</label>
                                <input type="text" name="kode" class="form-control" maxlength="6" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Verifikasi & Buat Akun</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . "/Halaman/footer.php"; ?>

</body>
</html>l