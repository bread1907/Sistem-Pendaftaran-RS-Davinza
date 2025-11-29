<?php
class DokterController {

    private $model;

    public function __construct() {
        include_once "Model/DokterModel.php";
        global $conn;
        $this->model = new DokterModel($conn);
    }

    public function Index() {
        $dokter = $this->model->getAll();
        include "Views/dokter/index.php";
    }

    public function Add() {
        include "Views/dokter/add.php";
    }

    public function Store() {
        $this->model->insert($_POST);
        header("Location: index.php?action=dokter_list");
    }

    public function Delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: index.php?action=dokter_list");
    }

}
