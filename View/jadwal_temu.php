<?php include __DIR__ . "../Halaman/header.php"; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <h3 class="mb-4 fw-bold">Form Jadwal Temu</h3>

            <form action="simpan_jadwal.php" method="POST" class="shadow p-4 rounded-4 bg-white">

                <!-- DOKTER ID -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Dokter ID</label>
                    <input type="number" name="dokter_id" class="form-control" placeholder="Masukkan ID Dokter" required>
                </div>

                <!-- PASIEN ID -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pasien ID</label>
                    <input type="number" name="pasien_id" class="form-control" placeholder="Masukkan ID Pasien" required>
                </div>

                <!-- TANGGAL TEMU -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Temu</label>
                    <input type="date" name="tanggal_temu" class="form-control" required>
                </div>

                <!-- JAM TEMU -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jam Temu</label>
                    <input type="text" name="jam_temu" class="form-control" placeholder="08:00 / 13:30 / 16:00" required>
                </div>

                <!-- STATUS -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Dikonfirmasi">Dikonfirmasi</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <!-- SUBMIT -->
                <button type="submit" class="btn btn-primary w-100 py-2 mt-3">Simpan Jadwal</button>

            </form>

        </div>
    </div>
</div>

<?php include __DIR__ . "../Halaman/footer.php"; ?>