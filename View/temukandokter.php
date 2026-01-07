<?php include __DIR__ . "/Halaman/header.php"; ?>

<style>
.doctor-hero {
    position: relative;
    background: url('Pictures/ramedokternya.jpg') center/cover no-repeat;
    min-height: 320px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 50px;
    overflow: hidden;
}
.doctor-hero::after {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(1px);
}
.doctor-hero h1 {
    z-index: 5;
    color: #fff;
    font-size: 48px;
    font-weight: 800;
    letter-spacing: 1px;
    text-shadow: 0 3px 10px rgba(0,0,0,0.7);
}
.doctor-card { border-radius: 20px; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.12);}
.doctor-card:hover { transform: translateY(-10px); box-shadow: 0 8px 25px rgba(0,0,0,0.18);}
.doctor-img { width: 100%; aspect-ratio: 16/20; object-fit: cover; object-position: center; background: #f5f5f5; border-bottom: 4px solid #0d6efd22;}
.badge-spec { background: #0d6efd; color: white; padding: 6px 12px; border-radius: 8px; font-size: 13px;}
</style>

<div class="container">

    <div class="doctor-hero">
        <h1 class="fw-bold display-5">Dokter <?= htmlspecialchars($_GET['spesialis'] ?? 'Tersedia'); ?></h1>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Cari dokter atau spesialis...">
        </div>
    </div>

    <div class="row" id="doctorList">

        <?php if(mysqli_num_rows($dokter) > 0): ?>
            <?php while ($d = mysqli_fetch_assoc($dokter)) : ?>
            <?php
                $fotoPath = "Pictures/dokter" . $d['dokter_id'] . ".jpg";
                if (!file_exists($fotoPath)) {
                    $fotoPath = "Pictures/dokter/default.jpg";
                }
            ?>
            <div class="col-md-4 mb-4 doctor-item">
                <div class="card doctor-card">
                    <img src="<?= $fotoPath ?>" class="doctor-img" alt="Foto Dokter">
                    <div class="card-body">
                        <h4 class="fw-bold"><?= $d['nama']; ?></h4>
                        <p class="badge-spec"><?= $d['spesialis']; ?></p>
                        <p class="mt-3 mb-1"><strong>No. STR:</strong><br><?= $d['no_str']; ?></p>
                        <a href="index.php?action=janjitemu&id_dokter=<?= $d['dokter_id']; ?>" class="btn btn-primary w-100 mt-3">Buat Janji</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-danger text-center fs-5">Dokter dengan spesialis ini tidak tersedia.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
// Live Search
document.getElementById('searchInput').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let items = document.querySelectorAll('.doctor-item');
    items.forEach(item => {
        let text = item.innerText.toLowerCase();
        item.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

<?php include __DIR__ . "/Halaman/footer.php"; ?>