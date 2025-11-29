<?php
header('Content-Type: application/json');
include "koneksi.php";

$spesialis = $_GET['spesialis'] ?? '';

if($spesialis){
    $stmt = $conn->prepare("SELECT dokter_id, nama, hari_praktek, jam_mulai, jam_selesai FROM dokter WHERE spesialis = ? ORDER BY nama ASC");
    $stmt->bind_param("s", $spesialis);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}
