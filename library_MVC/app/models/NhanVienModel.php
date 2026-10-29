<?php
class SachModel {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query('SELECT * FROM Sach ORDER BY MaSach DESC');
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM Sach WHERE MaSach = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO Sach (TenSach, TacGia, TheLoai, NhaXuatBan, NamXuatBan, SoLuong)
             VALUES (?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $data['TenSach'],
            $data['TacGia'],
            $data['TheLoai'],
            $data['NhaXuatBan'],
            $data['NamXuatBan'] !== '' ? (int)$data['NamXuatBan'] : null,
            (int)($data['SoLuong'] ?? 0),
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            'UPDATE Sach
             SET TenSach = ?, TacGia = ?, TheLoai = ?, NhaXuatBan = ?, NamXuatBan = ?, SoLuong = ?
             WHERE MaSach = ?'
        );

        return $stmt->execute([
            $data['TenSach'],
            $data['TacGia'],
            $data['TheLoai'],
            $data['NhaXuatBan'],
            $data['NamXuatBan'] !== '' ? (int)$data['NamXuatBan'] : null,
            (int)($data['SoLuong'] ?? 0),
            $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM Sach WHERE MaSach = ?');
        return $stmt->execute([$id]);
    }
}
