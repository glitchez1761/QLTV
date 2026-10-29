<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/LibraryCard.php';

class CardController extends Controller {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function searchBooks(): void {
        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'ten_sach' => trim($_GET['ten_sach'] ?? ''),
            'tac_gia' => trim($_GET['tac_gia'] ?? ''),
            'the_loai' => trim($_GET['the_loai'] ?? ''),
            'nha_xuat_ban' => trim($_GET['nha_xuat_ban'] ?? ''),
            'nam_xuat_ban' => trim($_GET['nam_xuat_ban'] ?? ''),
        ];
        $sql = "SELECT b.*,
                       COUNT(c.copy_id) AS total_copies,
                       COALESCE(SUM(c.trang_thai = 'CON_TRONG_KHO'), 0) AS available_copies
                FROM dau_sach b LEFT JOIN cuon_sach c ON c.book_id = b.book_id
                WHERE (? = '' OR b.ma_sach LIKE ? OR b.ten_sach LIKE ? OR b.tac_gia LIKE ? OR b.isbn LIKE ?)
                  AND (? = '' OR b.ten_sach LIKE ?)
                  AND (? = '' OR b.tac_gia LIKE ?)
                  AND (? = '' OR b.the_loai = ?)
                  AND (? = '' OR b.nha_xuat_ban LIKE ?)
                  AND (? = '' OR b.nam_xuat_ban = ?)
                GROUP BY b.book_id ORDER BY b.ten_sach";
        $term = '%' . $filters['keyword'] . '%';
        $publisher = '%' . $filters['nha_xuat_ban'] . '%';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $filters['keyword'], $term, $term, $term, $term,
            $filters['ten_sach'], '%' . $filters['ten_sach'] . '%',
            $filters['tac_gia'], '%' . $filters['tac_gia'] . '%',
            $filters['the_loai'], $filters['the_loai'],
            $filters['nha_xuat_ban'], $publisher,
            $filters['nam_xuat_ban'], $filters['nam_xuat_ban'] !== '' ? (int)$filters['nam_xuat_ban'] : null,
        ]);
        $this->view('card/search_books', ['books' => $stmt->fetchAll(), 'filters' => $filters]);
    }

    public function cardList(): void {
        $keyword = trim($_GET['keyword'] ?? '');
        $cards = (new LibraryCard($this->db))->all($keyword);
        $this->view('card/card_list', ['cards' => $cards, 'keyword' => $keyword]);
    }

    public function renewForm(): void {
        $card = (new LibraryCard($this->db))->findById((int)($_GET['id'] ?? 0));
        $this->view('card/renew_card_popup', ['card' => $card]);
    }

    public function renewCard(): void {
        $cardId = (int)($_POST['card_id'] ?? 0);
        $staffId = (int)($_SESSION['user']['staff_id'] ?? 0);
        $card = (new LibraryCard($this->db))->findById($cardId);
        if (!$card || $card['trang_thai'] === 'BI_HUY' || $staffId < 1) {
            $_SESSION['error'] = 'Thẻ không tồn tại, đã bị hủy hoặc tài khoản nhân viên không hợp lệ.';
            $this->redirect('/cards');
        }

        $age = (new DateTimeImmutable($card['ngay_sinh']))->diff(new DateTimeImmutable('today'))->y;
        $isFree = ($age > 60 || $age < 16 || !empty($card['doi_tuong_mien_phi']));
        $fee = $isFree ? 0.0 : CARD_RENEWAL_FEE;
        $baseDate = $card['ngay_het_han'] >= date('Y-m-d') ? $card['ngay_het_han'] : date('Y-m-d');
        $newExpiry = date('Y-m-d', strtotime($baseDate . ' +1 year'));

        $this->db->beginTransaction();
        try {
            $update = $this->db->prepare(
                "UPDATE the_doc_gia SET ngay_het_han = ?, trang_thai = 'HOAT_DONG'
                 WHERE card_id = ? AND trang_thai <> 'BI_HUY'"
            );
            $update->execute([$newExpiry, $cardId]);
            if ($update->rowCount() !== 1) {
                throw new RuntimeException('Không thể gia hạn thẻ.');
            }
            $renewal = $this->db->prepare(
                "INSERT INTO gia_han_the
                 (card_id, staff_id, ngay_het_han_cu, ngay_het_han_moi, so_tien, hinh_thuc_thanh_toan, trang_thai_thanh_toan)
                 VALUES (?, ?, ?, ?, ?, ?, 'DA_THANH_TOAN')"
            );
            $renewal->execute([
                $cardId, $staffId, $card['ngay_het_han'], $newExpiry,
                $fee, $isFree ? 'MIEN_PHI' : 'TIEN_MAT',
            ]);
            $this->db->commit();
            $_SESSION['success'] = 'Gia hạn thẻ thành công đến ' . $newExpiry . '. Phí: ' . number_format($fee) . 'đ.';
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Không thể gia hạn thẻ: ' . $e->getMessage();
        }
        $this->redirect('/cards');
    }

    public function cancelCard(): void {
        $cardId = (int)($_POST['card_id'] ?? 0);
        $reason = trim($_POST['reason'] ?? '');
        if ($reason === '') {
            $reason = 'Yêu cầu hủy tại quầy';
        }
        $cancelled = (new LibraryCard($this->db))->cancel(
            $cardId,
            substr($reason, 0, 255),
            (int)($_SESSION['user']['staff_id'] ?? 0)
        );
        $_SESSION[$cancelled ? 'success' : 'error'] = $cancelled
            ? 'Đã hủy hiệu lực thẻ.'
            : 'Không thể hủy thẻ hoặc thẻ không còn hiệu lực.';
        $this->redirect('/cards');
    }
}
