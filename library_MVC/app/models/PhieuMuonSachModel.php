<?php
class DocGiaModel {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query('SELECT * FROM DocGia ORDER BY MaDocGia DESC');
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM DocGia WHERE MaDocGia = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO DocGia (HoTen, NgaySinh, GioiTinh, SoDienThoai, DiaChi, Email, NgayCapThe, NgayHetHan, TrangThaiThe)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $data['HoTen'],
            $data['NgaySinh'] !== '' ? $data['NgaySinh'] : null,
            $data['GioiTinh'],
            $data['SoDienThoai'],
            $data['DiaChi'],
            $data['Email'],
            $data['NgayCapThe'],
            $data['NgayHetHan'],
            $data['TrangThaiThe'] ?? 'Con han',
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            'UPDATE DocGia
             SET HoTen = ?, NgaySinh = ?, GioiTinh = ?, SoDienThoai = ?, DiaChi = ?, Email = ?, NgayCapThe = ?, NgayHetHan = ?, TrangThaiThe = ?
             WHERE MaDocGia = ?'
        );

        return $stmt->execute([
            $data['HoTen'],
            $data['NgaySinh'] !== '' ? $data['NgaySinh'] : null,
            $data['GioiTinh'],
            $data['SoDienThoai'],
            $data['DiaChi'],
            $data['Email'],
            $data['NgayCapThe'],
            $data['NgayHetHan'],
            $data['TrangThaiThe'] ?? 'Con han',
            $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM DocGia WHERE MaDocGia = ?');
        return $stmt->execute([$id]);
    }
}
