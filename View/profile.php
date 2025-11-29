<?php include __DIR__ . "/Halaman/header.php"; ?>

<div class="container my-5">
    <h2 class="mb-4 text-primary fw-bold">Profil Saya</h2>

    <?php
    if(!isset($_SESSION['user_id'])){
        echo "<div class='alert alert-warning'>Silakan login terlebih dahulu.</div>";
    } else {
        require_once __DIR__ . '/../Model/PasienModel.php';
        require_once __DIR__ . '/../Model/JadwalModel.php';
        global $conn;

        $pasienModel = new PasienModel($conn);
        $jadwalModel = new JadwalTemu($conn);

        $user = $pasienModel->getById($_SESSION['user_id']);
        $janjiTemu = $jadwalModel->getByPasienId($_SESSION['user_id']);
    ?>

    <!-- Profil Card -->
    <div class="card mb-5 shadow-lg border-0 rounded-4" style="background: linear-gradient(135deg, #6CC1FF, #3A8DFF); color:white;">
        <div class="card-body p-5">
            <div class="d-flex align-items-center gap-4">
                <div class="rounded-circle bg-white text-primary d-flex justify-content-center align-items-center" style="width:80px; height:80px; font-size:36px;">
                    <?= strtoupper($user['username'][0]); ?>
                </div>
                <div>
                    <h3 class="fw-bold mb-1"><?= htmlspecialchars($user['username']); ?></h3>
                    <p class="mb-0"><i class="fa fa-envelope me-2"></i><?= htmlspecialchars($user['email']); ?></p>
                    <p class="mb-0"><i class="fa fa-phone me-2"></i><?= htmlspecialchars($user['no_hp']); ?></p>
                </div>
            </div>
            <hr class="my-4 border-light">
            <div class="row">
                <div class="col-md-6"><p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($user['tanggal_lahir']); ?></p></div>
                <div class="col-md-6"><p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($user['jenis_kelamin']); ?></p></div>
                <div class="col-12"><p><strong>Alamat:</strong> <?= htmlspecialchars($user['alamat']); ?></p></div>
            </div>
        </div>
    </div>

    <!-- Jadwal Temu -->
    <h3 class="mb-3 text-primary fw-bold">Daftar Janji Temu</h3>
    <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
        <table class="table table-hover align-middle mb-0" style="background:white;">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Dokter</th>
                    <th>Status</th>
                    <th>Antrian</th>
                    <th>Hasil Diagnosa</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                $no = 1;
                foreach($janjiTemu as $jt){
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>" . htmlspecialchars($jt['tanggal_temu']) . "</td>";
                    echo "<td>" . htmlspecialchars($jt['jam_temu']) . "</td>";
                    echo "<td>" . htmlspecialchars($jt['nama'] ?? 'Belum Ditentukan') . "</td>";
                    echo "<td>";
                    $status = strtolower($jt['status']);
                    $badgeClass = match($status){
                        'selesai' => 'success',
                        'pending' => 'warning',
                        'dibatalkan' => 'danger',
                        default => 'secondary'
                    };
                    echo "<span class='badge bg-{$badgeClass}'>" . ucfirst($jt['status']) . "</span>";
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($jt['nomor_antrian']) . "</td>";

                    if($status === 'selesai'){
                        $filePath = $jt['file_hasil_diagnosa'] ?? '#';
                        $btn = "<a href='" . htmlspecialchars($filePath) . "' class='btn btn-sm btn-success fw-bold'>
                                    <i class='fa fa-file-medical me-1'></i>Lihat/Download
                                </a>";
                        echo "<td>{$btn}</td>";
                    } else {
                        echo "<td>-</td>";
                    }

                    echo "</tr>";
                    $no++;
                }

                if(empty($janjiTemu)){
                    echo "<tr><td colspan='7' class='text-center'>Belum ada janji temu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php } ?>
</div>

<?php include __DIR__ . "/Halaman/footer.php"; ?>
