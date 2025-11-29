<?php include __DIR__ . "/Halaman/header.php"; ?>

<div class="container my-5">
    <h2 class="mb-5 text-center text-success fw-bold" style="text-shadow: 1px 1px 2px #000;">Fasilitas Unik & Inovatif RS Kami</h2>

    <div class="row g-4">
        <?php
        $fasilitasUnik = [
            ['nama'=>'Ruang Relaksasi & Musik','deskripsi'=>'Nikmati terapi musik dan ruang relaksasi untuk mengurangi stres dan mempercepat pemulihan.','gambar'=>'Pictures/relaksasi.jpg','icon'=>'🎵'],
            ['nama'=>'Kafetaria & Nutrisi Sehat','deskripsi'=>'Menu sehat, bergizi, dan lezat khusus untuk pasien dan pengunjung.','gambar'=>'Pictures/cafetaria.jpg','icon'=>'🥗'],
            ['nama'=>'Ruang Edukasi & Workshop','deskripsi'=>'Kelas kesehatan, seminar diet, dan edukasi pencegahan penyakit.','gambar'=>'Pictures/edukasi.jpg','icon'=>'📚'],
            ['nama'=>'Virtual Consultation Room','deskripsi'=>'Konsultasi dokter online dari rumah sakit dengan teknologi terkini.','gambar'=>'Pictures/konsultasi.jpg','icon'=>'💻'],
            ['nama'=>'Ruang Kreatif Anak','deskripsi'=>'Playground dan aktivitas kreatif agar anak-anak nyaman saat perawatan.','gambar'=>'Pictures/kreatifanak.jpg','icon'=>'🧸'],
            ['nama'=>'Healing Garden & Taman Hijau','deskripsi'=>'Taman asri untuk terapi, jalan kaki, dan meditasi pasien.','gambar'=>'Pictures/garden.jpg','icon'=>'🌿'],
            ['nama'=>'Smart Room Technology','deskripsi'=>'Kamar pintar dengan monitoring otomatis dan kenyamanan teknologi modern.','gambar'=>'Pictures/kamar.jpg','icon'=>'🤖'],
        ];

        foreach($fasilitasUnik as $f):
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card position-relative overflow-hidden rounded-4 shadow-lg hover-card" style="min-height:350px; transition: all 0.4s;">
                <div class="card-body text-center py-5 px-3 overlay-content">
                    <h1 class="icon mb-3"><?= $f['icon']; ?></h1>
                    <h5 class="card-title fw-bold"><?= htmlspecialchars($f['nama']); ?></h5>
                    <p class="card-text text-muted"><?= htmlspecialchars($f['deskripsi']); ?></p>
                </div>
                <img src="<?= $f['gambar']; ?>" class="card-img-bottom" alt="<?= htmlspecialchars($f['nama']); ?>" style="height:150px; object-fit:cover;">
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.hover-card {
    background: linear-gradient(135deg, #e0f7fa 0%, #f0f8ff 100%);
}
.hover-card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 15px 40px rgba(0,200,83,0.6);
}
.overlay-content {
    background: rgba(255,255,255,0.85);
    border-radius: 1rem;
    position: relative;
    z-index: 2;
}
.icon {
    font-size: 3rem;
    animation: bounce 1s infinite;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
</style>

<?php include __DIR__ . "/Halaman/footer.php"; ?>
