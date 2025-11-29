<?php include __DIR__ . "../Halaman/header.php"; ?>
<?php
include __DIR__ . "../../koneksi.php";

// Pastikan user sudah login
// session_start();
$username = $_SESSION['username'] ?? '';
$pasien_id = $_SESSION['pasien_id'] ?? 0; // id pasien dari login

// Ambil daftar spesialis unik
$spesialisList = [];
$sql = "SELECT DISTINCT spesialis FROM dokter ORDER BY spesialis ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $spesialisList[] = $row['spesialis'];
    }
}
?>

<style>
:root { --primary: #0077C0; }
.form-hero { padding: 80px 20px; background-color: #f5f5f5; }
.form-row { display:flex; align-items:stretch; justify-content:center; gap:50px; flex-wrap:nowrap; max-width:1200px; margin:0 auto; }
.form-image { flex:1 1 45%; min-width:300px; border-radius:20px; overflow:hidden; opacity:0; transform:translateY(20px); transition:all 1s ease; }
.form-image img { width:100%; height:100%; object-fit:cover; display:block; }
.form-card { flex:1 1 45%; min-width:300px; background:rgba(255,255,255,0.95); padding:40px 30px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.2); opacity:0; transform:translateY(20px); transition:all 1s ease; }
.form-card.visible, .form-image.visible { opacity:1; transform:translateY(0); }
.form-label { font-weight:600; }
.form-control, .form-select, textarea { border-radius:12px; padding:10px 15px; transition:all 0.3s ease; }
.form-control:focus, .form-select:focus, textarea:focus { border-color: var(--primary); box-shadow:0 0 10px rgba(0,119,192,0.3); }
.btn-primary { background-color: var(--primary); border-color: var(--primary); font-weight:600; transition:all 0.3s ease; }
.btn-primary:hover { background-color:#005a8c; border-color:#005a8c; transform:translateY(-2px); }
.form-card h3 { color: var(--primary); margin-bottom:25px; text-align:center; }
.text-danger { font-size: 0.875rem; margin-top:5px; display:block; }
@media(max-width:991px){ .form-row { flex-direction:column; gap:30px; } .form-image, .form-card { max-width:100%; } }
</style>

<section class="form-hero">
    <div class="form-row">

        <!-- LEFT IMAGE -->
        <div class="form-image">
            <img src="Pictures/ruangtunggu.jpg" alt="Dokter RS Davinza">
        </div>

        <!-- RIGHT FORM -->
        <div class="form-card">
            <h3><i class="bi bi-calendar-check me-2"></i>Form Jadwal Temu</h3>

            <form action="index.php?action=simpan_jadwal" method="POST">

                <!-- SPESIALIS -->
                <div class="mb-3">
                    <label class="form-label">Spesialis</label>
                    <select id="spesialis" name="spesialis" class="form-select" required>
                        <option value="">-- Pilih Spesialis --</option>
                        <?php foreach($spesialisList as $s): ?>
                            <option value="<?=htmlspecialchars($s)?>"><?=htmlspecialchars($s)?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- DOKTER -->
                <div class="mb-3">
                    <label class="form-label">Dokter</label>
                    <select id="dokter" name="dokter_id" class="form-select" required>
                        <option value="">-- Pilih Dokter --</option>
                    </select>
                </div>

                <!-- NAMA PASIEN -->
                <div class="mb-3">
                    <label class="form-label">Nama Pasien</label>
                    <input type="text" name="nama_pasien" class="form-control" value="<?=htmlspecialchars($username)?>" readonly>
                    <input type="hidden" name="pasien_id" value="<?=intval($pasien_id)?>">
                </div>

                <!-- JENIS PEMBAYARAN -->
                <div class="mb-3">
                    <label class="form-label">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" class="form-select" required>
                        <option value="">-- Pilih Jenis Pembayaran --</option>
                        <option value="BPJS">BPJS</option>
                        <option value="Mandiri">Mandiri</option>
                    </select>
                </div>

                <!-- TANGGAL TEMU -->
                <div class="mb-3">
                    <label class="form-label">Tanggal Temu</label>
                    <input type="date" id="tanggal_temu" name="tanggal_temu" class="form-control" required>
                    <small id="hariNotice" class="text-danger"></small>
                </div>

                <!-- JAM TEMU -->
                <div class="mb-3">
                    <label class="form-label">Jam Temu</label>
                    <input type="text" id="jam_temu" name="jam_temu" class="form-control" placeholder="08:00 - 12:00" readonly required>
                </div>

                <!-- DIAGNOSA AWAL -->
                <div class="mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" class="form-control" rows="3" placeholder="Masukkan keluhan"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mt-3">Simpan Jadwal</button>
            </form>
        </div>

    </div>
</section>

<script>
let dokterHariPraktek = [];

// Ambil dokter berdasarkan spesialis via AJAX
document.getElementById('spesialis').addEventListener('change', function(){
    const spesialis = this.value;
    const dokterSelect = document.getElementById('dokter');
    dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
    dokterHariPraktek = [];

    if(spesialis){
        fetch('requestajax.php?spesialis=' + encodeURIComponent(spesialis))
        .then(res => res.json())
        .then(data => {
            data.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.dokter_id;
                opt.textContent = d.nama;
                opt.dataset.hari = d.hari_praktek;
                opt.dataset.jamMulai = d.jam_mulai;
                opt.dataset.jamSelesai = d.jam_selesai;
                dokterSelect.appendChild(opt);
            });
        });
    }
});

// Saat dokter dipilih, isi jam temu dan simpan hari praktek
document.getElementById('dokter').addEventListener('change', function(){
    const selected = this.options[this.selectedIndex];
    dokterHariPraktek = selected.dataset.hari ? selected.dataset.hari.split(',').map(h=>h.trim()) : [];
    const jamMulai = selected.dataset.jamMulai || '';
    const jamSelesai = selected.dataset.jamSelesai || '';

    const jamInput = document.getElementById('jam_temu');
    if(jamMulai && jamSelesai){
        jamInput.value = `${jamMulai} - ${jamSelesai}`;
    } else {
        jamInput.value = '';
    }

    document.getElementById('hariNotice').textContent = '';
});

// Validasi tanggal sesuai hari praktek dokter
document.getElementById('tanggal_temu').addEventListener('change', function(){
    const tanggal = new Date(this.value);
    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const dayName = days[tanggal.getDay()];

    const noticeEl = document.getElementById('hariNotice');

    if(dokterHariPraktek.length > 0 && !dokterHariPraktek.includes(dayName)){
        noticeEl.textContent = `Dokter hanya tersedia pada hari: ${dokterHariPraktek.join(', ')}`;
    } else {
        noticeEl.textContent = '';
    }
});

// Animasi fade-in
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.2 });
document.querySelectorAll('.form-card, .form-image').forEach(el => observer.observe(el));
</script>

<?php include __DIR__ . "../Halaman/footer.php"; ?>
