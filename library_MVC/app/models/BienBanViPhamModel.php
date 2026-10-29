<?php
class PhieuMuonSachModel {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query(
            'SELECT p.*, d.HoTen AS TenDocGia, n.HoTen AS TenNhanVien, s.TenSach AS TenSach
             FROM PhieuMuonSach p
             JOIN DocGia d ON d.MaDocGia = p.MaDocGia
             JOIN NhanVien n ON n.MaNhanVien = p.MaNhanVien
             JOIN Sach s ON s.MaSach = p.MaSach
             ORDER BY p.MaPhieuMuon DESC'
        );
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            'SELECT p.*, d.HoTen AS TenDocGia, n.HoTen AS TenNhanVien, s.TenSach AS TenSach
             FROM PhieuMuonSach p
             JOIN DocGia d ON d.MaDocGia = p.MaDocGia
             JOIN NhanVien n ON n.MaNhanVien = p.MaNhanVien
             JOIN Sach s ON s.MaSach = p.MaSach
             WHERE p.MaPhieuMuon = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO PhieuMuonSach (MaDocGia, MaNhanVien, MaSach, NgayMuon, HanTra, NgayTra, SoLuongMuon, TrangThai)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            (int)$data['MaDocGia'],
            (int)$data['MaNhanVien'],
            (int)$data['MaSach'],
            $data['NgayMuon'],
            $data['HanTra'],
            $data['NgayTra'] !== '' ? $data['NgayTra'] : null,
            (int)($data['SoLuongMuon'] ?? 1),
            $data['TrangThai'] ?? 'Dang muon',
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            'UPDATE PhieuMuonSach
             SET MaDocGia = ?, MaNhanVien = ?, MaSach = ?, NgayMuon = ?, HanTra = ?, NgayTra = ?, SoLuongMuon = ?, TrangThai = ?
             WHERE MaPhieuMuon = ?'
        );

        return $stmt->execute([
            (int)$data['MaDocGia'],
            (int)$data['MaNhanVien'],
            (int)$data['MaSach'],
            $data['NgayMuon'],
            $data['HanTra'],
            $data['NgayTra'] !== '' ? $data['NgayTra'] : null,
            (int)($data['SoLuongMuon'] ?? 1),
            $data['TrangThai'] ?? 'Dang muon',
            $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM PhieuMuonSach WHERE MaPhieuMuon = ?');
        return $stmt->execute([$id]);
    }
}
