<?php
class JadwalModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Ambil daftar pasien berdasarkan dokter_id yang login
    public function getPasienByDokter($dokter_id) {
        $sql = "SELECT 
                    jt.jadwal_id,
                    jt.tanggal_temu,
                    jt.jam_temu,
                    jt.status,
                    jt.nomor_antrian,
                    jt.keluhan,
                    p.pasien_id,
                    p.username,
                    p.email,
                    p.no_hp,
                    p.nik
                FROM jadwal_temu jt
                JOIN pasien p ON p.pasien_id = jt.pasien_id
                WHERE jt.dokter_id = ?
                ORDER BY jt.tanggal_temu ASC, jt.jam_temu ASC";

        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($this->conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $dokter_id);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }
}
