<?php
class RekamMedisModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Mengambil riwayat rekam medis yang dicatat oleh dokter tertentu.
     * Hasilnya menyertakan username pasien yang terkait.
     *
     * @param int $dokter_id ID Dokter
     * @return mysqli_result Hasil query dari database
     */
    public function getRiwayatByDokter($dokter_id) {

        $sql = "SELECT rm.*, p.username
                FROM rekam_medis rm
                JOIN pasien p ON p.pasien_id = rm.pasien_id
                WHERE rm.dokter_id = ?
                ORDER BY rm.waktu_input DESC";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $dokter_id);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    /**
     * Menyimpan data rekam medis baru ke database.
     *
     * @param int $dokter_id ID Dokter yang mencatat
     * @param int $pasien_id ID Pasien yang diperiksa
     * @param string $diagnosa Diagnosa yang diberikan
     * @param string $tindakan Tindakan yang dilakukan
     * @param string $resep_obat Resep obat yang diberikan
     * @param string $catatan Catatan tambahan
     * @return bool True jika berhasil, False jika gagal
     */
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
            "iissss", // i: integer (dokter_id, pasien_id), s: string (diagnosa, tindakan, resep_obat, catatan)
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