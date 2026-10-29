CREATE DATABASE IF NOT EXISTS quan_ly_thu_vien 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE quan_ly_thu_vien;

-- 1. Bảng tài khoản người dùng (Sơn)
CREATE TABLE tai_khoan (
    account_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NULL,
    vai_tro ENUM('DOC_GIA', 'NHAN_VIEN', 'QUAN_LY') NOT NULL,
    da_doi_mat_khau_dau BOOLEAN NOT NULL DEFAULT 0,
    trang_thai ENUM('CHUA_KICH_HOAT', 'HOAT_DONG', 'KHOA') NOT NULL DEFAULT 'CHUA_KICH_HOAT',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Bảng nhân viên (Thủy)
CREATE TABLE nhan_vien (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL UNIQUE,
    ma_nv VARCHAR(20) NOT NULL UNIQUE,
    ho_ten VARCHAR(100) NOT NULL,
    ngay_sinh DATE NULL,
    gioi_tinh VARCHAR(10) NULL,
    cccd VARCHAR(20) NULL UNIQUE,
    so_dien_thoai VARCHAR(15) NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    dia_chi VARCHAR(255) NULL,
    chuc_vu VARCHAR(50) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES tai_khoan(account_id)
);

-- 3. Bảng độc giả (Sơn)
CREATE TABLE doc_gia (
    reader_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NULL UNIQUE,
    loai_doc_gia ENUM('NGUOI_LON', 'TRE_EM') NOT NULL,
    ho_ten VARCHAR(100) NOT NULL,
    ngay_sinh DATE NOT NULL,
    gioi_tinh VARCHAR(10) NULL,
    dan_toc VARCHAR(50) NULL DEFAULT 'Kinh',
    quoc_tich VARCHAR(50) NULL DEFAULT 'Vietnam',
    cccd_passport VARCHAR(30) NULL UNIQUE,
    noi_cap VARCHAR(100) NULL,
    nghe_nghiep VARCHAR(100) NULL,
    trinh_do VARCHAR(100) NULL,
    truong_hoc VARCHAR(100) NULL,
    lop_hoc VARCHAR(50) NULL,
    email VARCHAR(100) NULL UNIQUE,
    so_dien_thoai VARCHAR(15) NULL,
    dia_chi_hien_tai VARCHAR(255) NULL,
    anh_2x3 VARCHAR(255) NULL,
    doi_tuong_mien_phi VARCHAR(50) NULL COMMENT 'Người cao tuổi, Khuyết tật, Thiếu nhi',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES tai_khoan(account_id) ON DELETE SET NULL
);

-- 4. Bảng người giám hộ cho độc giả trẻ em (Sơn)
CREATE TABLE nguoi_giam_ho (
    guardian_id INT AUTO_INCREMENT PRIMARY KEY,
    reader_id INT NOT NULL,
    ho_ten VARCHAR(100) NOT NULL,
    so_dien_thoai VARCHAR(15) NOT NULL,
    email VARCHAR(100) NULL,
    dia_chi VARCHAR(255) NULL,
    FOREIGN KEY (reader_id) REFERENCES doc_gia(reader_id) ON DELETE CASCADE
);

-- 5. Bảng hồ sơ đăng ký thẻ (Sơn)
CREATE TABLE ho_so_dang_ky_the (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    doi_tuong_dang_ky ENUM('NGUOI_LON', 'TRE_EM') NOT NULL,
    kenh_dang_ky ENUM('TRUC_TUYEN', 'TAI_QUAY') NOT NULL DEFAULT 'TRUC_TUYEN',
    ho_ten VARCHAR(100) NOT NULL,
    ngay_sinh DATE NOT NULL,
    gioi_tinh VARCHAR(10) NULL,
    cccd_passport VARCHAR(30) NULL,
    email VARCHAR(100) NULL,
    so_dien_thoai VARCHAR(15) NULL,
    dia_chi_hien_tai VARCHAR(255) NULL,
    guardian_name VARCHAR(100) NULL,
    guardian_phone VARCHAR(15) NULL,
    trang_thai ENUM('CHO_DUYET', 'DA_DUYET', 'TU_CHOI') NOT NULL DEFAULT 'CHO_DUYET',
    nhan_vien_xu_ly_id INT NULL,
    ngay_tao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nhan_vien_xu_ly_id) REFERENCES nhan_vien(staff_id)
);

