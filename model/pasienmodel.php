<?php
class PasienModel {
    private $conn;
    private $table = "pasien";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cekEmail($email) {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($data) {
        $sql = "INSERT INTO $this->table (email, username, password, tanggal_lahir, jenis_kelamin, alamat, no_hp)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss",
            $data['email'], 
            $data['username'], 
            $data['password'], 
            $data['tanggal_lahir'], 
            $data['jenis_kelamin'], 
            $data['alamat'], 
            $data['no_hp']
        );

        return $stmt->execute();
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
