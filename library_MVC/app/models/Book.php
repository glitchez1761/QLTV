<?php
class Book {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function search(string $keyword = ''): array {
        $stmt = $this->db->prepare(
            "SELECT d.*,
                    COUNT(c.copy_id) AS total_copies,
                    COALESCE(SUM(c.trang_thai = 'CON_TRONG_KHO'), 0) AS available_copies
             FROM dau_sach d LEFT JOIN cuon_sach c ON c.book_id = d.book_id
             WHERE (? = '' OR d.ma_sach LIKE ? OR d.ten_sach LIKE ? OR d.tac_gia LIKE ?
                    OR d.the_loai LIKE ? OR d.isbn LIKE ?)
             GROUP BY d.book_id ORDER BY d.ten_sach"
        );
        $term = '%' . $keyword . '%';
        $stmt->execute([$keyword, $term, $term, $term, $term, $term]);
        return $stmt->fetchAll();
    }

    public function findById(int $bookId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM dau_sach WHERE book_id = ?');
        $stmt->execute([$bookId]);
        $book = $stmt->fetch();
        return $book ?: null;
    }

    public function save(array $data, ?int $bookId = null): int {
        $fields = [
            $data['ma_sach'], $data['ten_sach'], $data['the_loai'] ?: null,
            $data['tac_gia'] ?: null, $data['nha_xuat_ban'] ?: null,
            $data['nam_xuat_ban'] !== '' ? (int)$data['nam_xuat_ban'] : null,
            $data['isbn'] ?: null, (float)$data['gia_nhap'],
            $data['vi_tri_luu_tru'] ?: null,
        ];
        if ($bookId === null) {
            $stmt = $this->db->prepare(
                'INSERT INTO dau_sach
                 (ma_sach, ten_sach, the_loai, tac_gia, nha_xuat_ban, nam_xuat_ban, isbn, gia_nhap, vi_tri_luu_tru)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute($fields);
            return (int)$this->db->lastInsertId();
        }
        $stmt = $this->db->prepare(
            'UPDATE dau_sach SET ma_sach=?, ten_sach=?, the_loai=?, tac_gia=?, nha_xuat_ban=?,
             nam_xuat_ban=?, isbn=?, gia_nhap=?, vi_tri_luu_tru=? WHERE book_id=?'
        );
        $stmt->execute(array_merge($fields, [$bookId]));
        return $bookId;
    }

    public function inventory(int $bookId): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM cuon_sach WHERE book_id = ? ORDER BY copy_id DESC'
        );
        $stmt->execute([$bookId]);
        return $stmt->fetchAll();
    }

    public function addCopy(int $bookId, string $copyCode): int {
        $stmt = $this->db->prepare('INSERT INTO cuon_sach (book_id, ma_tai_lieu) VALUES (?, ?)');
        $stmt->execute([$bookId, $copyCode]);
        return (int)$this->db->lastInsertId();
    }
}
