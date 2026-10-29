<?php
require_once __DIR__ . '/../models/Report.php';

class ReportService {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function generate(string $from, string $to, ?int $staffId): array {
        $start = DateTimeImmutable::createFromFormat('!Y-m-d', $from);
        $end = DateTimeImmutable::createFromFormat('!Y-m-d', $to);
        if (!$start || !$end || $start->format('Y-m-d') !== $from || $end->format('Y-m-d') !== $to || $start > $end) {
            throw new InvalidArgumentException('Khoảng ngày báo cáo không hợp lệ.');
        }

        $cardStmt = $this->db->prepare('SELECT COUNT(*) FROM the_doc_gia WHERE ngay_cap BETWEEN ? AND ?');
        $cardStmt->execute([$from, $to]);
        $newCards = (int)$cardStmt->fetchColumn();

        $borrowStmt = $this->db->prepare(
            'SELECT b.book_id, b.ten_sach, COUNT(ct.loan_detail_id) AS borrow_count
             FROM ct_phieu_muon ct
             JOIN cuon_sach c ON c.copy_id = ct.copy_id
             JOIN dau_sach b ON b.book_id = c.book_id
             JOIN phieu_muon p ON p.loan_id = ct.loan_id
             WHERE p.ngay_muon >= ? AND p.ngay_muon < DATE_ADD(?, INTERVAL 1 DAY)
             GROUP BY b.book_id, b.ten_sach ORDER BY borrow_count DESC LIMIT 10'
        );
        $borrowStmt->execute([$from, $to]);
        $borrowList = $borrowStmt->fetchAll();

        $revenue = [];
        $queries = [
            'card_fee' => 'SELECT COALESCE(SUM(so_tien), 0) FROM gia_han_the WHERE ngay_gia_han >= ? AND ngay_gia_han < DATE_ADD(?, INTERVAL 1 DAY) AND trang_thai_thanh_toan = \'DA_THANH_TOAN\'',
            'package_fee' => 'SELECT COALESCE(SUM(so_tien), 0) FROM dang_ky_goi_muon WHERE ngay_dang_ky >= ? AND ngay_dang_ky < DATE_ADD(?, INTERVAL 1 DAY) AND trang_thai_thanh_toan = \'DA_THANH_TOAN\'',
            'fine_fee' => 'SELECT COALESCE(SUM(tong_tien), 0) FROM vi_pham WHERE ngay_xu_ly >= ? AND ngay_xu_ly < DATE_ADD(?, INTERVAL 1 DAY) AND trang_thai_thanh_toan = \'DA_THANH_TOAN\'',
        ];
        foreach ($queries as $key => $sql) {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$from, $to]);
            $revenue[$key] = (float)$stmt->fetchColumn();
        }
        $revenue['total'] = array_sum($revenue);

        $this->db->beginTransaction();
        try {
            $reportModel = new Report($this->db);
            $reportId = $reportModel->save('TONG_HOP', $from, $to, $newCards, $staffId, $revenue);
            $reportModel->saveBookDetails($reportId, $borrowList);
            $this->db->commit();
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }

        return [
            'reportId' => $reportId,
            'from' => $from,
            'to' => $to,
            'newCards' => $newCards,
            'borrowList' => $borrowList,
            'revenue' => $revenue,
        ];
    }
}
