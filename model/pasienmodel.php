<?php
class PasienModel {
    private $conn;
    private $table = "pasien";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Cek email apakah sudah terdaftar
    public function cekEmail($email) {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Insert data pasien baru
    public function insert($data) {
        $sql = "INSERT INTO $this->table (email, username, password, tanggal_lahir, jenis_kelamin, alamat, no_hp, nik)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssss",
            $data['email'], 
            $data['username'], 
            $data['password'], 
            $data['tanggal_lahir'], 
            $data['jenis_kelamin'], 
            $data['alamat'], 
            $data['no_hp'],
            $data['nik']
        );

        return $stmt->execute();
    }

    // Ambil data pasien berdasarkan email
    public function getByEmail($email) {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Ambil data pasien berdasarkan ID
    public function getById($id) {
        $sql = "SELECT * FROM $this->table WHERE pasien_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update data pasien
    public function update($id, $data) {
        $sql = "UPDATE $this->table SET email=?, username=?, tanggal_lahir=?, jenis_kelamin=?, alamat=?, no_hp=? nik=? WHERE pasien_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssi",
            $data['email'],
            $data['username'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['alamat'],
            $data['no_hp'],
            $data['nik'],
            $id
        );
        return $stmt->execute();
    }

    // Hapus pasien
    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE pasien_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
