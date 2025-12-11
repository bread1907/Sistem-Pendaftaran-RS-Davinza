<?php
session_start();

require_once "koneksi.php";

// CONTROLLER
require_once "controller/DokterController.php";

$controller = new DokterController($conn);

// ROUTING
$page = $_GET['page'] ?? 'login';

// ===== ROUTE LOGIN =====
if ($page === 'login') {
    $controller->login();
}

// ===== ROUTE PROSES LOGIN =====
else if ($page === 'login_proses') {
    $controller->loginProses();
}

// ===== ROUTE HOMEPAGE DOKTER =====
else if ($page === 'home') {
    $controller->home();
}

// ===== ROUTE LOGOUT =====
else if ($page === 'logout') {
    $controller->logout();
}

// DEFAULT 404
else {
    echo "404 Not Found";
}
