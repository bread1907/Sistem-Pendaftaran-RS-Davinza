<?php
class PasienModel
{
    private $conn;
    private $table = "pasien";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Cek email apakah sudah terdaftar
    public function cekEmail($email)
    {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Insert data pasien baru
    public function insert($data)
    {
        $sql = "INSERT INTO pasien
        (nik, email, username, password, tanggal_lahir, jenis_kelamin, alamat, no_hp)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            die("Prepare error: " . mysqli_error($this->conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            'ssssssss',
            $data['nik'],
            $data['email'],
            $data['username'],
            $data['password'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['alamat'],
            $data['no_hp']
        );

        if (!mysqli_stmt_execute($stmt)) {
            die("Execute error: " . mysqli_stmt_error($stmt));
        }

        return true;
    }


    public function setEmailVerified($email)
    {
        $sql = "UPDATE pasien SET email_verified = 1 WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
    }

    public function simpanKodeVerifikasi($email, $kode, $expiresAt)
    {
        // hapus kode lama untuk email ini
        $sqlDel = "DELETE FROM email_verifikasi WHERE email = ?";
        $stmtDel = mysqli_prepare($this->conn, $sqlDel);
        mysqli_stmt_bind_param($stmtDel, 's', $email);
        mysqli_stmt_execute($stmtDel);

        // insert kode baru
        $sql = "INSERT INTO email_verifikasi (email, kode, expires_at) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $email, $kode, $expiresAt);
        mysqli_stmt_execute($stmt);
    }

    public function cariKodeVerifikasi($email, $kode)
    {
        $sql = "SELECT * FROM email_verifikasi WHERE email = ? AND kode = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $email, $kode);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($res) ?: null;
    }

    public function tandaiKodeTerpakai($id)
    {
        $sql = "UPDATE email_verifikasi SET is_used = 1 WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    }



    // Ambil data pasien berdasarkan email
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Ambil data pasien berdasarkan ID
    public function getById($id): mixed
    {
        $sql = "SELECT * FROM $this->table WHERE pasien_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getPasienWithSummaryFiltered(string $status, string $jenisKelamin, string $sort): array
    {
        $where = [];
        $params = [];
        $types = '';

        // Filter jenis kelamin
        if ($jenisKelamin === 'L' || $jenisKelamin === 'P') {
            $where[] = 'p.jenis_kelamin = ?';
            $params[] = $jenisKelamin;
            $types .= 's';
        }

        // Filter status kunjungan
        // - 'belum_pernah' => pasien tanpa jadwal_temu
        // - 'pending' / 'selesai' / 'batal' => status_terakhir dari join
        if ($status === 'belum_pernah') {
            $where[] = 'jt_terakhir.tanggal_temu IS NULL';
        } elseif (in_array($status, ['pending', 'selesai', 'batal'], true)) {
            $where[] = 'jt_terakhir.status = ?';
            $params[] = $status;
            $types .= 's';
        }

        // Sorting nama
        $orderBy = 'p.username ASC';
        if ($sort === 'z-a') {
            $orderBy = 'p.username DESC';
        }

        // Susun klausa WHERE
        $whereSql = '';
        if (!empty($where)) {
            $whereSql = 'WHERE ' . implode(' AND ', $where);
        }

        $sql = "
        SELECT
            p.pasien_id,
            p.username       AS nama,
            p.tanggal_lahir,
            p.jenis_kelamin,
            p.alamat,
            p.no_hp,
            TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) AS usia,
            jt_terakhir.tanggal_temu    AS kunjungan_terakhir_tgl,
            jt_terakhir.jam_temu        AS kunjungan_terakhir_jam,
            jt_terakhir.status          AS status_terakhir,
            d.nama                      AS dokter_terakhir
        FROM pasien p
        LEFT JOIN (
            SELECT j1.*
            FROM jadwal_temu j1
            JOIN (
                SELECT pasien_id, MAX(CONCAT(tanggal_temu, ' ', jam_temu)) AS max_waktu
                FROM jadwal_temu
                GROUP BY pasien_id
            ) j2
              ON j1.pasien_id = j2.pasien_id
             AND CONCAT(j1.tanggal_temu, ' ', j1.jam_temu) = j2.max_waktu
        ) jt_terakhir
          ON jt_terakhir.pasien_id = p.pasien_id
        LEFT JOIN dokter d
          ON d.dokter_id = jt_terakhir.dokter_id
        $whereSql
        ORDER BY $orderBy
    ";

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $res = $stmt->get_result();
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }



    public function getPasienWithSummary()
    {
        $sql = "
        SELECT
            p.pasien_id,
            p.username      AS nama,
            p.tanggal_lahir,
            p.jenis_kelamin,
            p.alamat,
            p.no_hp,

            TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) AS usia,

            jt_terakhir.tanggal_temu    AS kunjungan_terakhir_tgl,
            jt_terakhir.jam_temu        AS kunjungan_terakhir_jam,
            jt_terakhir.status          AS status_terakhir,
            d.nama                      AS dokter_terakhir

        FROM pasien p

        LEFT JOIN (
            SELECT j1.*
            FROM jadwal_temu j1
            JOIN (
                SELECT pasien_id, MAX(CONCAT(tanggal_temu, ' ', jam_temu)) AS max_waktu
                FROM jadwal_temu
                GROUP BY pasien_id
            ) j2
            ON j1.pasien_id = j2.pasien_id
            AND CONCAT(j1.tanggal_temu, ' ', j1.jam_temu) = j2.max_waktu
        ) jt_terakhir
        ON jt_terakhir.pasien_id = p.pasien_id

        LEFT JOIN dokter d
        ON d.dokter_id = jt_terakhir.dokter_id

        ORDER BY p.username ASC
        ";

        $res = mysqli_query($this->conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getFiltered($status, $jenis_kelamin, $sort)
    {
        $where = [];
        $params = [];
        $types = '';

        // Filter by status
        if ($status !== '') {
            if ($status === 'belum_pernah') {
                $where[] = "jt_terakhir.status IS NULL";
            } else {
                $where[] = "jt_terakhir.status = ?";
                $params[] = $status;
                $types .= 's';
            }
        }

        // Filter by jenis_kelamin
        if ($jenis_kelamin !== '') {
            $where[] = "p.jenis_kelamin = ?";
            $params[] = $jenis_kelamin;
            $types .= 's';
        }

        // Determine sort order
        $orderBy = "p.username ASC";
        if ($sort === 'z-a') {
            $orderBy = "p.username DESC";
        }

        $sql = "
        SELECT
            p.pasien_id,
            p.username      AS nama,
            p.tanggal_lahir,
            p.jenis_kelamin,
            p.alamat,
            p.no_hp,

            TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) AS usia,

            jt_terakhir.tanggal_temu    AS kunjungan_terakhir_tgl,
            jt_terakhir.jam_temu        AS kunjungan_terakhir_jam,
            jt_terakhir.status          AS status_terakhir,
            d.nama                      AS dokter_terakhir

        FROM pasien p

        LEFT JOIN (
            SELECT j1.*
            FROM jadwal_temu j1
            JOIN (
                SELECT pasien_id, MAX(CONCAT(tanggal_temu, ' ', jam_temu)) AS max_waktu
                FROM jadwal_temu
                GROUP BY pasien_id
            ) j2
            ON j1.pasien_id = j2.pasien_id
            AND CONCAT(j1.tanggal_temu, ' ', j1.jam_temu) = j2.max_waktu
        ) jt_terakhir
        ON jt_terakhir.pasien_id = p.pasien_id

        LEFT JOIN dokter d
        ON d.dokter_id = jt_terakhir.dokter_id
        ";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY " . $orderBy;

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

    // Update data pasien
    public function update($id, $data)
    {
        $sql = "UPDATE $this->table SET email=?, username=?, tanggal_lahir=?, jenis_kelamin=?, alamat=?, no_hp=?, nik=? WHERE pasien_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssssssi",
            $data['email'],
            $data['username'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['alamat'],
            $data['no_hp'],
            $data['nik'],
            $id
        );
        return $stmt->execute();
    }

    // Hapus pasien
    public function delete($id)
    {
        // Start transaction
        $this->conn->begin_transaction();

        try {
            // Delete from rekam_medis first
            $sql1 = "DELETE FROM rekam_medis WHERE pasien_id=?";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->bind_param("i", $id);
            $stmt1->execute();

            // Delete from jadwal_temu
            $sql2 = "DELETE FROM jadwal_temu WHERE pasien_id=?";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bind_param("i", $id);
            $stmt2->execute();

            // Finally delete from pasien
            $sql3 = "DELETE FROM $this->table WHERE pasien_id=?";
            $stmt3 = $this->conn->prepare($sql3);
            $stmt3->bind_param("i", $id);
            $result = $stmt3->execute();

            // Commit transaction
            $this->conn->commit();
            return $result;
        } catch (Exception $e) {
            // Rollback on error
            $this->conn->rollback();
            return false;
        }
    }
}
?>