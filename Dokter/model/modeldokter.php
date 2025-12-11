<?php

class DokterModel {

    private $conn;
    private $table = "dokter";

    public function __construct($conn) {
        $this->conn = $conn;
    }

}


