<?php
class DokterModel {

    private $conn;
    private $table = "dokter";

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function cekLogin($username, $nip, $password) {
        $sql = "SELECT * FROM $this->table WHERE username = :username AND nip = :nip LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nip', $nip);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $dokter = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $dokter['password'])) {
                return $dokter;
            }
        }
        return false;
    }
}
?>
