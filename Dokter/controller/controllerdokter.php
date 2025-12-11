<?php
session_start();

class DokterController {

    private $model;

    public function __construct($conn) {
        require_once __DIR__ . "/../model/modeldokter.php";
        $this->model = new DokterModel($conn);
    }

    public function LoginDokter(){
        include "Halaman/logindokter.php";
    }

}
