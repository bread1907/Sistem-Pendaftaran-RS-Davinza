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
    public function updateById($data)
    {
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
        mysqli_stmt_bind_param(
            $stmt,
            'sssssssss', // 9 string dulu
            $data['nama'],
            $data['spesialis'],
            $data['hari_praktek'],
            $data['jam_mulai'],
            $data['jam_selesai'],
            $data['no_str'],
            $data['username'],
            $data['nip'],
            $data['foto'],
            // dokter_id dipisah di bawah
        );
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
        // 1. Generate dokter_id kalau kosong
        if (empty($data['dokter_id'])) {
            $data['dokter_id'] = 'DOK' . strtoupper(substr(md5(uniqid()), 0, 6));
        }

        // 2. Generate no_str dan nip otomatis pola STR00x
        // ambil max no_str yang ada
        $sqlMax = "SELECT MAX(no_str) AS max_str FROM dokter WHERE no_str LIKE 'STR00%'";
        $resMax = mysqli_query($this->conn, $sqlMax);
        $rowMax = mysqli_fetch_assoc($resMax);
        $lastStr = $rowMax['max_str'] ?? null;

        $nextNumber = 1;
        if ($lastStr) {
            // ambil angka di belakang STR00, misal STR005 -> 5
            $numPart = (int)substr($lastStr, 5);
            $nextNumber = $numPart + 1;
        }

        // format STR00x (kalau mau 2 digit, tinggal ubah sprintf)
        $generatedStr = 'STR00' . $nextNumber;

        // pakai untuk no_str & nip kalau tidak diisi manual
        if (empty($data['no_str'])) {
            $data['no_str'] = $generatedStr;
        }
        if (empty($data['nip'])) {
            $data['nip'] = $generatedStr;
        }

        // 3. Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // 4. Insert
        $sql = "INSERT INTO dokter
            (dokter_id, nama, spesialis, hari_praktek, jam_mulai, jam_selesai,
            no_str, username, nip, foto, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'sssssssssss',
            $data['dokter_id'],
            $data['nama'],
            $data['spesialis'],
            $data['hari_praktek'],
            $data['jam_mulai'],
            $data['jam_selesai'],
            $data['no_str'],
            $data['username'],
            $data['nip'],
            $data['foto'],
            $hashedPassword
        );

        return mysqli_stmt_execute($stmt);
    }


    public function getSpesialis()
    {
        $sql = "SELECT DISTINCT spesialis FROM dokter ORDER BY spesialis ASC";
        return mysqli_query($this->conn, $sql);
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