<?php
class ReaderApplication {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO ho_so_dang_ky_the
                (doi_tuong_dang_ky, kenh_dang_ky, ho_ten, ngay_sinh, gioi_tinh,
                 cccd_passport, email, so_dien_thoai, dia_chi_hien_tai, guardian_name, guardian_phone)
             VALUES
                (:type, 'TRUC_TUYEN', :name, :dob, :gender, :identity, :email, :phone, :address, :guardian, :guardian_phone)"
        );
        $stmt->execute([
            'type' => $data['doi_tuong_dang_ky'],
            'name' => $data['ho_ten'],
            'dob' => $data['ngay_sinh'],
            'gender' => $data['gioi_tinh'] ?: null,
            'identity' => $data['cccd_passport'] ?: null,
            'email' => $data['email'] ?: null,
            'phone' => $data['so_dien_thoai'] ?: null,
            'address' => $data['dia_chi_hien_tai'] ?: null,
            'guardian' => $data['guardian_name'] ?: null,
            'guardian_phone' => $data['guardian_phone'] ?: null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function findPending(): array {
        return $this->db->query(
            "SELECT * FROM ho_so_dang_ky_the WHERE trang_thai = 'CHO_DUYET' ORDER BY ngay_tao"
        )->fetchAll();
    }

    public function findById(int $applicationId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM ho_so_dang_ky_the WHERE application_id = ?');
        $stmt->execute([$applicationId]);
        $application = $stmt->fetch();
        return $application ?: null;
    }

    public function setStatus(int $applicationId, string $status, ?int $staffId): bool {
        if (!in_array($status, ['DA_DUYET', 'TU_CHOI'], true)) {
            throw new InvalidArgumentException('Trạng thái hồ sơ không hợp lệ.');
        }
        $stmt = $this->db->prepare(
            'UPDATE ho_so_dang_ky_the SET trang_thai = ?, nhan_vien_xu_ly_id = ?
             WHERE application_id = ? AND trang_thai = \'CHO_DUYET\''
        );
        $stmt->execute([$status, $staffId, $applicationId]);
        return $stmt->rowCount() === 1;
    }
}
