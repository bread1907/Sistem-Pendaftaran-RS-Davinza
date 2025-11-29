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

    /* === Custom Navbar Theme === */
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

    .btn-primary-custom {
      background: var(--primary);
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      padding: 8px 16px;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%236B7280' stroke-width='2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .quick-stats {
      margin-top: -50px;
      z-index: 11;
      position: relative;
    }
  </style>

  <?php include __DIR__ . '/../links.php'; ?>


</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container py-3">

      <!-- Logo -->
      <a class="d-flex align-items-center text-decoration-none" href="homepage.html">
        <img src="../Pictures/davinza_logo_2.png" alt="Davinza Logo" width="65" height="70" class="me-3">
      </a>

      <!-- Mobile Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-4 gap-3">
          <li><a class="nav-link nav-link-active" href="homepage.html">Home</a></li>
          <li><a class="nav-link nav-link-custom" href="medical_services.html">Pelayanan</a></li>
          <li><a class="nav-link nav-link-custom" href="find_a_doctor.html">Temukan Dokter</a></li>
          <li><a class="nav-link nav-link-custom" href="patient_portal.html">Fasilitas</a></li>
          <li><a class="nav-link nav-link-custom" href="emergency_care.html">Buat Janji Temu</a></li>
          <li><a class="nav-link nav-link-custom" href="Tentangkami.php">Tentang Kami</a></li>
        </ul>

        <!-- CTA Buttons -->
        <div class="d-none d-md-flex align-items-center gap-3 ms-auto">

            <!-- Tombol DAFTAR -->
            <a href="Register.php" class="btn btn-daftar px-4">
                Daftar
            </a>

            <!-- Tombol LOGIN -->
            <a href="Login.php" class="btn btn-primary px-4" style="background-color: #0077C0;">
                Masuk
            </a>

        </div>

  </nav>



</body>

</html>