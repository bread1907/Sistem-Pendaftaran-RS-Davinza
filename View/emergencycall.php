<?php include __DIR__ . '../Halaman/header.php'; ?>

<style>
    body {
        background: #f2f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .emergency-container {
        max-width: 1100px;
        margin: 50px auto;
        padding: 30px;
    }

    .hero {
        background: linear-gradient(135deg, #0d47a1, #1976d2);
        border-radius: 20px;
        padding: 50px 30px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 30px;
        margin-bottom: 40px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .hero img {
        width: 200px;
        max-width: 100%;
    }

    .hero-text h1 {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .hero-text p {
        font-size: 18px;
        opacity: 0.95;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
    }

    .card {
        background: #fff;
        border-radius: 18px;
        padding: 30px 25px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.18);
    }

    .card img {
        width: 80px;
        margin-bottom: 15px;
    }

    .card h3 {
        font-size: 22px;
        color: #0d47a1;
        margin-bottom: 8px;
    }

    .card p {
        font-size: 15px;
        color: #555;
        margin-bottom: 18px;
    }

    .card a {
        display: inline-block;
        padding: 12px 28px;
        background: #1976d2;
        color: #fff;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .card a:hover {
        background: #0d47a1;
    }

    .info {
        margin-top: 40px;
        text-align: center;
        font-size: 14px;
        color: #666;
    }

    @media(max-width: 768px){
        .hero{
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="emergency-container">

    <div class="hero">
        <img src="https://cdn-icons-png.flaticon.com/512/2967/2967350.png" alt="Emergency">
        <div class="hero-text">
            <h1>Kontak Darurat Rumah Sakit</h1>
            <p>Pelayanan medis cepat, aman, dan profesional selama 24 jam</p>
        </div>
    </div>

    <div class="card-grid">
        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/3050/3050525.png" alt="IGD">
            <h3>IGD 24 Jam</h3>
            <p>Penanganan pasien gawat darurat setiap saat.</p>
            <a href="tel:119">Hubungi 119</a>
        </div>

        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/2967/2967357.png" alt="Ambulans">
            <h3>Ambulans</h3>
            <p>Layanan ambulans cepat dan siaga.</p>
            <a href="tel:0211234567">021-123-4567</a>
        </div>

        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" alt="Call Center">
            <h3>Call Center</h3>
            <p>Informasi dokter & layanan rumah sakit.</p>
            <a href="tel:0217654321">021-765-4321</a>
        </div>

        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/4320/4320337.png" alt="Covid">
            <h3>Unit Isolasi</h3>
            <p>Penanganan penyakit menular & isolasi.</p>
            <a href="tel:1199">119 ext. 9</a>
        </div>
    </div>

    <div class="info">
        ⚠️ Dalam kondisi darurat berat, segera hubungi layanan medis terdekat.
    </div>

</div>

<?php include __DIR__ . '../Halaman/footer.php'; ?>