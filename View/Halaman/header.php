<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage</title>

  <style>
    * {
      font-family: 'Lato', sans-serif;
    }

    body {
      background-color: #F0F0F0;
    }

    :root {
      --primary: #0077c0;
      --text-secondary: #6B7280;
      --border-color: #E5E7EB;
      --surface: #F9FAFB;
    }

    .navbar-custom {
      background: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .nav-link-custom {
      color: var(--text-secondary) !important;
      font-weight: 500;
      transition: 0.2s;
    }

    .nav-link-custom:hover {
      color: var(--primary) !important;
    }

    .nav-link-active {
      color: var(--primary) !important;
      border-bottom: 2px solid var(--primary);
      padding-bottom: 4px;
      font-weight: 600;
    }

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

    .btn-primary {
      background-color: var(--primary) !important;
      border-color: var(--primary) !important;
      color: white !important;
    }

    .btn-primary:hover {
      background-color: #005f9c !important;
      border-color: #005f9c !important;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%236B7280' stroke-width='2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
  </style>

  <?php include __DIR__ . '/../links.php'; ?>

</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<body>

  <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container py-3">

      <!-- Logo -->
      <a class="d-flex align-items-center text-decoration-none" href="index.php?action=homepage">
        <img src="Pictures/davinza_logo_2.png" alt="Davinza Logo" width="65" height="70" class="me-3">
      </a>

      <!-- Mobile Menu -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">

        <ul class="navbar-nav ms-4 gap-3">
          <li><a class="nav-link nav-link-active" href="index.php?action=homepage">Home</a></li>
          <li><a class="nav-link nav-link-custom" href="medical_services.html">Pelayanan</a></li>
          <li><a class="nav-link nav-link-custom" href="find_a_doctor.html">Temukan Dokter</a></li>
          <li><a class="nav-link nav-link-custom" href="patient_portal.html">Fasilitas</a></li>
          <li><a class="nav-link nav-link-custom" href="jadwal_temu.php">Buat Janji Temu</a></li>
          <li><a class="nav-link nav-link-custom" href="index.php?action=tentangkami">Tentang Kami</a></li>
        </ul>

        <!-- BAGIAN KANAN NAVBAR -->
        <div class="d-none d-md-flex align-items-center gap-3 ms-auto">

          <?php if (!isset($_SESSION['user_id'])): ?>

            <!-- Jika belum login -->
            <a href="index.php?action=register" class="btn btn-daftar px-4">Daftar</a>
            <a href="index.php?action=login" class="btn btn-primary px-4">Masuk</a>

          <?php else: ?>

            <!-- Jika sudah login -->
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                <i class="fa fa-user-circle me-1"></i>
                <?= htmlspecialchars($_SESSION['username']); ?>
              </button>

              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="index.php?action=profile">Profil Saya</a></li>
                <li><a class="dropdown-item text-danger" href="index.php?action=logout">Logout</a></li>
              </ul>
            </div>

          <?php endif; ?>

        </div>

      </div>
    </div>
  </nav>

</body>

</html>
