<?php
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/Violation.php';
require_once __DIR__ . '/../services/ReturnService.php';

class ReturnController extends Controller {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function index(): void {
        $query = trim($_GET['query'] ?? '');
        $loans = $query === '' ? [] : (new Loan($this->db))->activeLoans($query);
        $this->view('return/index', ['query' => $query, 'loanItems' => $loans]);
    }

    public function checkCondition(): void {
        $stmt = $this->db->prepare(
            "SELECT ct.loan_detail_id, ct.han_tra, c.ma_tai_lieu, b.ten_sach
             FROM ct_phieu_muon ct
             JOIN cuon_sach c ON c.copy_id = ct.copy_id
             JOIN dau_sach b ON b.book_id = c.book_id
             WHERE ct.loan_detail_id = ? AND ct.trang_thai = 'DANG_MUON'"
        );
        $stmt->execute([(int)($_GET['id'] ?? 0)]);
        $this->view('return/check_condition', ['loanItem' => $stmt->fetch() ?: null]);
    }

    public function processReturn(): void {
        $loanDetailId = (int)($_POST['loan_detail_id'] ?? 0);
        $condition = $_POST['condition'] ?? '';
        $staffId = (int)($_SESSION['user']['staff_id'] ?? 0);
        if ($loanDetailId < 1 || $staffId < 1) {
            $_SESSION['error'] = 'Thông tin trả sách hoặc nhân viên không hợp lệ.';
            $this->redirect('/return');
        }

        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare(
                "SELECT ct.*, c.copy_id, c.ma_tai_lieu, b.gia_nhap, p.loan_id
                 FROM ct_phieu_muon ct
                 JOIN cuon_sach c ON c.copy_id = ct.copy_id
                 JOIN dau_sach b ON b.book_id = c.book_id
                 JOIN phieu_muon p ON p.loan_id = ct.loan_id
                 WHERE ct.loan_detail_id = ? AND ct.trang_thai = 'DANG_MUON'
                 FOR UPDATE"
            );
            $stmt->execute([$loanDetailId]);
            $detail = $stmt->fetch();
            if (!$detail) {
                throw new RuntimeException('Không tìm thấy tài liệu đang mượn hoặc tài liệu đã được trả.');
            }

            $now = date('Y-m-d H:i:s');
            $calculation = ReturnService::calculatePenalty(
                $detail['han_tra'],
                $now,
                $condition,
                (float)$detail['gia_nhap']
            );
            $copyStatus = $condition === 'NGUYEN_VEN'
                ? 'CON_TRONG_KHO'
                : ($condition === 'HU_HONG' ? 'HU_HONG' : 'MAT');
            $this->db->prepare(
                'UPDATE cuon_sach SET trang_thai = ?, tinh_trang_hien_tai = ? WHERE copy_id = ?'
            )->execute([$copyStatus, $condition, $detail['copy_id']]);
            $this->db->prepare(
                "UPDATE ct_phieu_muon SET ngay_tra = ?, tinh_trang_khi_tra = ?, trang_thai = 'DA_TRA'
                 WHERE loan_detail_id = ?"
            )->execute([$now, $condition, $loanDetailId]);

            if ($calculation['has_violation']) {
                $violation = $this->db->prepare(
                    "INSERT INTO vi_pham
                     (loan_detail_id, staff_id, loai_vi_pham, so_ngay_qua_han, tien_phat,
                      tien_boi_thuong, chi_phi_xu_ly, tong_tien, trang_thai)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'CHUA_HOAN_TAT')"
                );
                $violation->execute([
                    $loanDetailId,
                    $staffId,
                    $calculation['violation_type'],
                    $calculation['overdue_days'],
                    $calculation['overdue_fine'],
                    $calculation['compensation_fee'],
                    $calculation['processing_fee'],
                    $calculation['total_amount'],
                ]);
            }

