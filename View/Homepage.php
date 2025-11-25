<?php include __DIR__ . "/Halaman/header.php";?>

<!-- Modal Login-->
  <div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title d-flex "> <i class="bi bi-person-circle me-2"></i> Masuk Pengguna </h5> <button
              type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body"> <!-- Email -->
            <div class="mb-3"> <label class="form-label">Email address</label> <input type="email"
                class="form-control shadow-none"> </div> <!-- Password -->
            <div class="mb-4"> <label class="form-label">Password</label> <input type="password"
                class="form-control shadow-none"> </div>
            <div class="d-flex align-items-center justify-content-between mb-2"> <button type="submit"
                class="btn btn-dark shadow-none">Login</button> <a href="javascript: void(0)"
                class="text-secondary text-decoration-none">Lupa Password?</a> </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Daftar -->
  <div class="modal fade" id="modalDaftar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center"> <i class="bi bi-person-add me-2"></i>Daftar
              Pengguna </h5> <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <div class="modal-body"> <span class="badge bg-light text-dark mb-3 text-wrap lh-base"> Gunakan
              informasi yang lengkap dan akurat. Informasi pribadi Anda hanya digunakan untuk keperluan
              pendaftaran dan keamanan akun. Data tidak akan dibagikan kepada pihak lain tanpa izin Anda. </span>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 ps-0 mb-3"> <label class="form-label">Nama</label> <input type="text"
                    class="form-control shadow-none"> </div>
                <div class="col-md-6 p-0 mb-3"> <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                  <input type="number" class="form-control shadow-none">
                </div>
                <div class="col-md-6 ps-0 mb-3"> <label class="form-label">Tanggal Lahir</label> <input type="date"
                    class="form-control shadow-none"> </div>
                <div class="col-md-6 p-0 mb-3"> <label class="form-label">Nomor Telepon aktif</label> <input
                    type="number" class="form-control shadow-none"> </div>
                <div class="col-md-12 p-0 mb-3"> <label class="form-label">Alamat</label> <textarea
                    class="form-control shadow-none" rows="1"></textarea> </div>
                <div class="col-md-6 ps-0 mb-3"> <label class="form-label">Kata Sandi</label> <input type="password"
                    class="form-control shadow-none"> </div>
                <div class="col-md-6 p-0 mb-3"> <label class="form-label">Konfirmasi Kata Sandi</label> <input
                    type="password" class="form-control shadow-none"> </div>
              </div>
            </div>
            <div class="text-center my-1"> <button type="submit" class="btn btn-dark shadow-none">Buat
                Akun</button>
            </div>

          </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <!-- Carousel -->
  <div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="../Pictures/piccc1.jpg" class="w-100 h-90 d-block" />
        </div>

        <div class="swiper-slide">
          <img src="../Pictures/davinza_banner_3.jpg" class="w-100 h-90 d-block" />
        </div>
      </div>
    </div>
  </div>

  <div class="container quick-stats">
    <div class="row">
      <div class="col-lg-12 bg-white shadow p-4 rounded">
        <p class="text-xl text-text-secondary leading-relaxed">
          Experience healthcare that combines cutting-edge medical innovation with compassionate, personalized care.
          Your healing journey begins with understanding.
        </p>
        <div class="border-top pt-4">
          <div class="row text-center g-4">

            <!-- Patients Treated -->
            <div class="col-12 col-md-4">
              <div class="fs-2 fw-bold" style="color: var(--primary);">50K+</div>
              <div class="text-muted">Pasien yang Dirawat</div>
            </div>

            <!-- Expert Doctors -->
            <div class="col-12 col-md-4">
              <div class="fs-2 fw-bold" style="color: var(--primary);">200+</div>
              <div class="text-muted">Dokter Ahli</div>
            </div>

            <!-- Satisfaction Rate -->
            <div class="col-12 col-md-4">
              <div class="fs-2 fw-bold" style="color: var(--primary);">98%</div>
              <div class="text-muted">Tingkat Kepuasan</div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Script Carousel -->
  <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },
    });
  </script>

  <section class="bg-white py-5 shadow-sm">
    <div class="container">
      <div class="p-4 p-md-5 rounded-4" style="background: linear-gradient(to right, #eff6ff, #faf5ff);">
        <div class="row align-items-center g-4">

          <!-- Left Text -->
          <div class="col-lg-6">
            <h2 class="fw-bold mb-3 display-6">
              Jadwalkan Janji Temu Anda Hari Ini
            </h2>
            <p class="mb-4 fs-5 text-secondary">
              Buat janji dengan dokter spesialis kami dan dapatkan perawatan yang Anda butuhkan.
              Ketersediaan real-time di semua spesialisasi.
            </p>
          </div>

          <!-- Form -->
          <div class="col-lg-6">
            <div class="bg-white rounded-4 shadow p-4">

              <form>
                <div class="mb-4">
                  <label class="form-label">Pilih Spesialis</label>
                  <select class="form-select">
                    <option>Cardiology</option>
                    <option>Orthopedics</option>
                    <option>Neurology</option>
                    <option>Pediatrics</option>
                    <option>General Medicine</option>
                  </select>
                </div>

                <div class="mb-4">
                  <label class="form-label">Tanggal yang Diinginkan</label>
                  <input type="date" class="form-control" min="2025-11-25">
                </div>

                <div class="mb-4">
                  <label class="form-label">Slot Waktu</label>
                  <select class="form-select">
                    <option>Pagi (8:00 AM - 12:00 PM)</option>
                    <option>Siang (12:00 PM - 4:00 PM)</option>
                    <option>Malam (4:00 PM - 8:00 PM)</option>
                  </select>
                </div>

                <div>
                  <a href="find_a_doctor.html" class="btn btn-primary w-100 fs-5 py-2">
                    Temukan Dokter yang Tersedia
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include __DIR__ . "/Halaman/footer.php";?>