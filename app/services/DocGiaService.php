<?php
class DocGiaService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM DocGia ORDER BY MaDocGia DESC');
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM DocGia WHERE MaDocGia = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function add(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO DocGia (HoTen, NgaySinh, GioiTinh, SoDienThoai, DiaChi, Email, NgayCapThe, NgayHetHan, TrangThaiThe)
             VALUES (:HoTen, :NgaySinh, :GioiTinh, :SoDienThoai, :DiaChi, :Email, :NgayCapThe, :NgayHetHan, :TrangThaiThe)'
        );
        $stmt->execute($data);
    }

    public function update($id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE DocGia
             SET HoTen = :HoTen,
                 NgaySinh = :NgaySinh,
                 GioiTinh = :GioiTinh,
                 SoDienThoai = :SoDienThoai,
                 DiaChi = :DiaChi,
                 Email = :Email,
                 NgayCapThe = :NgayCapThe,
                 NgayHetHan = :NgayHetHan,
                 TrangThaiThe = :TrangThaiThe
             WHERE MaDocGia = :id'
        );
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function delete($id): void
    {
        $stmt = $this->db->prepare('DELETE FROM DocGia WHERE MaDocGia = :id');
        $stmt->execute(['id' => $id]);
    }
}
