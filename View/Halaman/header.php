<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage</title>

  <?php
    include '../links.php';
  ?>
</head>

<body>
  <!-- Grey with black text -->
<nav class="navbar navbar-expand-sm bg-light justify-content-center fixed-top">
  <nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../../Pictures/logo.jpg" alt="" width="55" height="40" class="d-inline-block align-text-top">
      RS Davinza
    </a>
  </div>
</nav>
  <div class="container-fluid justify-content-center">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="#">Home</a>
      </li>
     <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Panduan Pasien
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#">Buat Janji Temu</a></li>
            <li><a class="dropdown-item" href="#">Temukan Dokter</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Tentang Kami</a>
      </li>
    </ul>
  </div>
</nav>
</body>
</html>