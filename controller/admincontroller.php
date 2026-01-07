<?php
class AdminController
{

    private $model;
    private $dokterModel;
    private $pasienModel;
    private $jadwalModel;
    private $rekamModel;

    public function __construct(){
        include_once "../model/AdminModel.php";
        include_once "../model/DokterModel.php";
        include_once "../model/pasienmodel.php";
        include_once "../Dokter/model/jadwalmodel.php";
        include_once "../Dokter/model/rekammedismodel.php";
        
        global $conn;
        $this->model = new AdminModel($conn);
        $this->dokterModel = new DokterModel($conn);
        $this->pasienModel = new PasienModel($conn);
        $this->jadwalModel = new JadwalModel($conn);
        $this->rekamModel  = new RekamMedisModel($conn);
    }

    // halaman login admin
    public function LoginPage()
    {
        if (isset($_SESSION['admin_username'])) {
            header("Location: ../Admin/index.php?action=dashboard");
            exit;
        }

        include "../Admin/AdminLogin.php";
    }

    public function Login() {
        //session_start();

        if (isset($_POST['login'])) {
            $username = $_POST['admin_name'];
            $password = $_POST['admin_pass'];

            $admin = $this->model->login($username);

            if ($admin && password_verify($password, $admin['password'])) {

                session_regenerate_id(true); // AMAN

                $_SESSION['admin_login']    = true;
                $_SESSION['admin_id']       = $admin['admin_id'];
                $_SESSION['admin_username'] = $admin['username'];


                header("Location: ../Admin/index.php?action=dashboard");
                exit;
            } else {
                $_SESSION['login_error'] = "Gagal! Username atau password salah!";
                header("Location: ../Admin/index.php?action=admin_login");
                exit;
            }
        }
        include "../Admin/AdminLogin.php";
    }

    public function Dashboard(){
        // Fetch dashboard statistics
        $totalPatients = $this->model->getTotalPatients();
        $totalDoctors = $this->model->getTotalDoctors();
        $appointmentsToday = $this->model->getAppointmentsToday();
        $completedToday = $this->model->getCompletedAppointmentsToday();
        $roomOccupancy = $this->model->getRoomOccupancy();
        //$departmentStats = $this->model->getDepartmentStats();

        // Pass data to view
        $data = [
            'totalPatients' => $totalPatients,
            'totalDoctors' => $totalDoctors,
            'appointmentsToday' => $appointmentsToday,
            'completedToday' => $completedToday,
            'roomOccupancy' => $roomOccupancy,
            //'departmentStats' => $departmentStats
        ];

        extract($data);
        include "../Admin/Dashboard.php";
    }

    public function LihatDokter() {
        // data statistik
        $totalDoctors         = $this->model->getTotalDoctors();
        $totalSpecializations = $this->model->getTotalSpecializations();
        $averagePatientsPerDay = $this->model->getAveragePatientsPerDay();

        $spesialis = $_GET['spesialis'] ?? '';
        $hari      = $_GET['hari']      ?? '';

        // pakai 1 sumber data saja
        $dokterList    = $this->dokterModel->getFiltered($spesialis, $hari);
        $listSpesialis = $this->dokterModel->getSpesialis();

        include "../Admin/Dokter.php";
    }


    // AJAX — detail dokter (eye & pencil)
    public function getDokter() {
        header('Content-Type: application/json');
        echo json_encode(
            $this->dokterModel->getById($_GET['id'])
        );
    }

    public function updateDokter() {
        $data = $_POST;

        // handle upload foto (boleh kosong artinya tidak ganti foto)
        $fotoFileName = $this->handleUploadFotoUpdate($data['dokter_id'] ?? null);

        if ($fotoFileName !== null) {
            $data['foto'] = $fotoFileName;
        } else {
            // kalau tidak upload baru, ambil foto lama dari DB supaya tidak di-null-kan
            $dokterLama = $this->dokterModel->getById($data['dokter_id']);
            $data['foto'] = $dokterLama['foto'] ?? null;
        }

        $this->dokterModel->updateById($data);

        header("Location: ../Admin/index.php?action=lihat_dokter");
        exit;
    }

