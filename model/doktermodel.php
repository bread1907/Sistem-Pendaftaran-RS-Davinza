<?php

class DokterModel {

    private $conn;
    private $table = "dokter";

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ======================================
    // CEK LOGIN DOKTER (username + nip + password)
    // ======================================
    public function login($username, $nip, $password) {

        $sql = "SELECT * FROM $this->table WHERE username = ? AND nip = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $nip);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();

            // Verifikasi password hash
            if (password_verify($password, $data['password'])) {
                return $data; // login sukses, kembalikan data dokter
            }
        }

        return false; // login gagal
    }

    // ======================================
    // Ambil pasien sesuai jadwal dokter
    // ======================================
    public function getPasienByJadwal($dokter_id, $tanggal) {
        $sql = "SELECT p.*, j.tanggal_jadwal 
                FROM pasien p
                INNER JOIN jadwal j ON p.pasien_id = j.pasien_id
                WHERE j.dokter_id = ? AND j.tanggal_jadwal = ?
                ORDER BY j.tanggal_jadwal ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $dokter_id, $tanggal);
        $stmt->execute();
        return $stmt->get_result();
    }

    // ======================================
    // Ambil data pasien by ID
    // ======================================
    public function getPasienById($pasien_id) {
        $sql = "SELECT * FROM pasien WHERE pasien_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $pasien_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ======================================
    // Simpan diagnosa/resep/tindakan/saran
    // ======================================
    public function simpanDiagnosa($pasien_id, $dokter_id, $diagnosa, $resep, $tindakan, $saran) {
        $sql = "INSERT INTO rekam_medis 
                (pasien_id, dokter_id, diagnosa, resep, tindakan, saran, tanggal) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iissss", $pasien_id, $dokter_id, $diagnosa, $resep, $tindakan, $saran);
        return $stmt->execute();
    }
}
