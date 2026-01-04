<?php
session_start();
require_once __DIR__ . '../koneksi.php';
require_once __DIR__ . '../library/fpdf/fpdf.php';

if (!isset($_SESSION['pasien_id']) || !isset($_GET['jadwal_id'])) {
    die("Akses ditolak");
}

$jadwal_id = (int) $_GET['jadwal_id'];
$pasien_id = (int) $_SESSION['pasien_id'];

/* ======================
   QUERY DATA
====================== */
$sql = "
SELECT 
    p.username AS nama_pasien,
    p.tanggal_lahir,
    p.alamat,
    d.nama AS nama_dokter,
    d.spesialis,
    d.no_str,
    rm.diagnosa,
    rm.tindakan,
    rm.resep_obat,
    rm.catatan,
    rm.waktu_input,
    jt.keluhan
FROM jadwal_temu jt
JOIN pasien p ON jt.pasien_id = p.pasien_id
JOIN rekam_medis rm ON rm.pasien_id = jt.pasien_id
JOIN dokter d ON rm.dokter_id = d.dokter_id
WHERE jt.jadwal_id = ? AND jt.pasien_id = ?
LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $jadwal_id, $pasien_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan");
}

/* ======================
   PDF
====================== */
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

/* ===== KOP RS ===== */
$pdf->Image(__DIR__.'../Pictures/davinza_logo_2.png',15,10,25);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,7,'RS DAVINZA',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'Jl. Kesehatan No. 1 Telp. (021) 123456',0,1,'C');
$pdf->Cell(0,6,'Email : info@rsdavinza.co.id',0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,1,str_repeat('_',95),0,1,'C');
$pdf->Ln(8);

/* ===== JUDUL ===== */
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,8,'SURAT KETERANGAN DIAGNOSA',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'Nomor : '.date('Y').'/SKD/RS-DAVINZA',0,1,'C');
$pdf->Ln(8);

/* ===== DOKTER ===== */
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,7,'Yang bertanda tangan di bawah ini :',0,1);
$pdf->Ln(3);

$pdf->Cell(40,7,'Nama',0,0);
$pdf->Cell(0,7,': '.$data['nama_dokter'],0,1);
$pdf->Cell(40,7,'Spesialis',0,0);
$pdf->Cell(0,7,': '.$data['spesialis'],0,1);
$pdf->Cell(40,7,'SIP / STR',0,0);
$pdf->Cell(0,7,': '.$data['no_str'],0,1);

$pdf->Ln(6);
$pdf->Cell(0,7,'Dengan ini menerangkan bahwa :',0,1);
$pdf->Ln(3);

/* ===== PASIEN ===== */
$pdf->Cell(40,7,'Nama',0,0);
$pdf->Cell(0,7,': '.$data['nama_pasien'],0,1);
$pdf->Cell(40,7,'Tanggal Lahir',0,0);
$pdf->Cell(0,7,': '.$data['tanggal_lahir'],0,1);
$pdf->Cell(40,7,'Alamat',0,0);
$pdf->MultiCell(0,7,': '.$data['alamat']);

$pdf->Ln(6);

/* ===== PARAGRAF UTAMA ===== */
$pdf->MultiCell(0,7,
    "Pada tanggal ".date('d F Y', strtotime($data['waktu_input'])).
    " telah dilakukan pemeriksaan kesehatan terhadap pasien yang bersangkutan. "
    ."Berdasarkan hasil pemeriksaan tersebut, pasien dinyatakan dalam kondisi sakit "
    ."dan memerlukan penanganan medis lebih lanjut."
);

$pdf->Ln(5);

/* ===== DETAIL MEDIS ===== */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,'HASIL PEMERIKSAAN MEDIS',0,1);
$pdf->Ln(2);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,7,'Diagnosa',0,0);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,7,': '.$data['diagnosa']);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,7,'Keluhan',0,0);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,7,': '.$data['keluhan']);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,7,'Tindakan',0,0);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,7,': '.$data['tindakan']);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,7,'Resep Obat',0,0);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,7,': '.$data['resep_obat']);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,7,'Catatan Dokter',0,0);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,7,': '.$data['catatan']);

$pdf->Ln(10);

/* ===== PENUTUP ===== */
$pdf->MultiCell(0,7,
    "Demikian surat keterangan diagnosa ini dibuat dengan sebenar-benarnya "
    ."untuk dapat dipergunakan sebagaimana mestinya."
);

$pdf->Ln(15);

/* ===== TTD ===== */
$pdf->Cell(0,7,'Pekanbaru, '.date('d F Y'),0,1,'R');
$pdf->Ln(2);

$pdf->Image(__DIR__.'../Pictures/ttd.jpg',140,$pdf->GetY(),40);
$pdf->Ln(25);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,$data['nama_dokter'],0,1,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'SIP / STR : '.$data['no_str'],0,1,'R');

/* ===== OUTPUT ===== */
$filename = "Surat_Diagnosa_".$data['nama_pasien'].".pdf";
$pdf->Output('D',$filename);
exit;
