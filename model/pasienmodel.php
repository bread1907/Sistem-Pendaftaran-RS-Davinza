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
    public function insert($data) {
        $sql = "INSERT INTO pasien
            (nik, email, username, password, tanggal_lahir, jenis_kelamin, alamat, no_hp)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
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
        return mysqli_stmt_execute($stmt);
    }


    public function simpanKodeVerifikasi($email, $kode, $expiresAt){
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

    public function cariKodeVerifikasi($email, $kode){
        $sql = "SELECT * FROM email_verifikasi WHERE email = ? AND kode = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $email, $kode);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($res) ?: null;
    }

    public function tandaiKodeTerpakai($id){
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
    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE pasien_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
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

    // Update data pasien
    public function update($id, $data)
    {
        $sql = "UPDATE $this->table SET email=?, username=?, tanggal_lahir=?, jenis_kelamin=?, alamat=?, no_hp=? nik=? WHERE pasien_id=?";
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
        $sql = "DELETE FROM $this->table WHERE pasien_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>