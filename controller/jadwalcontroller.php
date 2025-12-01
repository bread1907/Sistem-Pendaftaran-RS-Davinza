<?php
include_once __DIR__ . "/../model/jadwalmodel.php";

class JadwalController {
    private $jadwalModel;

    public function __construct($db){
        $this->jadwalModel = new JadwalTemu($db);
    }

    // Simpan jadwal dari form
    public function save(){
        if(!isset($_SESSION['pasien_id'])){
            echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href='index.php';</script>";
            exit;
        }

        $dokter_id = $_POST['dokter_id'];
        $pasien_id = $_SESSION['pasien_id'];
        $tanggal_temu = $_POST['tanggal_temu'];
        $jam_temu = $_POST['jam_temu'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $keluhan = $_POST['keluhan'] ?? '';

        $nomor_antrian = $this->jadwalModel->create(
            $dokter_id,
            $pasien_id,
            $tanggal_temu,
            $jam_temu,
            $jenis_pembayaran,
            $keluhan
        );

        if($nomor_antrian){
            echo "<script>
                    alert('Jadwal berhasil disimpan! Nomor antrian Anda: $nomor_antrian');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menyimpan jadwal!');
                    window.history.back();
                  </script>";
        }
    }
}
?>