    // khusus update foto
    private function handleUploadFotoUpdate($dokterId) {
        if (empty($_FILES['foto']['name'])) {
            return null; // tidak ada file baru
        }

        $fileTmp  = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExt  = ['png', 'jpg', 'jpeg'];
        $allowedMime = ['image/png', 'image/jpeg'];

        $mime = mime_content_type($fileTmp);

        if (!in_array($ext, $allowedExt) || !in_array($mime, $allowedMime) || getimagesize($fileTmp) === false) {
            echo "<script>
                    alert('Tipe file foto tidak valid. Hanya PNG, JPG, JPEG.');
                    window.history.back();
                </script>";
            exit;
        }

        // nama file bisa pakai dokter_id biar konsisten
        $newName   = ($dokterId ? 'dokter_' . $dokterId : uniqid('dokter_')) . '.' . $ext;
        $targetDir = '../Pictures/Dokter/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (!move_uploaded_file($fileTmp, $targetDir . $newName)) {
            echo "<script>
                    alert('Gagal menyimpan file di server.');
                    window.history.back();
                </script>";
            exit;
        }

        return $newName;
    }

    public function deleteDokter() {
        $this->dokterModel->deleteById($_GET['id']);
        header("Location: ../Admin/index.php?action=lihat_dokter");
        exit;
    }

    public function StatusDokter() {
        header('Content-Type: application/json');
        echo json_encode($this->dokterModel->getAllWithStatus());
    }

    public function TambahDokter() {
        // validasi sederhana
        if (empty($_POST['nama']) || empty($_POST['spesialis']) ||
            empty($_POST['username']) || empty($_POST['password'])) {
            echo "<script>
                    alert('Nama, Spesialis, Username, dan Password wajib diisi');
                    window.history.back();
                </script>";
            exit;
        }

        $hariArray = $_POST['hari_praktek'] ?? [];
        if (empty($hariArray)) {
            echo "<script>
                    alert('Minimal pilih satu hari praktek');
                    window.history.back();
                </script>";
            exit;
        }

        // Join ke string untuk disimpan di kolom hari_praktek
        $hariPraktek = implode(', ', $hariArray);  // contoh: "Senin, Rabu, Kamis"


        // handle upload foto
        $fotoFileName = null;
        if (!empty($_FILES['foto']['name'])) {
            $fileTmp  = $_FILES['foto']['tmp_name'];
            $fileName = $_FILES['foto']['name'];
            $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedExt  = ['png', 'jpg', 'jpeg'];
            $allowedMime = ['image/png', 'image/jpeg'];

            $mime = mime_content_type($fileTmp);

            if (!in_array($ext, $allowedExt) || !in_array($mime, $allowedMime) || getimagesize($fileTmp) === false) {
                echo "<script>
                        alert('Tipe file foto tidak valid. Hanya PNG, JPG, JPEG.');
                        window.history.back();
                    </script>";
                exit;
            }

            $newName   = 'dokter_' . time() . '.' . $ext;
            $targetDir = '../Pictures/Dokter/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            if (!move_uploaded_file($fileTmp, $targetDir . $newName)) {
                echo "<script>
                        alert('Gagal menyimpan file foto.');
                        window.history.back();
                    </script>";
                exit;
            }

            $fotoFileName = $newName;
        }

        $data = [
            'nama'         => $_POST['nama'],
            'spesialis'    => $_POST['spesialis'],
            'hari_praktek' => $hariPraktek,
            'jam_mulai'    => $_POST['jam_mulai'],
            'jam_selesai'  => $_POST['jam_selesai'],
            'username'     => $_POST['username'],
            'password'     => $_POST['password'],
            'foto'         => $fotoFileName,
        ];

        $this->dokterModel->insert($data);

        $_SESSION['success'] = 'Data dokter berhasil ditambahkan';
        // kalau mau error juga bisa pakai $_SESSION['error']

        header("Location: index.php?action=lihat_dokter");
        exit;
    }


    public function Dokter(){
        // Fetch doctor statistics
        $totalDoctors = $this->model->getTotalDoctors();
        $totalSpecializations = $this->model->getTotalSpecializations();
        $averagePatientsPerDay = $this->model->getAveragePatientsPerDay();

        // Fetch all doctors
        include_once "../model/DokterModel.php";
        global $conn;
        $dokterModel = new DokterModel($conn);
        $doctors = $dokterModel->getAllDokterWithStatus();

        // Pass data to view
        $data = [
            'totalDoctors' => $totalDoctors,
            'totalSpecializations' => $totalSpecializations,
            'averagePatientsPerDay' => $averagePatientsPerDay,
            'doctors' => $doctors
        ];

        extract($data);
        include "../Admin/Dokter.php";
    }

    public function Pengaturan(){
        include "../Admin/Pengaturan.php";
    }

    public function Logout(){
        session_start();
        session_destroy();
        header("Location: index.php");
    }

    public function LihatPasien() {
        $pasienList = $this->pasienModel->getPasienWithSummary();
        include "../Admin/Pasien.php";
    }


}
