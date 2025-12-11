<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Dokter - RS Davinza</title>

<!-- BOOTSTRAP & ICONS -->
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

body {
    background-color: var(--bg);
    font-family: 'Segoe UI', sans-serif;
}

/* NAVBAR */
.navbar-dokter {
    background: white;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    padding-top: 14px;
    padding-bottom: 14px;
    position: sticky;
    top: 0;
    z-index: 2000;
}

.navbar-brand {
    font-weight: 700;
    color: var(--primary) !important;
}

.navbar-nav .nav-link {
    font-weight: 500;
    color: var(--secondary);
    transition: 0.25s;
    font-size: 15px;
}

.navbar-nav .nav-link:hover {
    color: var(--primary);
}

.navbar-nav .active {
    color: var(--primary) !important;
    font-weight: 600;
    border-bottom: 3px solid var(--primary);
}

.btn-logout {
    border: none;
    background: #dc3545;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
}
.btn-logout:hover {
    opacity: 0.85;
}

/* CONTENT WRAPPER */
.wrapper {
    padding: 25px;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dokter">
<div class="container">

    <a class="navbar-brand d-flex align-items-center" href="homepagedokter.php">
        <i class="fa-solid fa-stethoscope me-2"></i> RS Davinza - Dokter
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuDokter">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuDokter">

        <ul class="navbar-nav ms-4">
            <li class="nav-item">
                <a class="nav-link <?=($current=='home'?'active':'')?>" href="homepagedokter.php">Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=($current=='jadwal'?'active':'')?>" href="jadwaldokter.php">Jadwal Saya</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=($current=='pasien'?'active':'')?>" href="daftarpasien.php">Daftar Pasien</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=($current=='profil'?'active':'')?>" href="profil_dokter.php">Profil</a>
            </li>
        </ul>

        <div class="ms-auto d-flex align-items-center">

            <?php if(isset($_SESSION['dokter_nama'])): ?>
            <span class="me-3 fw-semibold text-primary">
                <i class="fa-solid fa-user-md me-1"></i> 
                <?= htmlspecialchars($_SESSION['dokter_nama']); ?>
            </span>
            <a href="logoutdokter.php" class="btn-logout">Logout</a>
            <?php endif; ?>

        </div>
    </div>

</div>
</nav>

<div class="wrapper container">
