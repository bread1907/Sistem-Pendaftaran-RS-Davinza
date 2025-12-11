<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current = $current ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Dokter - RS Davinza</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

<style>
:root {
    --primary: #00629B;
    --primary-light: #E6F3FA;
    --dark: #1F2937;
    --secondary: #6B7280;
    --bg: #F3F6F9;
}
body { background-color: var(--bg); font-family: 'Segoe UI', sans-serif; }
.navbar-dokter { background:white; box-shadow:0 3px 12px rgba(0,0,0,0.08); padding:14px 0; }
.wrapper { padding:25px; }
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dokter">
<div class="container">

    <a class="navbar-brand d-flex align-items-center" href="homepagedokter.php">
        <i class="fa-solid fa-stethoscope me-2"></i> RS Davinza - Dokter
    </a>

    <div class="collapse navbar-collapse" id="menuDokter">

        <ul class="navbar-nav ms-4">
            <li class="nav-item"><a class="nav-link <?=($current=='home'?'active':'')?>"
                href="homepagedokter.php">Dashboard</a></li>

            <li class="nav-item"><a class="nav-link <?=($current=='jadwal'?'active':'')?>"
                href="jadwaldokter.php">Jadwal Saya</a></li>

            <li class="nav-item"><a class="nav-link <?=($current=='pasien'?'active':'')?>"
                href="daftarpasien.php">Daftar Pasien</a></li>

            <li class="nav-item"><a class="nav-link <?=($current=='profil'?'active':'')?>"
                href="profil_dokter.php">Profil</a></li>
        </ul>

        <div class="ms-auto d-flex align-items-center">
            <?php if(isset($_SESSION['dokter_nama'])): ?>
            <span class="me-3 fw-semibold text-primary">
                <i class="fa-solid fa-user-md me-1"></i> 
                <?= htmlspecialchars($_SESSION['dokter_nama']); ?>
            </span>
            <a href="logoutdokter.php" class="btn btn-danger">Logout</a>
            <?php endif; ?>
        </div>
    </div>

</div>
</nav>

<div class="wrapper container">
