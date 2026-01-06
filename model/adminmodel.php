<?php
class AdminModel
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return false;
    }

    // Get total patients
    public function getTotalPatients()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM pasien");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    // Get total active doctors
    public function getTotalDoctors()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM dokter");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    // Get appointments today
    public function getAppointmentsToday()
    {
        $today = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM jadwal_temu WHERE tanggal_temu = ?");
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    // Get completed appointments today
    public function getCompletedAppointmentsToday()
    {
        $today = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM jadwal_temu WHERE tanggal_temu = ? AND status = 'Completed'");
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    




    // Calculate room occupancy (assuming 67 total rooms, occupied based on today's appointments)
    public function getRoomOccupancy()
    {
        $totalRooms = 67;
        $occupied = $this->getAppointmentsToday();
        $percentage = round(($occupied / $totalRooms) * 100);
        return [
            'percentage' => $percentage,
            'occupied' => $occupied,
            'total' => $totalRooms
        ];
    }

    // Get department popularity based on appointment counts for specific departments
    // public function getDepartmentStats() {
    //     $departments = ['Umum', 'Anak', 'Jantung'];
    //     $stats = [];
    //     $totalAppointments = 0;

    //     // First, get total appointments for percentage calculation
    //     $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM jadwal_temu");
    //     $stmt->execute();
    //     $totalResult = $stmt->get_result()->fetch_assoc();
    //     $totalAppointments = $totalResult['total'];

    //     foreach ($departments as $dept) {
    //         $stmt = $this->conn->prepare("
    //             SELECT COUNT(jt.jadwal_id) as count
    //             FROM dokter d
    //             LEFT JOIN jadwal_temu jt ON d.dokter_id = jt.dokter_id
    //             WHERE d.spesialis = ?
    //         ");
    //         $stmt->bind_param("s", $dept);
    //         $stmt->execute();
    //         $result = $stmt->get_result()->fetch_assoc();
    //         $count = $result['count'];
    //         $percentage = $totalAppointments > 0 ? round(($count / $totalAppointments) * 100) : 0;
    //         $stats[] = [
    //             'name' => $dept,
    //             'percentage' => $percentage
    //         ];
    //     }
    //     return $stats;
    // }

    // Get total specializations
    public function getTotalSpecializations(){
        $stmt = $this->conn->prepare("SELECT COUNT(DISTINCT spesialis) as total FROM dokter");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    // Get average patients per day per doctor
    public function getAveragePatientsPerDay(){
        $stmt = $this->conn->prepare("
            SELECT COUNT(jt.jadwal_id) / COUNT(DISTINCT DATE(jt.tanggal_temu)) / COUNT(DISTINCT jt.dokter_id) as avg
            FROM jadwal_temu jt
            WHERE jt.tanggal_temu >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return round($result['avg'] ?? 0);
    }

    public function insertDokter($data){
        $sql = "INSERT INTO dokter 
            (nama, spesialis, hari_praktek, jam_mulai, jam_selesai, no_str, username, nip, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['nama'],
            $data['spesialis'],
            $data['hari_praktek'],
            $data['jam_mulai'],
            $data['jam_selesai'],
            $data['no_str'],
            $data['username'],
            $data['nip'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }


}

?>