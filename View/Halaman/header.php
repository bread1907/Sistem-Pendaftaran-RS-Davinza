<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current = $_GET['action'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RS Davinza</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

<style>
:root {
    --primary: #0077C0;
    --text-secondary: #6B7280;
}

/* Navbar */
.navbar-custom {
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    position: relative;
    z-index: 1100;
}

.nav-link { font-weight: 500; transition: 0.2s; }
.nav-link-custom { color: var(--text-secondary) !important; }
.nav-link-custom:hover { color: var(--primary) !important; }
.nav-link-active { color: var(--primary) !important; border-bottom: 2px solid var(--primary); padding-bottom: 4px; font-weight: 600; }

.btn-daftar {
    color: var(--primary) !important;
    border: 2px solid var(--primary) !important;
    background: transparent !important;
    font-weight: 600;
    border-radius: 8px;
}

.btn-primary {
    background-color: var(--primary) !important;
    border-color: var(--primary) !important;
    color: white !important;
}

.btn-username {
    background-color: #f0f0f0;
    color: #0077C0;
    border: 1px solid #0077C0;
    font-weight: 500;
    border-radius: 8px;
}

/* Pastikan dropdown selalu di atas konten */
.navbar .dropdown-menu {
    position: absolute;
    z-index: 2000 !important;
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
<div class="container py-3">
    <!-- Logo -->
    <a href="index.php?action=homepage" class="d-flex align-items-center text-decoration-none">
      <img src="Pictures/davinza_logo_2.png" width="65" height="70" class="me-3" alt="Logo">
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-4 gap-3">
        <li><a class="nav-link <?=($current=='homepage'?'nav-link-active':'nav-link-custom')?>" href="index.php?action=homepage">Home</a></li>
        <li><a class="nav-link <?=($current=='layanan'?'nav-link-active':'nav-link-custom')?>" href="index.php?action=layanan">Pelayanan</a></li>
        <li><a class="nav-link <?=($current=='temukandokter'?'nav-link-active':'nav-link-custom')?>" href="index.php?action=temukandokter">Temukan Dokter</a></li>
        <li><a class="nav-link <?=($current=='fasilitas'?'nav-link-active':'nav-link-custom')?>" href="index.php?action=fasilitas">Fasilitas</a></li>
        <li><a class="nav-link <?=($current=='janjitemu'?'nav-link-active':'nav-link-custom')?>" href="index.php?action=janjitemu">Buat Jadwal Temu</a></li>

        <!-- Dropdown lain bisa ditambahkan di sini jika ada -->

        <li><a class="nav-link <?=($current=='tentangkami'?'nav-link-active':'nav-link-custom')?>" href="index.php?action=tentangkami">Tentang Kami</a></li>
      </ul>

      <!-- Right Side -->
      <div class="d-none d-md-flex align-items-center gap-3 ms-auto">
        <?php if(!isset($_SESSION['user_id'])): ?>
          <a href="index.php?action=register" class="btn btn-daftar px-4">Daftar</a>
          <a href="index.php?action=login" class="btn btn-primary px-4">Masuk</a>
        <?php else: ?>
          <a href="index.php?action=profile" class="btn btn-username px-3">
            <i class="fa fa-user-circle me-1"></i> <?=htmlspecialchars($_SESSION['username']);?>
          </a>
          <a href="index.php?action=logout" class="btn btn-danger px-3" onclick="return confirmLogout();">
            <i class="fa fa-sign-out-alt me-1"></i> Logout
          </a>
          <script>
            function confirmLogout() {
              return confirm('Apakah Anda yakin ingin logout?');
            }
          </script>
        <?php endif; ?>
      </div>
    </div>
</div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
