<?php
class User {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare('SELECT * FROM tai_khoan WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $accountId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM tai_khoan WHERE account_id = ? LIMIT 1');
        $stmt->execute([$accountId]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findStaffByAccountId(int $accountId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM nhan_vien WHERE account_id = ? LIMIT 1');
        $stmt->execute([$accountId]);
        $staff = $stmt->fetch();
        return $staff ?: null;
    }

    public function findReaderByAccountId(int $accountId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM doc_gia WHERE account_id = ? LIMIT 1');
        $stmt->execute([$accountId]);
        $reader = $stmt->fetch();
        return $reader ?: null;
    }

    public function createAccount(string $username, string $password, string $role, string $status = 'CHUA_KICH_HOAT'): int {
        $stmt = $this->db->prepare(
            'INSERT INTO tai_khoan (username, password_hash, vai_tro, da_doi_mat_khau_dau, trang_thai)
             VALUES (?, ?, ?, 0, ?)'
        );
        $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role, $status]);
        return (int)$this->db->lastInsertId();
    }
}
