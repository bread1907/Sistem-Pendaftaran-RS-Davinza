<?php
class DokterModel {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getAll() {
        return mysqli_query($this->conn, "SELECT * FROM dokter");
    }

    public function insert($data) {
        extract($data);

        $query = "INSERT INTO dokter(nama_dokter, spesialis, no_hp)
                  VALUES('$nama_dokter', '$spesialis', '$no_hp')";
        return mysqli_query($this->conn, $query);
    }

    public function delete($id) {
        return mysqli_query($this->conn, "DELETE FROM dokter WHERE dokter_id='$id'");
    }
}
