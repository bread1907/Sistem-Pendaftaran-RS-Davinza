<?php
// =============================
// SESSION FIX
// =============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =============================
// INCLUDE FIX
// =============================
include __DIR__ . "/Halaman/header.php";
include __DIR__ . "../../koneksi.php";

// =============================
// AMBIL DATA LOGIN
// =============================
$username   = $_SESSION['username'] ?? '';
$pasien_id  = $_SESSION['pasien_id'] ?? 0;

// =============================
// AMBIL DOKTER DARI URL
// =============================
$id_dokter_get = isset($_GET['id_dokter']) ? intval($_GET['id_dokter']) : 0;
$dokterData = null;

if ($id_dokter_get > 0) {
    $q = $conn->query("SELECT * FROM dokter WHERE dokter_id = $id_dokter_get");
    if ($q && $q->num_rows > 0) {
        $dokterData = $q->fetch_assoc();
    }
}

// =============================
// AMBIL SPESIALIS UNIK
// =============================
$spesialisList = [];
$r = $conn->query("SELECT DISTINCT spesialis FROM dokter ORDER BY spesialis ASC");
while ($row = $r->fetch_assoc()) {
    $spesialisList[] = $row['spesialis'];
}
?>

<style>
:root { --primary: #0077C0; }
.form-hero { padding: 80px 20px; background-color: #f5f5f5; }
.form-row { display:flex; align-items:stretch; justify-content:center; gap:50px; max-width:1200px; margin:0 auto; flex-wrap:nowrap; }
.form-image { flex:1; border-radius:20px; overflow:hidden; }
.form-image img { width:100%; height:100%; object-fit:cover; }
.form-card { flex:1; background:white; padding:40px 30px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
</style>

<section class="form-hero">
    <div class="form-row">

        <div class="form-image">
            <img src="Pictures/ruangtunggu.jpg" alt="">
        </div>

        <div class="form-card">

            <h3><i class="bi bi-calendar-check me-2"></i> Buat Janji Temu</h3>

            <form action="index.php?action=simpan_jadwal" method="POST">

                <!-- SPESIALIS -->
                <div class="mb-3">
                    <label class="form-label">Spesialis</label>
                    <select id="spesialis" name="spesialis" class="form-select" required>
                        <option value="">-- Pilih Spesialis --</option>

                        <?php foreach ($spesialisList as $s): ?>
                            <option value="<?= $s ?>"
                                <?= ($dokterData && $dokterData['spesialis'] == $s) ? 'selected' : '' ?>>
                                <?= $s ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- DOKTER -->
                <div class="mb-3">
                    <label class="form-label">Dokter</label>
                    <select id="dokter" name="dokter_id" class="form-select" required>
                        <option value="">-- Pilih Dokter --</option>

                        <?php if ($dokterData): ?>
                            <option value="<?= $dokterData['dokter_id'] ?>" selected
                                data-hari="<?= $dokterData['hari_praktek'] ?>"
                                data-jamMulai="<?= $dokterData['jam_mulai'] ?>"
                                data-jamSelesai="<?= $dokterData['jam_selesai'] ?>">
                                <?= $dokterData['nama'] ?>
                            </option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- HIDDEN -->
                <input type="hidden" name="pasien_id" value="<?= intval($pasien_id) ?>">

                <!-- PASIEN -->
                <div class="mb-3">
                    <label class="form-label">Nama Pasien</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($username) ?>" readonly>
                </div>

                <!-- PEMBAYARAN -->
                <div class="mb-3">
                    <label class="form-label">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="BPJS">BPJS</option>
                        <option value="Mandiri">Mandiri</option>
                    </select>
                </div>

                <!-- TANGGAL -->
                <div class="mb-3">
                    <label class="form-label">Tanggal Temu</label>
                    <input type="date" id="tanggal_temu" name="tanggal_temu" class="form-control" required>
                    <small id="hariNotice" class="text-danger"></small>
                </div>

                <!-- JAM -->
                <div class="mb-3">
                    <label class="form-label">Jam Temu</label>
                    <input type="text" id="jam_temu" name="jam_temu" class="form-control" readonly required
                        value="<?php if ($dokterData) echo $dokterData['jam_mulai'] . ' - ' . $dokterData['jam_selesai']; ?>">
                </div>

                <!-- KELUHAN -->
                <div class="mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" rows="3" class="form-control"></textarea>
                </div>

                <button class="btn btn-primary w-100 py-2">Simpan Jadwal</button>

            </form>
        </div>
    </div>
</section>

<script>
let dokterHariPraktek = [];

// Jika dokter dari URL sudah diketahui
<?php if ($dokterData): ?>
dokterHariPraktek = "<?= $dokterData['hari_praktek'] ?>".split(',');
<?php endif; ?>

// LOAD DOKTER SAAT SPESIALIS BERUBAH
document.getElementById('spesialis').addEventListener('change', function () {
    let spesialis = this.value;
    let dokterSelect = document.getElementById('dokter');
    dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';

    fetch('requestajax.php?spesialis=' + encodeURIComponent(spesialis))
        .then(r => r.json())
        .then(data => {
            data.forEach(d => {
                let opt = document.createElement('option');
                opt.value = d.dokter_id;
                opt.textContent = d.nama;
                opt.dataset.hari = d.hari_praktek;
                opt.dataset.jamMulai = d.jam_mulai;
                opt.dataset.jamSelesai = d.jam_selesai;
                dokterSelect.appendChild(opt);
            });
        });
});

// DOKTER DIPILIH MANUAL
document.getElementById('dokter').addEventListener('change', function () {
    let d = this.options[this.selectedIndex];
    dokterHariPraktek = d.dataset.hari?.split(',') ?? [];

    document.getElementById('jam_temu').value =
        `${d.dataset.jamMulai} - ${d.dataset.jamSelesai}`;
});

// VALIDASI HARI PRAKTEK
document.getElementById('tanggal_temu').addEventListener('change', function () {
    let tanggal = new Date(this.value);
    let hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"][tanggal.getDay()];
    let notice = document.getElementById('hariNotice');

    if (dokterHariPraktek.length && !dokterHariPraktek.includes(hari)) {
        notice.textContent = "Dokter hanya praktek hari: " + dokterHariPraktek.join(', ');
    } else {
        notice.textContent = "";
    }
});
</script>

<?php include __DIR__ . "/Halaman/footer.php"; ?>
