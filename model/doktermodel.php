<?php

class DokterModel {

    private $conn;

    public function __construct($db) {

        if (!$db) {
            die("❌ Database connection is null (DB tidak terkoneksi)");
        }

        $this->conn = $db;
    }

    // Ambil semua dokter
    public function getAll() {
        $sql = "SELECT * FROM dokter ORDER BY nama ASC";
        return mysqli_query($this->conn, $sql);
    }

    // Tambah dokter
    public function insert($data) {
        $nama = mysqli_real_escape_string($this->conn, $data['nama_dokter']);
        $spesialis = mysqli_real_escape_string($this->conn, $data['spesialis']);
        $no_hp = mysqli_real_escape_string($this->conn, $data['no_hp']);
        $hari_praktek = mysqli_real_escape_string($this->conn, $data['hari_praktek'] ?? '');

        $query = "INSERT INTO dokter (nama_dokter, spesialis, no_hp, hari_praktek)
                  VALUES ('$nama', '$spesialis', '$no_hp', '$hari_praktek')";

        return mysqli_query($this->conn, $query);
    }

    // Hapus dokter
    public function delete($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $query = "DELETE FROM dokter WHERE dokter_id = '$id'";
        return mysqli_query($this->conn, $query);
    }
    public function getSpesialis() {
        $sql = "SELECT DISTINCT spesialis FROM dokter ORDER BY spesialis ASC";
        return mysqli_query($this->conn, $sql);
    }
    // Ambil dokter berdasarkan spesialis
    public function getBySpesialis($spesialis) {
        $spesialis = mysqli_real_escape_string($this->conn, $spesialis);
        $sql = "SELECT * FROM dokter WHERE spesialis = '$spesialis' ORDER BY nama ASC";
        return mysqli_query($this->conn, $sql);
    }

}

?>