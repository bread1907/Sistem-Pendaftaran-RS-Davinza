<?php include __DIR__ . '../Halaman/header.php'; ?>

<style>
/* Section layanan dengan background gambar */
.services-section {
    padding: 80px 20px;
    text-align: center;
    background: url('Pictures/ramahbgt.jpg') no-repeat center center/cover;
    position: relative;
    color: white;
}

.services-section::before {
    content: "";
    position: absolute;
    top:0; left:0; right:0; bottom:0;
    background-color: rgba(0,0,0,0.5); /* overlay gelap agar teks terbaca */
    z-index:1;
}

.services-section h2,
.services-section p.description {
    position: relative;
    z-index:2; /* agar berada di atas overlay */
}

.services-section h2 {
    font-size: 36px;
    margin-bottom: 15px;
    font-weight: 600;
}

.services-section p.description {
    font-size: 18px;
    margin-bottom: 50px;
}

/* Card layanan */
.services-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    position: relative;
    z-index:2; /* agar berada di atas overlay */
}

.service-card {
    background: white;
    border-radius: 10px;
    width: 320px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
}

.service-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.service-card .service-info {
    padding: 20px;
    text-align: left;
}

.service-card .service-info h3 {
    font-size: 22px;
    margin-bottom: 10px;
    color: #0077C0;
}

.service-card .service-info p {
    font-size: 16px;
    color: #555;
    line-height: 1.5;
}

/* Responsif */
@media(max-width: 768px){
    .services-container {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<section class="services-section">
    <h2>Layanan Kesehatan Kami</h2>
    <p class="description">RS Davinza menyediakan berbagai layanan kesehatan profesional dengan fasilitas modern dan tenaga medis berpengalaman.</p>

    <div class="services-container">
        <div class="service-card">
            <img src="Pictures/poliklinikumum.jpg" alt="Poliklinik Umum">
            <div class="service-info">
                <h3>Poliklinik Umum</h3>
                <p>Memberikan layanan pemeriksaan kesehatan untuk semua usia, konsultasi dokter umum dan spesialis, serta layanan rawat jalan yang nyaman.</p>
            </div>
        </div>

        <div class="service-card">
            <img src="Pictures/laboratorium.jpg" alt="Laboratorium">
            <div class="service-info">
                <h3>Laboratorium</h3>
                <p>Menyediakan pemeriksaan laboratorium lengkap mulai dari darah, urin, hingga pemeriksaan diagnostik khusus dengan peralatan modern.</p>
            </div>
        </div>

        <div class="service-card">
            <img src="Pictures/radiologi.jpg" alt="Radiologi">
            <div class="service-info">
                <h3>Radiologi & Imaging</h3>
                <p>Pemeriksaan radiologi termasuk X-ray, USG, CT-Scan dan MRI dengan akurasi tinggi untuk mendukung diagnosis yang cepat dan tepat.</p>
            </div>
        </div>

        <div class="service-card">
            <img src="Pictures/apotek.jpg" alt="Apotek">
            <div class="service-info">
                <h3>Apotek</h3>
                <p>Menyediakan obat-obatan resmi dan konsultasi farmasi untuk memastikan pengobatan pasien aman dan efektif.</p>
            </div>
        </div>

        <div class="service-card">
            <img src="Pictures/gdt.jpg" alt="Gawat Darurat">
            <div class="service-info">
                <h3>Gawat Darurat</h3>
                <p>Layanan IGD 24 jam dengan tim medis siap siaga untuk menangani kondisi darurat dan kritis dengan cepat dan profesional.</p>
            </div>
        </div>

        <div class="service-card">
            <img src="Pictures/ibudananak.jpg" alt="KIA">
            <div class="service-info">
                <h3>Kesehatan Ibu & Anak</h3>
                <p>Memberikan layanan konsultasi, pemeriksaan kehamilan, persalinan, imunisasi, dan perawatan anak dengan standar kesehatan terbaik.</p>
            </div>
        </div>

        <div class="service-card">
            <img src="Pictures/rehab.jpg" alt="Rehabilitasi">
            <div class="service-info">
                <h3>Rehabilitasi Medis</h3>
                <p>Layanan terapi fisik dan rehabilitasi untuk pasien pasca operasi, cedera, atau kondisi kronis agar dapat kembali beraktivitas normal.</p>
            </div>Radiologi
        </div>

    </div>
</section>
<?php include __DIR__ . '../Halaman/footer.php'; ?>
