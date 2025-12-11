<?php
include "controller/doktercontroller.php";
include "koneksi.php";

$doktercontroller = new DokterController();

switch ($action) {
    case 'HomepageDokter':
        require_once "Controller/doktercontroller.php";
        $controller = new DokterController();
        $controller->HomepageDokter();
        break;

}

?>