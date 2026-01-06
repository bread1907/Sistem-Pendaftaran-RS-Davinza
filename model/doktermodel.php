<?php

class DokterModel
{

    private $conn;

    public function __construct($db)
    {

        if (!$db) {
            die("❌ Database connection is null (DB tidak terkoneksi)");
        }

        $this->conn = $db;
    }

    // Ambil semua dokter
    public function getAll()
    {
        $sql = "SELECT * FROM dokter ORDER BY nama ASC";
        return mysqli_query($this->conn, $sql);
    }

    public function getAllWithStatus()
    {
        date_default_timezone_set('Asia/Jakarta');

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $hariSekarang = $hariMap[date('l')];
        $jamSekarang = date('H:i');

        $sql = "SELECT
                dokter_id,
                nama,
                spesialis,
                hari_praktek,
                jam_mulai,
                jam_selesai,
                no_str,
                username,
                nip,
                foto
            FROM dokter";
        $result = mysqli_query($this->conn, $sql);

        $data = [];

        while ($d = mysqli_fetch_assoc($result)) {
            $d['status_praktek'] = 'Tidak Praktek';

            if (
                !empty($d['hari_praktek']) &&
                !empty($d['jam_mulai']) &&
                !empty($d['jam_selesai'])
            ) {

                $hariDokter = array_map('trim', explode(',', $d['hari_praktek']));
                $isHari = in_array($hariSekarang, $hariDokter);
                $isJam = ($jamSekarang >= $d['jam_mulai'] && $jamSekarang <= $d['jam_selesai']);

                if ($isHari && $isJam) {
                    $d['status_praktek'] = 'Praktek';
                }
            }

            $data[] = $d;
        }

        return $data;
    }


    public function getById($dokter_id)
    {
        $sql = "SELECT * FROM dokter WHERE dokter_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $dokter_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result) ?: null;
    }

    // UPDATE DOKTER (tanpa ganti password dulu, biar simple)
    public function updateById(array $data) {
        $sql = "UPDATE dokter SET
                    nama         = ?,
                    spesialis    = ?,
                    hari_praktek = ?,
                    jam_mulai    = ?,
                    jam_selesai  = ?,
                    no_str       = ?,
                    username     = ?,
                    nip          = ?,
                    foto         = ?
                WHERE dokter_id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            die('Prepare failed: ' . mysqli_error($this->conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            'ssssssssss',                 // 10 's' untuk 10 parameter
            $data['nama'],
            $data['spesialis'],
            $data['hari_praktek'],
            $data['jam_mulai'],
            $data['jam_selesai'],
            $data['no_str'],
            $data['username'],
            $data['nip'],
            $data['foto'],
            $data['dokter_id']           // PARAMETER KE‑10
        );

        return mysqli_stmt_execute($stmt);
    }


    // Hapus dokter
    public function deleteById($dokter_id)
    {
        $sql = "DELETE FROM dokter WHERE dokter_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $dokter_id);
        return mysqli_stmt_execute($stmt);
    }

    public function insert(array $data) {
        // 1. Generate no_str & nip otomatis (STR00x)
        $sqlMax = "SELECT MAX(no_str) AS max_str FROM dokter WHERE no_str LIKE 'STR%'";
        $resMax = mysqli_query($this->conn, $sqlMax);
        $rowMax = mysqli_fetch_assoc($resMax);
        $lastStr = $rowMax['max_str'] ?? null;

        $nextNumber = 1;
        if ($lastStr) {
            // ambil angka setelah STR, misal STR020 -> 20
            $numPart = (int)substr($lastStr, 3);
            $nextNumber = $numPart + 1;
        }

        // STR00x (padding 2 digit, bisa kamu ubah ke 3 digit kalau mau STR001)
        $generatedStr = 'STR' . sprintf('%03d', $nextNumber);

        $no_str = $generatedStr;
        $nip    = $generatedStr;

        // 2. Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // 3. Siapkan query
        $sql = "INSERT INTO dokter
            (nama, spesialis, hari_praktek, jam_mulai, jam_selesai,
            no_str, username, nip, foto, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssssss',
            $data['nama'],
            $data['spesialis'],
            $data['hari_praktek'],
            $data['jam_mulai'],
            $data['jam_selesai'],
            $no_str,
            $data['username'],
            $nip,
            $data['foto'],      // nama file dari upload
            $hashedPassword
        );

        return mysqli_stmt_execute($stmt);
    }

    public function getSpesialis() {
        $data = [];
        $sql = "SELECT DISTINCT spesialis FROM dokter ORDER BY spesialis ASC";
        $res = mysqli_query($this->conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row['spesialis'];
        }
        return $data;
    }

    public function getFiltered($spesialis, $hari){
        $where = [];
        $params = [];
        $types = '';

        if ($spesialis !== '') {
            $where[] = "spesialis = ?";
            $params[] = $spesialis;
            $types .= 's';
        }

        if ($hari !== '') {
            // kolom hari_praktek: "Senin, Rabu, Kamis"
            $where[] = "hari_praktek LIKE ?";
            $params[] = '%' . $hari . '%';
            $types .= 's';
        }

        $sql = "SELECT * FROM dokter";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY nama ASC";

        $stmt = mysqli_prepare($this->conn, $sql);
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Ambil dokter berdasarkan spesialis
    public function getBySpesialis($spesialis)
    {
        $spesialis = mysqli_real_escape_string($this->conn, $spesialis);
        $sql = "SELECT * FROM dokter WHERE spesialis = '$spesialis' ORDER BY nama ASC";
        return mysqli_query($this->conn, $sql);
    }

}

?>