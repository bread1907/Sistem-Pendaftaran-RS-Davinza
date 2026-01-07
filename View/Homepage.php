<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RS Davinza</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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

<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load koneksi database dulu
require __DIR__ . "/../koneksi.php";

// Load model dokter
require_once __DIR__ . "/../model/doktermodel.php";

// Inisialisasi model dengan koneksi
$dokterModel = new DokterModel($conn);

// Ambil spesialis unik dari database
$spesialisList = $dokterModel->getSpesialis();
?>

<?php if (isset($_SESSION['login_success'])): ?>
<div class="modal fade show" style="display:block; background:rgba(0,0,0,0.5)">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 text-center">
        <h4 class="text-success">✔ Login Berhasil!</h4>
        <p><?= $_SESSION['login_success']; ?></p>
        <button class="btn btn-primary" onclick="document.querySelector('.modal').style.display='none'">
            Tutup
        </button>
    </div>
  </div>
</div>
<?php unset($_SESSION['login_success']); endif; ?>

<body>

<?php include __DIR__ . "/Halaman/header.php"; ?>

<!-- ================= HERO ================= -->
<section class="container py-5 position-relative">
    <div class="row align-items-center g-5">

      <div class="col-lg-6">
        <h1 class="display-3 fw-bold mt-4 text-dark">
          Advanced Care,<br>
          <span class="blue-primary">Personal Touch</span>
        </h1>

        <p class="fs-5 text-secondary mt-3">
          Nikmati layanan kesehatan yang menggabungkan inovasi medis terdepan dengan perawatan yang penuh empati.
        </p>

        <div class="d-flex gap-3 mt-4 flex-wrap">
          <a href="index.php?action=janjitemu" class="btn btn-primary btn-lg px-4 shadow">
            Buat Janji Temu
          </a>

          <a href="index.php?action=emergency" class="btn btn-daftar btn-lg px-4">
            Penanganan Darurat
          </a>
        </div>

        <div class="row text-center mt-5 pt-4 border-top">
          <div class="col-4">
            <h3 class="blue-primary fw-bold">50K+</h3>
            <p class="small text-secondary mb-0">Pasien Terobati</p>
          </div>
          <div class="col-4">
            <h3 class="blue-primary fw-bold">200+</h3>
            <p class="small text-secondary mb-0">Dokter Spesialis</p>
          </div>
          <div class="col-4">
            <h3 class="blue-primary fw-bold">98%</h3>
            <p class="small text-secondary mb-0">Kepuasan Pasien</p>
          </div>
        </div>
      </div>

      <!-- Carousel -->
      <div class="col-lg-6 position-relative">
        <div class="swiper mySwiper rounded-4 shadow overflow-hidden">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="Pictures/piccc1.jpg" style="height:500px; width:100%; object-fit:cover;">
            </div>
            <div class="swiper-slide">
              <img src="Pictures/davinza_banner_3.jpg" style="height:500px; width:100%; object-fit:cover;">
            </div>
          </div>
        </div>
      </div>

    </div>
</section>

<!-- ================= FIND DOCTOR ================= -->
<section class="bg-white py-5 shadow-sm">
  <div class="container">
    <div class="p-4 p-md-5 rounded-4" style="background: linear-gradient(to right, #eff6ff, #faf5ff);">
      <div class="row align-items-center g-4">

        <div class="col-lg-6">
          <h2 class="fw-bold mb-3 display-6"> Temukan Dokter yang Tersedia </h2>
          <p class="mb-4 fs-5 text-secondary">Pilih spesialis dan tanggal kedatangan Anda.</p>
        </div>

        <div class="col-lg-6">
          <div class="bg-white rounded-4 shadow p-4">

            <form action="index.php" method="GET">
              <input type="hidden" name="action" value="temukandokter">

              <!-- SPESIALIS -->
              <div class="mb-4">
                <label class="form-label">Pilih Spesialis</label>
                <select name="spesialis" class="form-select" required>
                  <option value="">-- Pilih Spesialis --</option>

                  <?php foreach ($spesialisList as $spesialis): ?>
                      <option value="<?= htmlspecialchars($spesialis); ?>">
                          <?= htmlspecialchars($spesialis); ?>
                      </option>
                  <?php endforeach; ?>


                </select>
              </div>

              <!-- TANGGAL -->
              <div class="mb-4">
                <label class="form-label">Tanggal Temu</label>
                <input type="date" name="tanggal" class="form-control" required>
              </div>

              <button type="submit" class="btn btn-primary w-100 fs-5 py-2">
                Temukan Dokter
              </button>

            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . "/Halaman/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: { delay: 3500 },
    effect: "fade"
  });
</script>

</body>
</html>
