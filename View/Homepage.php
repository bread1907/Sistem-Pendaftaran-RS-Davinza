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
    .blue-primary {
      color:#0077C0 !important;
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

  </style>

</head>

<body>

  <?php include __DIR__ . "/Halaman/header.php"; ?>

  <section class="container py-5 position-relative">
    <div class="row align-items-center g-5">

      <div class="col-lg-6">
          <h1 class="display-3 fw-bold mt-4 text-dark">
          Advanced Care,<br>
          <span class="blue-primary">Personal Touch</span>
        </h1>
        

        <p class="fs-5 text-secondary mt-3">
          Nikmati layanan kesehatan yang menggabungkan inovasi medis terdepan dengan perawatan yang penuh empati dan disesuaikan dengan kebutuhan individu.
        </p>

        <div class="d-flex gap-3 mt-4 flex-wrap">
          <a href="find_a_doctor.html" class="btn btn-primary btn-lg d-flex align-items-center gap-2 px-4 shadow">
            Buat Janji Temu
          </a>

          <a href="emergency_care.html" class="btn btn-daftar btn-lg d-flex align-items-center gap-2 px-4">
            Penanganan Darurat
          </a>
        </div>

        <div class="row text-center mt-5 pt-4 border-top">
          <div class="col-4">
            <h3 class="blue-primary fw-bold">50K+</h3>
            <p class="text-secondary small mb-0">Pasien Terobati</p>
          </div>
          <div class="col-4">
            <h3 class="blue-primary fw-bold">200+</h3>
            <p class="text-secondary small mb-0">Dokter Spesialis</p>
          </div>
          <div class="col-4">
            <h3 class="blue-primary fw-bold">98%</h3>
            <p class="text-secondary small mb-0">Tingkat Kepuasan</p>
          </div>
        </div>
      </div>

      <!-- Carousel -->
      <div class="col-lg-6 position-relative">

        <div class="swiper mySwiper rounded-4 shadow overflow-hidden">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="../Pictures/piccc1.jpg" style="height:500px; width:100%; object-fit:cover;">
            </div>
            <div class="swiper-slide">
              <img src="../Pictures/davinza_banner_3.jpg" style="height:500px; width:100%; object-fit:cover;">
            </div>
          </div>
        </div>


    </div>
  </section>

  <section class="bg-white py-5 shadow-sm">
    <div class="container">
      <div class="p-4 p-md-5 rounded-4" style="background: linear-gradient(to right, #eff6ff, #faf5ff);">
        <div class="row align-items-center g-4"> <!-- Left Text -->
          <div class="col-lg-6">
            <h2 class="fw-bold mb-3 display-6"> Jadwalkan Janji Temu Anda Hari Ini </h2>
            <p class="mb-4 fs-5 text-secondary"> Buat janji dengan dokter spesialis kami dan dapatkan perawatan yang
              Anda butuhkan. Ketersediaan real-time di semua spesialisasi. </p>
          </div> <!-- Form -->
          <div class="col-lg-6">
            <div class="bg-white rounded-4 shadow p-4">
              <form>
                <div class="mb-4"> <label class="form-label">Pilih Spesialis</label> <select class="form-select">
                    <option>Cardiology</option>
                    <option>Orthopedics</option>
                    <option>Neurology</option>
                    <option>Pediatrics</option>
                    <option>General Medicine</option>
                  </select> </div>
                <div class="mb-4"> <label class="form-label">Tanggal yang Diinginkan</label> <input type="date"
                    class="form-control" min="2025-11-25"> </div>
                <div class="mb-4"> <label class="form-label">Slot Waktu</label> <select class="form-select">
                    <option>Pagi (8:00 AM - 12:00 PM)</option>
                    <option>Siang (12:00 PM - 4:00 PM)</option>
                    <option>Malam (4:00 PM - 8:00 PM)</option>
                  </select> </div>
                <div> <a href="find_a_doctor.html" class="btn btn-primary w-100 fs-5 py-2"> Temukan Dokter yang Tersedia
                  </a> </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__ . "/Halaman/footer.php"; ?>


  <!-- Bootstrap + Swiper JS -->
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