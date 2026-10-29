<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Report.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../services/ReportService.php';

class AdminController extends Controller {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function booksIndex(): void {
        $keyword = trim($_GET['keyword'] ?? '');
        $this->view('admin/books/index', [
            'books' => (new Book($this->db))->search($keyword),
            'keyword' => $keyword,
        ]);
    }

    public function bookCreate(): void {
        $this->view('admin/books/form');
    }

    public function bookEdit(): void {
        $book = (new Book($this->db))->findById((int)($_GET['id'] ?? 0));
        if (!$book) {
            $_SESSION['error'] = 'Không tìm thấy đầu sách.';
            $this->redirect('/admin/books');
        }
        $this->view('admin/books/form', ['book' => $book]);
    }

    public function bookSave(): void {
        $data = [
            'ma_sach' => trim($_POST['ma_sach'] ?? ''),
            'ten_sach' => trim($_POST['ten_sach'] ?? ''),
            'the_loai' => trim($_POST['the_loai'] ?? ''),
            'tac_gia' => trim($_POST['tac_gia'] ?? ''),
            'nha_xuat_ban' => trim($_POST['nha_xuat_ban'] ?? ''),
            'nam_xuat_ban' => trim($_POST['nam_xuat_ban'] ?? ''),
            'isbn' => trim($_POST['isbn'] ?? ''),
            'gia_nhap' => trim($_POST['gia_nhap'] ?? ''),
            'vi_tri_luu_tru' => trim($_POST['vi_tri_luu_tru'] ?? ''),
        ];
        $year = $data['nam_xuat_ban'];
        if (
            $data['ma_sach'] === ''
            || $data['ten_sach'] === ''
            || !is_numeric($data['gia_nhap'])
            || (float)$data['gia_nhap'] < 0
            || ($year !== '' && (!ctype_digit($year) || (int)$year > (int)date('Y') + 1))
        ) {
            $_SESSION['error'] = 'Vui lòng kiểm tra mã sách, tên sách, giá nhập và năm xuất bản.';
            $this->redirect('/admin/books');
        }
        $bookId = (int)($_POST['book_id'] ?? 0);
        try {
            (new Book($this->db))->save($data, $bookId > 0 ? $bookId : null);
            $_SESSION['success'] = $bookId > 0 ? 'Đã cập nhật đầu sách.' : 'Đã thêm đầu sách.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể lưu đầu sách. Mã sách hoặc ISBN có thể đã tồn tại.';
        }
        $this->redirect('/admin/books');
    }

    public function bookInventory(): void {
        $bookModel = new Book($this->db);
        $book = $bookModel->findById((int)($_GET['id'] ?? 0));
        if (!$book) {
            $_SESSION['error'] = 'Không tìm thấy đầu sách.';
            $this->redirect('/admin/books');
        }
        $this->view('admin/books/inventory', [
            'book' => $book,
            'copies' => $bookModel->inventory((int)$book['book_id']),
        ]);
    }

    public function addBookCopy(): void {
        $bookId = (int)($_POST['book_id'] ?? 0);
        $copyCode = trim($_POST['ma_tai_lieu'] ?? '');
        if ($bookId < 1 || $copyCode === '' || strlen($copyCode) > 30) {
            $_SESSION['error'] = 'Mã bản sao không hợp lệ.';
            $this->redirect('/admin/books');
        }
        try {
            (new Book($this->db))->addCopy($bookId, $copyCode);
            $_SESSION['success'] = 'Đã thêm bản sao tài liệu.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể thêm bản sao. Mã tài liệu có thể đã tồn tại.';
        }
        $this->redirect('/admin/books/inventory?id=' . $bookId);
    }

    public function staffIndex(): void {
        $staffList = $this->db->query(
            'SELECT n.*, a.trang_thai AS account_status
             FROM nhan_vien n JOIN tai_khoan a ON a.account_id = n.account_id
             ORDER BY n.staff_id DESC'
        )->fetchAll();
        $this->view('admin/staff/index', ['staffList' => $staffList]);
    }

    public function staffCreate(): void {
        $this->view('admin/staff/form');
    }

    public function staffStore(): void {
        $name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'NHAN_VIEN';
        if (
            $name === ''
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($email) > 50
            || !in_array($role, ['NHAN_VIEN', 'QUAN_LY'], true)
        ) {
            $_SESSION['error'] = 'Vui lòng nhập họ tên, email hợp lệ và vai trò được phép.';
            $this->redirect('/admin/staff/create');
        }

        $staffCode = 'NV' . strtoupper(bin2hex(random_bytes(4)));
        $this->db->beginTransaction();
        try {
            $username = $email;
            $hash = password_hash($staffCode, PASSWORD_DEFAULT);
            $account = $this->db->prepare(
                "INSERT INTO tai_khoan (username, password_hash, vai_tro, da_doi_mat_khau_dau, trang_thai)
                 VALUES (?, ?, ?, 0, 'CHUA_KICH_HOAT')"
            );
            $account->execute([$username, $hash, $role]);
            $accountId = (int)$this->db->lastInsertId();

            $staff = $this->db->prepare(
                'INSERT INTO nhan_vien (account_id, ma_nv, ho_ten, email, so_dien_thoai, chuc_vu)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );
            $staff->execute([$accountId, $staffCode, $name, $email, $phone ?: null, $role]);
            $this->db->commit();
            $_SESSION['success'] = "Đã tạo nhân viên {$staffCode}. Tên đăng nhập: {$email}. Mật khẩu ban đầu là mã nhân viên; yêu cầu đổi ở lần đăng nhập đầu.";
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Không thể tạo nhân viên. Email hoặc tên đăng nhập có thể đã tồn tại.';
        }
        $this->redirect('/admin/staff');
    }

    public function reportIndex(): void {
        $reports = (new Report($this->db))->history();
        $this->view('admin/reports/index', ['reports' => $reports]);
    }

    public function reportGenerate(): void {
        $from = trim($_POST['from_date'] ?? '');
        $to = trim($_POST['to_date'] ?? '');
        try {
            $data = (new ReportService($this->db))->generate(
                $from,
                $to,
                (int)($_SESSION['user']['staff_id'] ?? 0) ?: null
            );
            $this->view('admin/reports/view', $data);
        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
            $this->redirect('/admin/reports');
        }
    }

    public function reportView(): void {
        $reportId = (int)($_GET['id'] ?? 0);
        $report = (new Report($this->db))->findById($reportId);
        if (!$report) {
            $_SESSION['error'] = 'Không tìm thấy báo cáo.';
            $this->redirect('/admin/reports');
        }
        $details = $this->db->prepare(
            'SELECT b.ten_sach, d.so_luot_muon AS borrow_count
             FROM ct_bao_cao_sach d JOIN dau_sach b ON b.book_id = d.book_id
             WHERE d.report_id = ? ORDER BY d.so_luot_muon DESC'
        );
        $details->execute([$reportId]);
        $report['borrowList'] = $details->fetchAll();
        $this->view('admin/reports/view', [
            'from' => $report['tu_ngay'],
            'to' => $report['den_ngay'],
            'newCards' => $report['so_the_moi'],
            'borrowList' => $report['borrowList'],
            'revenue' => [
                'card_fee' => (float)$report['doanh_thu_the'],
                'package_fee' => (float)$report['doanh_thu_goi'],
                'fine_fee' => (float)$report['doanh_thu_vi_pham'],
                'total' => (float)$report['doanh_thu_the'] + (float)$report['doanh_thu_goi'] + (float)$report['doanh_thu_vi_pham'],
            ],
        ]);
    }
}
