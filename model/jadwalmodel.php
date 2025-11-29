<?php
class JadwalTemu {
    private $conn;
    private $table = "jadwal_temu";

    public function __construct($db){
        $this->conn = $db;
    }

    // Hitung nomor antrian terbaru berdasarkan dokter & tanggal
    private function getNextNomorAntrian($dokter_id, $tanggal_temu){
        $sql = "SELECT MAX(nomor_antrian) as max_antrian FROM $this->table WHERE dokter_id = ? AND tanggal_temu = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $dokter_id, $tanggal_temu);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return ($result['max_antrian'] ?? 0) + 1;
    }

    // Simpan jadwal
    public function create($dokter_id, $pasien_id, $tanggal_temu, $jam_temu, $jenis_pembayaran, $keluhan){
        $nomor_antrian = $this->getNextNomorAntrian($dokter_id, $tanggal_temu);
        $status = "Pending";

        $sql = "INSERT INTO $this->table 
                (dokter_id, pasien_id, tanggal_temu, jam_temu, status, nomor_antrian, jenis_pembayaran,keluhan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iisssiss", 
            $dokter_id, 
            $pasien_id, 
            $tanggal_temu, 
            $jam_temu, 
            $status, 
            $nomor_antrian, 
            $jenis_pembayaran,
            $keluhan
        );

        if($stmt->execute()){
            return $nomor_antrian;
        } else {
            return false;
        }
    }
    // Ambil semua jadwal pasien
public function getByPasienId($pasien_id){
    $sql = "SELECT jt.*, d.nama
            FROM $this->table jt
            LEFT JOIN dokter d ON jt.dokter_id = d.dokter_id
            WHERE jt.pasien_id = ?
            ORDER BY jt.tanggal_temu ASC, jt.jam_temu ASC";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $pasien_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


}
?>
