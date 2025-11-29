<?php include __DIR__ . "../Halaman//header.php"; ?>
<style>
    .about-hero {
        background: url('../Pictures/davinza_banner2.jpg') center/cover no-repeat;
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-shadow: 0 3px 5px rgba(0,0,0,0.6);
    }

    .about-section {
        line-height: 1.8;
        font-size: 17px;
    }

    .feature-icon {
        font-size: 40px;
        color: var(--primary);
    }

    .rounded-img {
        border-radius: 15px;
    }
    .about-hero {
    position: relative;
    background: url('../Pictures/davinza_banner2.jpg') center/cover no-repeat;
    min-height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.about-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(59, 130, 246, 0.5); /* biru transparan */
    backdrop-filter: brightness(0.8);
}

.about-hero h1 {
    position: relative; /* supaya tidak kena overlay */
    z-index: 2;
}

</style>

<!-- HERO SECTION -->
<section class="about-hero mb-5">
    <h1 class="fw-bold display-5">Tentang Kami</h1>
</section>

<div class="container">

    <!-- INTRO -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4">
            <h2 class="fw-bold mb-3">RS Davinza – Peduli, Profesional, dan Modern</h2>
            <p class="about-section">
                RS Davinza adalah pusat layanan kesehatan modern yang mengutamakan <strong>keselamatan pasien,
                inovasi medis, dan pelayanan yang penuh empati</strong>. Mengadopsi standar layanan ala
                rumah sakit profesional seperti Awal Bros, kami hadir untuk memberikan pelayanan terbaik
                bagi masyarakat.
            </p>
            <p class="about-section">
                Dengan dokter spesialis berpengalaman, fasilitas lengkap, dan teknologi kesehatan terkini,
                kami memastikan pasien mendapatkan perawatan optimal dan kenyamanan selama pemulihan.
            </p>
        </div>

        <div class="col-lg-6">
            <img src="../Pictures/gedung.jpg" class="w-100 rounded-img shadow" alt="RS Davinza">
        </div>
    </div>

    <!-- VISI MISI -->
    <div class="my-5">
        <h2 class="fw-bold mb-3">Visi & Misi</h2>
        <div class="p-4 bg-light rounded-4 shadow-sm">

            <h4 class="fw-bold">Visi</h4>
            <p class="about-section">
                Menjadi rumah sakit unggulan yang mengutamakan pelayanan kesehatan modern dan berorientasi pada keselamatan pasien.
            </p>

            <h4 class="fw-bold mt-4">Misi Kami</h4>
            <ul class="about-section">
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
        <h2 class="fw-bold mb-4">Layanan Unggulan Kami</h2>

        <div class="row g-4">
            <div class="col-md-4 text-center">
                <i class="bi bi-heart-pulse feature-icon"></i>
                <h5 class="fw-bold mt-3">IGD 24 Jam</h5>
                <p class="text-secondary">Tim gawat darurat profesional siap menangani kondisi kritis kapan saja.</p>
            </div>

            <div class="col-md-4 text-center">
                <i class="bi bi-people-fill feature-icon"></i>
                <h5 class="fw-bold mt-3">Dokter Spesialis</h5>
                <p class="text-secondary">Berbagai dokter spesialis berpengalaman untuk kebutuhan kesehatan Anda.</p>
            </div>

            <div class="col-md-4 text-center">
                <i class="bi bi-hospital feature-icon"></i>
                <h5 class="fw-bold mt-3">Rawat Inap Nyaman</h5>
                <p class="text-secondary">Fasilitas rawat inap bersih, aman, dan nyaman untuk keluarga.</p>
            </div>
        </div>
    </div>

    <!-- TIM MEDIS -->
    <div class="my-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="../Pictures/dokterdokter.jpg" class="w-100 rounded-img shadow" alt="Tim Medis RS Davinza">
            </div>

            <div class="col-lg-6 mt-4">
                <h2 class="fw-bold mb-3">Tim Medis Profesional</h2>
                <p class="about-section">
                    RS Davinza memiliki tim dokter, perawat, dan tenaga ahli yang berkompeten di berbagai bidang.
                    Mengikuti semangat pelayanan rumah sakit besar, kami menjunjung tinggi etika dan profesionalitas
                    dalam merawat pasien.
                </p>
                <p class="about-section">
                    Kami percaya bahwa kombinasi antara <strong>teknologi modern</strong> dan
                    <strong>sentuhan kemanusiaan</strong> adalah kunci kesembuhan.
                </p>
            </div>
        </div>
    </div>

    <!-- CONTACT -->
    <div class="my-5 p-4 shadow rounded-4 bg-white">
        <h2 class="fw-bold mb-3">Hubungi Kami</h2>
        <p class="about-section">Untuk informasi lebih lanjut atau membuat janji temu:</p>

        <p class="about-section">
            <strong>Call Center:</strong> 15000-88 <br>
            <strong>Email:</strong> info@rsdavinza.com <br>
            <strong>Alamat:</strong> Jl. Sehat Selalu No. 12, Indonesia
        </p>
    </div>

</div>


<?php include __DIR__ . "../Halaman/footer.php"; ?>
