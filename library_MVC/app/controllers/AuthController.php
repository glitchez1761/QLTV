<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ReaderApplication.php';

class AuthController extends Controller {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function login(): void {
        $this->view('auth/login');
    }

    public function handleLogin(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $account = (new User($this->db))->findByUsername($username);

        if (!$account || empty($account['password_hash']) || !password_verify($password, $account['password_hash'])) {
            $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
            $this->redirect('/auth/login');
        }

        if ($account['trang_thai'] === 'KHOA') {
            $_SESSION['error'] = 'Tài khoản của bạn đang bị khóa';
            $this->redirect('/auth/login');
        }

        // Kiểm tra bắt buộc đổi mật khẩu lần đầu
        if ($account['da_doi_mat_khau_dau'] == 0) {
            session_regenerate_id(true);
            $_SESSION['temp_account_id'] = $account['account_id'];
            $this->redirect('/auth/firstChangePassword');
        }

        session_regenerate_id(true);
        if (in_array($account['vai_tro'], ['NHAN_VIEN', 'QUAN_LY'], true)) {
            $staff = (new User($this->db))->findStaffByAccountId((int)$account['account_id']);
            if (!$staff) {
                $_SESSION['error'] = 'Tài khoản nhân viên chưa được liên kết hồ sơ nhân viên.';
                $this->redirect('/auth/login');
            }
            $account['staff_id'] = (int)$staff['staff_id'];
        }
        $_SESSION['user'] = $account;
        $this->redirect('/');
    }

    public function register(): void {
        $this->view('auth/register');
    }