            $openItems = $this->db->prepare(
                "SELECT COUNT(*) FROM ct_phieu_muon WHERE loan_id = ? AND trang_thai = 'DANG_MUON'"
            );
            $openItems->execute([$detail['loan_id']]);
            if ((int)$openItems->fetchColumn() === 0) {
                $this->db->prepare("UPDATE phieu_muon SET trang_thai = 'DA_KET_THUC' WHERE loan_id = ?")
                    ->execute([$detail['loan_id']]);
            }
            $this->db->commit();
            $_SESSION['success'] = 'Đã tiếp nhận tài liệu. Khoản phạt/bồi thường phát sinh: '
                . number_format($calculation['total_amount'], 0, ',', '.') . 'đ.';
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Không thể xử lý trả sách: ' . $e->getMessage();
        }
        $this->redirect('/return');
    }

    public function violations(): void {
        $keyword = trim($_GET['keyword'] ?? '');
        $this->view('return/violation_form', [
            'violations' => (new Violation($this->db))->outstanding($keyword),
        ]);
    }

    public function violationDetail(): void {
        $stmt = $this->db->prepare(
            'SELECT v.*, d.ho_ten, b.ten_sach, c.ma_tai_lieu
             FROM vi_pham v
             JOIN ct_phieu_muon ct ON ct.loan_detail_id = v.loan_detail_id
             JOIN phieu_muon p ON p.loan_id = ct.loan_id
             JOIN the_doc_gia t ON t.card_id = p.card_id
             JOIN doc_gia d ON d.reader_id = t.reader_id
             JOIN cuon_sach c ON c.copy_id = ct.copy_id
             JOIN dau_sach b ON b.book_id = c.book_id
             WHERE v.violation_id = ?'
        );
        $stmt->execute([(int)($_GET['id'] ?? 0)]);
        $this->view('return/violation_form', ['violation' => $stmt->fetch() ?: null]);
    }

    public function payViolation(): void {
        $paid = (new Violation($this->db))->markPaid((int)($_POST['violation_id'] ?? 0));
        $_SESSION[$paid ? 'success' : 'error'] = $paid
            ? 'Đã ghi nhận thanh toán và hoàn tất xử lý vi phạm.'
            : 'Vi phạm không tồn tại hoặc đã được xử lý.';
        $this->redirect('/violations');
    }

    public function reminders(): void {
        $this->view('return/reminders', ['reminders' => (new Violation($this->db))->reminders()]);
    }

    public function autoScanReminders(): void {
        $items = $this->db->query(
            "SELECT ct.loan_detail_id, p.card_id, d.ho_ten, d.so_dien_thoai,
                    DATEDIFF(CURDATE(), ct.han_tra) AS days_late
             FROM ct_phieu_muon ct
             JOIN phieu_muon p ON p.loan_id = ct.loan_id
             JOIN the_doc_gia t ON t.card_id = p.card_id
             JOIN doc_gia d ON d.reader_id = t.reader_id
             WHERE ct.trang_thai = 'DANG_MUON' AND ct.han_tra < CURDATE()
             ORDER BY p.card_id"
        )->fetchAll();
        $groups = [];
        foreach ($items as $item) {
            $groups[(int)$item['card_id']][] = $item;
        }

        $this->db->beginTransaction();
        try {
            foreach ($groups as $cardId => $overdueItems) {
                $maxDays = max(array_column($overdueItems, 'days_late'));
                $totalFine = array_sum(array_map(
                    static fn(array $item): float => (int)$item['days_late'] * OVERDUE_FINE_PER_DAY,
                    $overdueItems
                ));
                $reminderCode = 'NN' . date('Ymd') . '_' . $cardId;
                $insert = $this->db->prepare(
                    "INSERT INTO phieu_nhac_nho
                     (ma_phieu_nhac_nho, card_id, ten_doc_gia_snapshot, so_dien_thoai_snapshot,
                      tong_ngay_qua_han, tong_tien_phat_tam_tinh, trang_thai)
                     VALUES (?, ?, ?, ?, ?, ?, 'DANG_XU_LY')
                     ON DUPLICATE KEY UPDATE
                        ten_doc_gia_snapshot = VALUES(ten_doc_gia_snapshot),
                        so_dien_thoai_snapshot = VALUES(so_dien_thoai_snapshot),
                        tong_ngay_qua_han = VALUES(tong_ngay_qua_han),
                        tong_tien_phat_tam_tinh = VALUES(tong_tien_phat_tam_tinh),
                        trang_thai = 'DANG_XU_LY'"
                );
                $insert->execute([
                    $reminderCode,
                    $cardId,
                    $overdueItems[0]['ho_ten'],
                    $overdueItems[0]['so_dien_thoai'],
                    $maxDays,
                    $totalFine,
                ]);
                $idStmt = $this->db->prepare('SELECT reminder_id FROM phieu_nhac_nho WHERE ma_phieu_nhac_nho = ?');
                $idStmt->execute([$reminderCode]);
                $reminderId = (int)$idStmt->fetchColumn();
                $this->db->prepare('DELETE FROM ct_nhac_nho WHERE reminder_id = ?')->execute([$reminderId]);
                $detailInsert = $this->db->prepare(
                    'INSERT INTO ct_nhac_nho (reminder_id, loan_detail_id, so_ngay_qua_han, tien_phat_tam_tinh)
                     VALUES (?, ?, ?, ?)'
                );
                foreach ($overdueItems as $item) {
                    $detailInsert->execute([
                        $reminderId,
                        $item['loan_detail_id'],
                        $item['days_late'],
                        (int)$item['days_late'] * OVERDUE_FINE_PER_DAY,
                    ]);
                }
            }
            $this->db->commit();
            $_SESSION['success'] = 'Đã quét quá hạn và cập nhật ' . count($groups) . ' phiếu nhắc nhở.';
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Không thể quét phiếu nhắc nhở: ' . $e->getMessage();
        }
        $this->redirect('/reminders');
    }
}
