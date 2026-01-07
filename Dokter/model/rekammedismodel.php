<?php
class RekamMedisModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ===============================
    // Ambil rekam medis berdasarkan JADWAL
    // ===============================
    public function getByJadwal($jadwal_id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM rekam_medis WHERE jadwal_id = ? LIMIT 1"
        );
        $stmt->bind_param("i", $jadwal_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res->fetch_assoc();
    }

    // ===============================
    // Insert rekam medis BARU
    // ===============================
    public function insertRekamMedis(
        $dokter_id,
        $pasien_id,
        $jadwal_id,
        $diagnosa,
        $tindakan,
        $resep_obat,
        $catatan
    ) {
        $stmt = $this->conn->prepare(
            "INSERT INTO rekam_medis 
            (dokter_id, pasien_id, jadwal_id, diagnosa, tindakan, resep_obat, catatan, waktu_input)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );

        // i i i s s s s  → TOTAL 7 PARAMETER
        $stmt->bind_param(
            "iiissss",
            $dokter_id,
            $pasien_id,
            $jadwal_id,
            $diagnosa,
            $tindakan,
            $resep_obat,
            $catatan
        );

        $exec = $stmt->execute();
        $stmt->close();
        return $exec;
    }

    // ===============================
    // Update rekam medis
    // ===============================
    public function updateRekamMedis(
        $rekam_id,
        $diagnosa,
        $tindakan,
        $resep_obat,
        $catatan
    ) {
        $stmt = $this->conn->prepare(
            "UPDATE rekam_medis 
             SET diagnosa = ?, tindakan = ?, resep_obat = ?, catatan = ?
             WHERE rekam_id = ?"
        );
        $stmt->bind_param(
            "ssssi",
            $diagnosa,
            $tindakan,
            $resep_obat,
            $catatan,
            $rekam_id
        );
        $stmt->execute();
        $stmt->close();
    }

    // ===============================
    // Riwayat rekam medis dokter
    // ===============================
    public function getRiwayatByDokter($dokter_id) {
        $stmt = $this->conn->prepare(
            "SELECT rm.*, p.username, jt.tanggal_temu
             FROM rekam_medis rm
             JOIN pasien p ON p.pasien_id = rm.pasien_id
             JOIN jadwal_temu jt ON jt.jadwal_id = rm.jadwal_id
             WHERE rm.dokter_id = ?
             ORDER BY rm.waktu_input DESC"
        );
        $stmt->bind_param("i", $dokter_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        return $res;
    }
}
