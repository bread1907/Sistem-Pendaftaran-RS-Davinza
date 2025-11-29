<?php include __DIR__ . '../Halaman/header.php'; ?>

<style>
:root {
    --primary: #0077C0;
}

/* HERO SECTION */
.about-hero {
    position: relative;
    background: url('Pictures/doktersenyum.jpg') center/cover no-repeat;
    min-height: 700px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transform: translateY(20px);
    transition: all 1s ease;
}

.about-hero.visible {
    opacity: 1;
    transform: translateY(0);
}

.about-hero::before {
    content: "";
    position: absolute;
    top:0; left:0; right:0; bottom:0;
    background: rgba(0,0,0,0.4);
    z-index: -1;
}

.about-hero h1 {
    position: relative;
    z-index: 2;
}

/* GENERAL SECTIONS */
.about-section {
    line-height: 1.8;
    font-size: 17px;
    opacity: 0;
    transform: translateY(20px);
    transition: all 1s ease;
    position: relative; /* penting */
    z-index: 1; /* jangan menutupi navbar */
}

.about-section.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Layanan Unggulan */
.services-container {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
}

.service-card {
    background:white;
    border-radius: 10px;
    width: 300px;
    padding:20px;
    text-align:center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.service-card i {
    font-size: 40px;
    color: var(--primary);
    margin-bottom: 10px;
}

/* RESPONSIVE */
@media(max-width: 768px){
    .services-container {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<!-- HERO -->
<section class="about-hero mb-5">
    <h1 class="fw-bold display-5">Tentang Kami</h1>
</section>

<div class="container">

    <!-- INTRO -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 about-section">
            <h2 class="fw-bold mb-3">RS Davinza – Peduli, Profesional, dan Modern</h2>
            <p>
                RS Davinza adalah pusat layanan kesehatan modern yang mengutamakan
                <strong>keselamatan pasien, inovasi medis, dan pelayanan yang penuh empati</strong>.
            </p>
            <p>
                Dengan dokter spesialis berpengalaman, fasilitas lengkap, dan teknologi kesehatan terkini,
                kami memastikan pasien mendapatkan perawatan optimal.
            </p>
        </div>
        <div class="col-lg-6">
            <img src="Pictures/gedung.jpg" class="w-100 rounded-img shadow" alt="RS Davinza">
        </div>
    </div>

    <!-- VISI MISI -->
    <div class="my-5 about-section">
        <h2 class="fw-bold mb-3">Visi & Misi</h2>
        <div class="p-4 bg-light rounded-4 shadow-sm">
            <h4 class="fw-bold">Visi</h4>
            <p>Menjadi rumah sakit unggulan yang mengutamakan pelayanan kesehatan modern dan berorientasi pada keselamatan pasien.</p>

            <h4 class="fw-bold mt-4">Misi Kami</h4>
            <ul>
                <li>Memberikan pelayanan kesehatan dengan standar profesional tinggi.</li>
                <li>Mengutamakan keselamatan, kenyamanan, dan kepuasan pasien.</li>
                <li>Menyediakan layanan gawat darurat & poliklinik 24 jam.</li>
                <li>Mengembangkan pelayanan spesialis berbasis teknologi modern.</li>
                <li>Mengedukasi masyarakat untuk hidup sehat dan sejahtera.</li>
            </ul>
        </div>
    </div>

    <!-- LAYANAN UNGGULAN -->
    <div class="my-5">
        <h2 class="fw-bold mb-4 about-section text-center">Layanan Unggulan Kami</h2>
        <div class="services-container">
            <div class="service-card about-section">
                <i class="bi bi-heart-pulse"></i>
                <h5 class="fw-bold mt-3">IGD 24 Jam</h5>
                <p>Tim gawat darurat profesional siap menangani kondisi kritis kapan saja.</p>
            </div>
            <div class="service-card about-section">
                <i class="bi bi-people-fill"></i>
                <h5 class="fw-bold mt-3">Dokter Spesialis</h5>
                <p>Berbagai dokter spesialis berpengalaman untuk kebutuhan kesehatan Anda.</p>
            </div>
            <div class="service-card about-section">
                <i class="bi bi-hospital"></i>
                <h5 class="fw-bold mt-3">Rawat Inap Nyaman</h5>
                <p>Fasilitas rawat inap bersih, aman, dan nyaman untuk keluarga.</p>
            </div>
        </div>
    </div>

    <!-- TIM MEDIS -->
    <div class="my-5 row align-items-center">
        <div class="col-lg-6">
            <img src="Pictures/dokterdokter.jpg" class="w-100 rounded-img shadow" alt="Tim Medis RS Davinza">
        </div>
        <div class="col-lg-6 mt-4 about-section">
            <h2 class="fw-bold mb-3">Tim Medis Profesional</h2>
            <p>
                RS Davinza memiliki tim dokter, perawat, dan tenaga ahli yang berkompeten di berbagai bidang.
            </p>
            <p>
                Kombinasi antara <strong>teknologi modern</strong> dan <strong>sentuhan kemanusiaan</strong> adalah kunci kesembuhan.
            </p>
        </div>
    </div>

    <!-- CONTACT -->
    <div class="my-5 p-4 shadow rounded-4 bg-white about-section">
        <h2 class="fw-bold mb-3">Hubungi Kami</h2>
        <p>Untuk informasi lebih lanjut atau membuat janji temu:</p>
        <p>
            <strong>Call Center:</strong> 15000-88 <br>
            <strong>Email:</strong> info@rsdavinza.com <br>
            <strong>Alamat:</strong> Jl. Sehat Selalu No. 12, Indonesia
        </p>
    </div>

</div>

<script>
  // Animasi fade-in tanpa menutupi dropdown
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      entry.target.classList.add('visible');
    });
  }, { threshold: 0.2 });

  document.querySelectorAll('.about-hero, .about-section, .feature-icon, .rounded-img').forEach(el => {
    observer.observe(el);
  });
</script>

<?php include __DIR__ . '../Halaman/footer.php'; ?>
