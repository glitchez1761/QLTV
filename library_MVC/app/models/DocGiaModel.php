<?php
class NhanVienModel {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query('SELECT * FROM NhanVien ORDER BY MaNhanVien DESC');
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM NhanVien WHERE MaNhanVien = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO NhanVien (HoTen, NgaySinh, GioiTinh, SoDienThoai, DiaChi, ChucVu, TenDangNhap, MatKhau)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $data['HoTen'],
            $data['NgaySinh'] !== '' ? $data['NgaySinh'] : null,
            $data['GioiTinh'],
            $data['SoDienThoai'],
            $data['DiaChi'],
            $data['ChucVu'],
            $data['TenDangNhap'],
            password_hash($data['MatKhau'], PASSWORD_DEFAULT),
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            'UPDATE NhanVien
             SET HoTen = ?, NgaySinh = ?, GioiTinh = ?, SoDienThoai = ?, DiaChi = ?, ChucVu = ?, TenDangNhap = ?
             WHERE MaNhanVien = ?'
        );

        return $stmt->execute([
            $data['HoTen'],
            $data['NgaySinh'] !== '' ? $data['NgaySinh'] : null,
            $data['GioiTinh'],
            $data['SoDienThoai'],
            $data['DiaChi'],
            $data['ChucVu'],
            $data['TenDangNhap'],
            $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM NhanVien WHERE MaNhanVien = ?');
        return $stmt->execute([$id]);
    }
}