    public function handleRegister(): void {
        $data = [
            'doi_tuong_dang_ky' => $_POST['doi_tuong_dang_ky'] ?? '',
            'ho_ten' => trim($_POST['ho_ten'] ?? ''),
            'ngay_sinh' => trim($_POST['ngay_sinh'] ?? ''),
            'gioi_tinh' => trim($_POST['gioi_tinh'] ?? ''),
            'cccd_passport' => trim($_POST['cccd_passport'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? ''),
            'dia_chi_hien_tai' => trim($_POST['dia_chi_hien_tai'] ?? ''),
            'guardian_name' => trim($_POST['guardian_name'] ?? ''),
            'guardian_phone' => trim($_POST['guardian_phone'] ?? ''),
        ];
        $dob = DateTimeImmutable::createFromFormat('!Y-m-d', $data['ngay_sinh']);
        if (
            !in_array($data['doi_tuong_dang_ky'], ['NGUOI_LON', 'TRE_EM'], true)
            || $data['ho_ten'] === ''
            || !$dob
            || $dob->format('Y-m-d') !== $data['ngay_sinh']
            || $dob > new DateTimeImmutable('today')
            || ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            || ($data['doi_tuong_dang_ky'] === 'TRE_EM' && ($data['guardian_name'] === '' || $data['guardian_phone'] === ''))
        ) {
            $_SESSION['error'] = 'Vui lòng kiểm tra các thông tin đăng ký bắt buộc.';
            $this->redirect('/auth/register');
        }

        try {
            (new ReaderApplication($this->db))->create($data);
            $_SESSION['success'] = 'Đã gửi hồ sơ. Thư viện sẽ liên hệ sau khi xét duyệt.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể gửi hồ sơ. Email hoặc số giấy tờ có thể đã được sử dụng.';
        }
        $this->redirect('/auth/register');
    }

    public function firstChangePassword(): void {
        $accountId = (int)($_SESSION['temp_account_id'] ?? 0);
        $account = $accountId > 0 ? (new User($this->db))->findById($accountId) : null;
        if (!$account || (int)$account['da_doi_mat_khau_dau'] === 1 || $account['trang_thai'] === 'KHOA') {
            unset($_SESSION['temp_account_id']);
            $this->redirect('/auth/login');
        }
        $this->view('auth/first_change_password', ['role' => $account['vai_tro']]);
    }

    public function handleFirstChangePassword(): void {
        $accountId = (int)($_SESSION['temp_account_id'] ?? 0);
        $cardNumber = trim($_POST['card_number'] ?? '');
        $dob = trim($_POST['dob'] ?? '');
        $newPass = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if ($accountId < 1) {
            $_SESSION['error'] = 'Phiên kích hoạt đã hết hạn. Vui lòng đăng nhập lại.';
            $this->redirect('/auth/login');
        }
        if ($newPass !== $confirmPass || strlen($newPass) < 8) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp hoặc có ít hơn 8 ký tự.';
            $this->redirect('/auth/firstChangePassword');
        }

        $account = (new User($this->db))->findById($accountId);
        if (!$account || $account['trang_thai'] === 'KHOA') {
            unset($_SESSION['temp_account_id']);
            $_SESSION['error'] = 'Tài khoản không thể được kích hoạt.';
            $this->redirect('/auth/login');
        }
        if (in_array($account['vai_tro'], ['NHAN_VIEN', 'QUAN_LY'], true)) {
            $stmt = $this->db->prepare(
                'SELECT account_id FROM nhan_vien WHERE ma_nv = ? AND account_id = ?'
            );
            $stmt->execute([$cardNumber, $accountId]);
        } else {
            $stmt = $this->db->prepare(
                "SELECT d.account_id
                 FROM the_doc_gia t JOIN doc_gia d ON d.reader_id = t.reader_id
                 WHERE t.ma_the = ? AND d.ngay_sinh = ? AND d.account_id = ?
                   AND t.trang_thai = 'HOAT_DONG'"
            );
            $stmt->execute([$cardNumber, $dob, $accountId]);
        }
        $row = $stmt->fetch();

        if (!$row) {
            $_SESSION['error'] = 'Thông tin số thẻ hoặc ngày sinh không khớp!';
            $this->redirect('/auth/firstChangePassword');
        }

        $updateStmt = $this->db->prepare("
            UPDATE tai_khoan 
            SET password_hash = ?, da_doi_mat_khau_dau = 1, trang_thai = 'HOAT_DONG' 
            WHERE account_id = ? AND da_doi_mat_khau_dau = 0 AND trang_thai <> 'KHOA'
        ");
        $updateStmt->execute([password_hash($newPass, PASSWORD_DEFAULT), $row['account_id']]);
        if ($updateStmt->rowCount() !== 1) {
            $_SESSION['error'] = 'Không thể kích hoạt tài khoản. Vui lòng liên hệ thư viện.';
            $this->redirect('/auth/login');
        }

        unset($_SESSION['temp_account_id']);
        $_SESSION['success'] = 'Kích hoạt mật khẩu thành công. Vui lòng đăng nhập lại!';
        $this->redirect('/auth/login');
    }

    public function profile(): void {
        AuthMiddleware::checkLoggedIn();
        $user = $_SESSION['user'];
        $profile = null;
        if (in_array($user['vai_tro'], ['NHAN_VIEN', 'QUAN_LY'], true)) {
            $stmt = $this->db->prepare('SELECT * FROM nhan_vien WHERE account_id = ?');
            $stmt->execute([(int)$user['account_id']]);
            $profile = $stmt->fetch() ?: null;
        } elseif ($user['vai_tro'] === 'DOC_GIA') {
            $stmt = $this->db->prepare(
                'SELECT d.*, t.ma_the, t.ngay_het_han
                 FROM doc_gia d LEFT JOIN the_doc_gia t ON t.reader_id = d.reader_id
                 WHERE d.account_id = ? ORDER BY t.card_id DESC LIMIT 1'
            );
            $stmt->execute([(int)$user['account_id']]);
            $profile = $stmt->fetch() ?: null;
        }
        $this->view('auth/profile', ['profile' => $profile]);
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        $this->redirect('/auth/login');
    }
}