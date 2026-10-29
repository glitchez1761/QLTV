<?php
class BienBanViPhamModel {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query(
            'SELECT b.*, p.MaDocGia, n.HoTen AS TenNhanVien
             FROM BienBanViPham b
             JOIN PhieuMuonSach p ON p.MaPhieuMuon = b.MaPhieuMuon
             JOIN NhanVien n ON n.MaNhanVien = b.MaNhanVien
             ORDER BY b.MaBienBan DESC'
        );
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            'SELECT b.*, p.MaDocGia, n.HoTen AS TenNhanVien
             FROM BienBanViPham b
             JOIN PhieuMuonSach p ON p.MaPhieuMuon = b.MaPhieuMuon
             JOIN NhanVien n ON n.MaNhanVien = b.MaNhanVien
             WHERE b.MaBienBan = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO BienBanViPham (MaPhieuMuon, MaNhanVien, NgayLap, LoaiViPham, MoTa, TienPhat, TrangThai)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            (int)$data['MaPhieuMuon'],
            (int)$data['MaNhanVien'],
            $data['NgayLap'],
            $data['LoaiViPham'],
            $data['MoTa'],
            (float)($data['TienPhat'] ?? 0),
            $data['TrangThai'] ?? 'Chua xu ly',
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            'UPDATE BienBanViPham
             SET MaPhieuMuon = ?, MaNhanVien = ?, NgayLap = ?, LoaiViPham = ?, MoTa = ?, TienPhat = ?, TrangThai = ?
             WHERE MaBienBan = ?'
        );

        return $stmt->execute([
            (int)$data['MaPhieuMuon'],
            (int)$data['MaNhanVien'],
            $data['NgayLap'],
            $data['LoaiViPham'],
            $data['MoTa'],
            (float)($data['TienPhat'] ?? 0),
            $data['TrangThai'] ?? 'Chua xu ly',
            $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM BienBanViPham WHERE MaBienBan = ?');
        return $stmt->execute([$id]);
    }
}
