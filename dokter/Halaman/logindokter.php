<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika dokter sudah login → arahkan ke home dokter
if (isset($_SESSION['dokter_id'])) {
    header("Location: homepagedokter.php");
    exit;
}

require_once "../../koneksi.php";
require_once "../doktermodel.php";

$model = new DokterModel($conn);
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $dokter = $model->loginDokter($email, $password);

    if ($dokter) {
        $_SESSION["dokter_id"] = $dokter["id"];
        $_SESSION["dokter_nama"] = $dokter["nama"];
        $_SESSION["dokter_spesialis"] = $dokter["spesialis"];

        header("Location: homepagedokter.php");
        exit;
    } else {
        $error = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Dokter - RS Davinza</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background-color: #F3F6F9;
    font-family: 'Segoe UI', sans-serif;
}

.card-login {
    max-width: 420px;
    margin: 90px auto;
    padding: 35px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0px 8px 24px rgba(0,0,0,0.08);
}

.btn-primary {
    background-color: #00629B !important;
    border-color: #00629B !important;
}
.btn-primary:hover {
    background-color: #004F80 !important;
}
</style>
</head>

<body>

<div class="card-login">
    <h3 class="text-center fw-bold text-primary mb-3">Login Dokter</h3>
    <p class="text-center text-secondary mb-4">Akses sistem dokter RS Davinza</p>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="Masukkan email">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mt-2 fw-semibold">Masuk</button>

    </form>
</div>

</body>
</html>
