<?php
class SachService
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
        $stmt = $this->db->query('SELECT * FROM sach ORDER BY MaSach DESC');
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM sach WHERE MaSach = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function add(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO sach (MaSach, TenSach, TacGia, NhaXuatBan, SoLuongTon)
             VALUES (:MaSach, :TenSach, :TacGia, :NhaXuatBan, :SoLuongTon)'
        );
        $stmt->execute($data);
    }

    public function update($id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE sach
             SET TenSach = :TenSach,
                 TacGia = :TacGia,
                 NhaXuatBan = :NhaXuatBan,
                 SoLuongTon = :SoLuongTon
             WHERE MaSach = :id'
        );
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function delete($id): void
    {
        $stmt = $this->db->prepare('DELETE FROM sach WHERE MaSach = :id');
        $stmt->execute(['id' => $id]);
    }
}
