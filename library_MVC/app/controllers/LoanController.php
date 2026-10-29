<?php
require_once __DIR__ . '/../services/LoanService.php';
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/LoanPackage.php';

class LoanController extends Controller {
    private PDO $db;
    private LoanService $loanService;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->loanService = new LoanService($this->db);
    }

    public function create(): void {
        $packages = (new LoanPackage($this->db))->activeAll();
        $this->view('loan/create_loan', ['packages' => $packages]);
    }

    public function store(): void {
        $cardCode = trim($_POST['card_code'] ?? '');
        $rawCodes = $_POST['copy_codes'] ?? [];
        if (!is_array($rawCodes)) {
            $rawCodes = explode(',', (string)$rawCodes);
        }
        $copyCodes = array_values(array_filter(array_map(
            static fn($code): string => trim((string)$code),
            $rawCodes
        ), static fn(string $code): bool => $code !== ''));
        $staffId = (int)($_SESSION['user']['staff_id'] ?? 0);

        $result = $this->loanService->borrowBooks($cardCode, $copyCodes, $staffId);
        $_SESSION[$result['status'] ? 'success' : 'error'] = $result['message'];
        $this->redirect('/loan/create');
    }

    public function renew(): void {
        $result = $this->loanService->renewLoan(
            (int)($_POST['loan_detail_id'] ?? 0),
            (int)($_SESSION['user']['staff_id'] ?? 0)
        );
        $_SESSION[$result['status'] ? 'success' : 'error'] = $result['message'];
        $this->redirect('/loans');
    }

    public function packages(): void {
        $packages = (new LoanPackage($this->db))->activeAll();
        $cards = [];
        if (!empty($_SESSION['user']) && $_SESSION['user']['vai_tro'] === 'DOC_GIA') {
            $stmt = $this->db->prepare(
                "SELECT t.card_id, t.ma_the
                 FROM the_doc_gia t JOIN doc_gia d ON d.reader_id = t.reader_id
                 WHERE d.account_id = ? AND t.trang_thai = 'HOAT_DONG'
                   AND t.ngay_het_han >= CURDATE()"
            );
            $stmt->execute([(int)$_SESSION['user']['account_id']]);
            $cards = $stmt->fetchAll();
        }
        $this->view('loan/packages', ['packages' => $packages, 'cards' => $cards]);
    }

    public function registerPackage(): void {
        $cardId = (int)($_POST['card_id'] ?? 0);
        $packageId = (int)($_POST['package_id'] ?? 0);
        $paymentMethod = trim($_POST['payment_method'] ?? '');
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM the_doc_gia t JOIN doc_gia d ON d.reader_id = t.reader_id
             WHERE t.card_id = ? AND d.account_id = ?'
        );
        $stmt->execute([$cardId, (int)$_SESSION['user']['account_id']]);
        if ((int)$stmt->fetchColumn() !== 1) {
            $_SESSION['error'] = 'Thẻ không thuộc tài khoản độc giả hiện tại.';
            $this->redirect('/packages');
        }

        try {
            (new LoanPackage($this->db))->register($cardId, $packageId, $paymentMethod);
            $_SESSION['success'] = 'Đăng ký gói mượn thành công.';
        } catch (Throwable $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        $this->redirect('/packages');
    }

    public function index(): void {
        $keyword = trim($_GET['keyword'] ?? '');
        $loans = (new Loan($this->db))->activeLoans($keyword);
        $this->view('loan/index', ['loans' => $loans, 'keyword' => $keyword]);
    }

    public function detail(): void {
        $loanId = (int)($_GET['id'] ?? 0);
        $loanModel = new Loan($this->db);
        $loan = $loanModel->findById($loanId);
        $details = $loan ? $loanModel->findDetails($loanId) : [];
        $this->view('loan/detail', ['loan' => $loan, 'details' => $details]);
    }
}
