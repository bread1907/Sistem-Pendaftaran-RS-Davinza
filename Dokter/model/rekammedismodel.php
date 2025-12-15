<?php
class RekamMedisModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertRekamMedis(
        $dokter_id,
        $pasien_id,
        $diagnosa,
        $tindakan,
        $resep_obat,
        $catatan
    ) {
        $sql = "INSERT INTO rekam_medis
                (dokter_id, pasien_id, diagnosa, tindakan, resep_obat, catatan, waktu_input)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "iissss",
            $dokter_id,
            $pasien_id,
            $diagnosa,
            $tindakan,
            $resep_obat,
            $catatan
        );

        return mysqli_stmt_execute($stmt);
    }
}
