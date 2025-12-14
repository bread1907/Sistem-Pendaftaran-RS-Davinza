<?php
class DokterModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function cekLogin($username, $nip, $password) {
        $sql = "SELECT * FROM dokter WHERE TRIM(username)=? AND TRIM(nip)=? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) die(mysqli_error($this->conn));

        mysqli_stmt_bind_param($stmt, "ss", $username, $nip);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $dokter = mysqli_fetch_assoc($result);

        if ($dokter && password_verify($password, $dokter['password'])) {
            return $dokter;
        }
        return false;
    }
}
