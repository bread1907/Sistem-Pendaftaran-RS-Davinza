<?php

class DokterModel {

    private $conn;
    private $table = "dokter";

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ======================================
    // CEK LOGIN DOKTER
    // ======================================
    public function login($username, $password) {

        $sql = "SELECT * FROM $this->table WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $data = $result->fetch_assoc();

            // password_hash
            if (password_verify($password, $data['password'])) {
                return $data;
            }
        }

        return false;
    }
}