-- 6. Bảng thẻ độc giả (Hòa)
CREATE TABLE the_doc_gia (
    card_id INT AUTO_INCREMENT PRIMARY KEY,
    reader_id INT NOT NULL,
    ma_the VARCHAR(30) NOT NULL UNIQUE,
    don_vi_cap VARCHAR(100) NOT NULL DEFAULT 'Thư viện',
    ngay_cap DATE NOT NULL,
    ngay_het_han DATE NOT NULL,
    trang_thai ENUM('HOAT_DONG', 'HET_HAN', 'BI_HUY', 'KHOA') NOT NULL DEFAULT 'HOAT_DONG',
    cap_boi_staff_id INT NULL,
    ngay_huy DATETIME NULL,
    ly_do_huy VARCHAR(255) NULL,
    huy_boi_staff_id INT NULL,
    FOREIGN KEY (reader_id) REFERENCES doc_gia(reader_id),
    FOREIGN KEY (cap_boi_staff_id) REFERENCES nhan_vien(staff_id),
    FOREIGN KEY (huy_boi_staff_id) REFERENCES nhan_vien(staff_id)
);

-- 7. Bảng lịch sử gia hạn thẻ (Hòa)
CREATE TABLE gia_han_the (
    renewal_id INT AUTO_INCREMENT PRIMARY KEY,
    card_id INT NOT NULL,
    staff_id INT NOT NULL,
    ngay_gia_han DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ngay_het_han_cu DATE NOT NULL,
    ngay_het_han_moi DATE NOT NULL,
    so_tien DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hinh_thuc_thanh_toan ENUM('TIEN_MAT', 'QR', 'VI_DIEN_TU', 'THE_NGAN_HANG', 'MIEN_PHI') NOT NULL,
    trang_thai_thanh_toan ENUM('CHUA_THANH_TOAN', 'DA_THANH_TOAN') NOT NULL DEFAULT 'DA_THANH_TOAN',
    FOREIGN KEY (card_id) REFERENCES the_doc_gia(card_id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES nhan_vien(staff_id)
);

-- 8. Bảng gói mượn sách về nhà (Tú)
CREATE TABLE goi_muon (
    package_id INT AUTO_INCREMENT PRIMARY KEY,
    ten_goi VARCHAR(50) NOT NULL,
    phi_nam DECIMAL(12,2) NOT NULL,
    so_tai_lieu_toi_da INT NOT NULL,
    tong_gia_tri_toi_da DECIMAL(12,2) NOT NULL,
    thoi_han_muon_ngay INT NOT NULL DEFAULT 30,
    hieu_luc_thang INT NOT NULL DEFAULT 12,
    trang_thai ENUM('HOAT_DONG', 'NGUNG_PHUC_VU') NOT NULL DEFAULT 'HOAT_DONG'
);

-- Dữ liệu mẫu 3 gói mượn theo đúng đặc tả
INSERT INTO goi_muon (ten_goi, phi_nam, so_tai_lieu_toi_da, tong_gia_tri_toi_da) VALUES 
('Gói Tiêu Chuẩn 1', 200000.00, 2, 300000.00),
('Gói Tiêu Chuẩn 2', 300000.00, 3, 450000.00),
('Gói Cao Cấp',     500000.00, 5, 750000.00);

-- 9. Bảng đăng ký gói mượn (Tú)
CREATE TABLE dang_ky_goi_muon (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    card_id INT NOT NULL,
    package_id INT NOT NULL,
    ngay_dang_ky DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ngay_hieu_luc DATE NOT NULL,
    ngay_het_han DATE NOT NULL,
    so_tien DECIMAL(12,2) NOT NULL,
    hinh_thuc_thanh_toan ENUM('TIEN_MAT', 'QR', 'VI_DIEN_TU', 'THE_NGAN_HANG') NOT NULL,
    trang_thai_thanh_toan ENUM('CHUA_THANH_TOAN', 'DA_THANH_TOAN') NOT NULL DEFAULT 'DA_THANH_TOAN',
    trang_thai ENUM('DANG_HIEU_LUC', 'HET_HAN', 'DA_HUY') NOT NULL DEFAULT 'DANG_HIEU_LUC',
    FOREIGN KEY (card_id) REFERENCES the_doc_gia(card_id),
    FOREIGN KEY (package_id) REFERENCES goi_muon(package_id)
);

-- 10. Bảng đầu sách (Thủy & Hòa)
CREATE TABLE dau_sach (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    ma_sach VARCHAR(30) NOT NULL UNIQUE,
    ten_sach VARCHAR(255) NOT NULL,
    the_loai VARCHAR(100) NULL,
    tac_gia VARCHAR(150) NULL,
    nha_xuat_ban VARCHAR(150) NULL,
    nam_xuat_ban INT NULL,
    isbn VARCHAR(20) NULL UNIQUE,
    gia_nhap DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    vi_tri_luu_tru VARCHAR(100) NULL,
    trang_thai ENUM('CON_TRONG_KHO', 'DANG_DUOC_MUON', 'NGUNG_PHUC_VU') NOT NULL DEFAULT 'CON_TRONG_KHO',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 11. Bảng cuốn sách cụ thể (Thủy)
CREATE TABLE cuon_sach (
    copy_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    ma_tai_lieu VARCHAR(30) NOT NULL UNIQUE,
    trang_thai ENUM('CON_TRONG_KHO', 'DANG_DUOC_MUON', 'NGUNG_PHUC_VU', 'HU_HONG', 'MAT') NOT NULL DEFAULT 'CON_TRONG_KHO',
    gia_boi_thuong DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    tinh_trang_hien_tai VARCHAR(100) NULL DEFAULT 'Nguyên vẹn',
    FOREIGN KEY (book_id) REFERENCES dau_sach(book_id)
);

-- 12. Bảng đặt trước sách (Tú)
CREATE TABLE dat_truoc (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    reader_id INT NOT NULL,
    book_id INT NOT NULL,
    ngay_dat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    trang_thai ENUM('DANG_CHO', 'DA_NHAN_SACH', 'DA_HUY') NOT NULL DEFAULT 'DANG_CHO',
    FOREIGN KEY (reader_id) REFERENCES doc_gia(reader_id),
    FOREIGN KEY (book_id) REFERENCES dau_sach(book_id)
);

-- 13. Bảng phiếu mượn (Tú)
CREATE TABLE phieu_muon (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    ma_phieu_muon VARCHAR(30) NOT NULL UNIQUE,
    card_id INT NOT NULL,
    package_registration_id INT NOT NULL,
    staff_id INT NOT NULL,
    ngay_muon DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    tong_so_tai_lieu INT NOT NULL DEFAULT 1,
    tong_gia_tri_tai_lieu DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    trang_thai ENUM('DANG_MUON', 'DA_KET_THUC', 'QUA_HAN') NOT NULL DEFAULT 'DANG_MUON',
    FOREIGN KEY (card_id) REFERENCES the_doc_gia(card_id),
    FOREIGN KEY (package_registration_id) REFERENCES dang_ky_goi_muon(registration_id),
    FOREIGN KEY (staff_id) REFERENCES nhan_vien(staff_id)
);

-- 14. Bảng chi tiết phiếu mượn (Tú & Ngân)
CREATE TABLE ct_phieu_muon (
    loan_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_id INT NOT NULL,
    copy_id INT NOT NULL,
    han_tra DATE NOT NULL,
    ngay_tra DATETIME NULL,
    tinh_trang_khi_tra VARCHAR(50) NULL,
    so_lan_gia_han INT NOT NULL DEFAULT 0,
    trang_thai ENUM('DANG_MUON', 'DA_TRA', 'QUA_HAN', 'MAT', 'HU_HONG') NOT NULL DEFAULT 'DANG_MUON',
    FOREIGN KEY (loan_id) REFERENCES phieu_muon(loan_id) ON DELETE CASCADE,
    FOREIGN KEY (copy_id) REFERENCES cuon_sach(copy_id)
);

-- 15. Bảng lịch sử gia hạn mượn (Tú)
CREATE TABLE lich_su_gia_han_muon (
    renew_loan_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_detail_id INT NOT NULL,
    staff_id INT NOT NULL,
    han_tra_cu DATE NOT NULL,
    han_tra_moi DATE NOT NULL,
    ngay_gia_han DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_detail_id) REFERENCES ct_phieu_muon(loan_detail_id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES nhan_vien(staff_id)
);

-- 16. Bảng vi phạm (Ngân)
CREATE TABLE vi_pham (
    violation_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_detail_id INT NOT NULL,
    staff_id INT NOT NULL,
    loai_vi_pham ENUM('TRA_QUA_HAN', 'HU_HONG', 'MAT_TAI_LIEU') NOT NULL,
    so_ngay_qua_han INT NULL DEFAULT 0,
    tien_phat DECIMAL(12,2) NULL DEFAULT 0.00,
    tien_boi_thuong DECIMAL(12,2) NULL DEFAULT 0.00,
    chi_phi_xu_ly DECIMAL(12,2) NULL DEFAULT 0.00,
    tong_tien DECIMAL(12,2) NOT NULL,
    trang_thai_thanh_toan ENUM('CHUA_THANH_TOAN', 'DA_THANH_TOAN') NOT NULL DEFAULT 'CHUA_THANH_TOAN',
    trang_thai ENUM('CHUA_HOAN_TAT', 'DA_XU_LY') NOT NULL DEFAULT 'CHUA_HOAN_TAT',
    ngay_xu_ly DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_detail_id) REFERENCES ct_phieu_muon(loan_detail_id),
    FOREIGN KEY (staff_id) REFERENCES nhan_vien(staff_id)
);

-- 17. Bảng phiếu nhắc nhở quá hạn (Ngân)
CREATE TABLE phieu_nhac_nho (
    reminder_id INT AUTO_INCREMENT PRIMARY KEY,
    ma_phieu_nhac_nho VARCHAR(30) NOT NULL UNIQUE,
    card_id INT NOT NULL,
    ten_doc_gia_snapshot VARCHAR(100) NULL,
    so_dien_thoai_snapshot VARCHAR(15) NULL,
    ngay_lap DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    tong_ngay_qua_han INT NOT NULL DEFAULT 1,
    tong_tien_phat_tam_tinh DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    trang_thai ENUM('DANG_XU_LY', 'DA_XU_LY') NOT NULL DEFAULT 'DANG_XU_LY',
    FOREIGN KEY (card_id) REFERENCES the_doc_gia(card_id) ON DELETE CASCADE
);

-- 18. Bảng chi tiết nhắc nhở (Ngân)
CREATE TABLE ct_nhac_nho (
    reminder_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    reminder_id INT NOT NULL,
    loan_detail_id INT NOT NULL,
    so_ngay_qua_han INT NOT NULL DEFAULT 1,
    tien_phat_tam_tinh DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (reminder_id) REFERENCES phieu_nhac_nho(reminder_id) ON DELETE CASCADE,
    FOREIGN KEY (loan_detail_id) REFERENCES ct_phieu_muon(loan_detail_id) ON DELETE CASCADE
);

-- 19. Bảng báo cáo thống kê (Thủy)
CREATE TABLE bao_cao_thong_ke (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NULL,
    loai_bao_cao VARCHAR(50) NOT NULL,
    tu_ngay DATE NOT NULL,
    den_ngay DATE NOT NULL,
    so_the_moi INT NULL DEFAULT 0,
    doanh_thu_the DECIMAL(14,2) NOT NULL DEFAULT 0.00,
    doanh_thu_goi DECIMAL(14,2) NOT NULL DEFAULT 0.00,
    doanh_thu_vi_pham DECIMAL(14,2) NOT NULL DEFAULT 0.00,
    ngay_tao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (staff_id) REFERENCES nhan_vien(staff_id) ON DELETE SET NULL
);

-- 20. Bảng chi tiết báo cáo mượn sách (Thủy)
CREATE TABLE ct_bao_cao_sach (
    report_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    report_id INT NOT NULL,
    book_id INT NOT NULL,
    so_luot_muon INT NOT NULL DEFAULT 0,
    FOREIGN KEY (report_id) REFERENCES bao_cao_thong_ke(report_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES dau_sach(book_id) ON DELETE CASCADE
);