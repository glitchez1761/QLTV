# HỆ THỐNG QUẢN LÝ THƯ VIỆN SÁCH (LIBRARY MANAGEMENT SYSTEM)
> **Báo cáo Bài tập lớn:** Phân tích Thiết kế Hệ thống Thông tin & Công nghệ Web  
> **Nhóm thực hiện:** Nhóm 6 – Khoa Công nghệ Thông tin, Trường Đại học Thủy Lợi  
> **Kiến trúc:** Native PHP MVC (Không dùng framework cồng kềnh, tối ưu hiệu năng và bám sát kiến trúc phần mềm)

---

## 📌 MỤC LỤC
1. [Giới thiệu tổng quan](#1-giới-thiệu-tổng-quan)
2. [Cấu trúc mã nguồn (MVC Architecture)](#2-cấu-trúc-mã-nguồn-mvc-architecture)
3. [Phân hệ 5 Nghiệp vụ cốt lõi](#3-phân-hệ-5-nghiệp-vụ-cốt-lõi)
4. [Tài khoản kiểm thử phân quyền (RBAC)](#4-tài-khoản-kiểm-thử-phân-quyền-rbac)
5. [Hướng dẫn cài đặt Local bằng XAMPP](#5-hướng-dẫn-cài-đặt-local-bằng-xampp)
6. [Hướng dẫn kết nối CSDL Đám mây (Cloud Database)](#6-hướng-dẫn-kết-nối-csdl-đám-mây-cloud-database)
7. [Kịch bản kiểm thử (Test Cases Flow)](#7-kịch-bản-kiểm-thử-test-cases-flow)
8. [Khắc phục lỗi thường gặp (Troubleshooting)](#8-khắc-phục-lỗi-thường-gặp-troubleshooting)

---

## 1. Giới thiệu tổng quan
Dự án được xây dựng nhằm tin học hóa toàn bộ chu trình nghiệp vụ của một thư viện hiện đại:
- **Ngôn ngữ lập trình:** PHP (>= 7.4 / 8.x).
- **Mô hình kiến trúc:** MVC thuần (Model - View - Controller) kết hợp tầng Service xử lý Transaction.
- **Hệ quản trị CSDL:** MySQL (InnoDB engine, Charset `utf8mb4`).
- **Giao diện:** Bootstrap 5, Bootstrap Icons, Responsive Web Design.
- **Bảo mật:** PDO Prepared Statements (chống SQL Injection), mã hóa mật khẩu `PASSWORD_BCRYPT`, kiểm soát phiên làm việc `Session`, phân quyền đa vai trò (Role-Based Access Control - RBAC).

---

## 2. Cấu trúc mã nguồn (MVC Architecture)

```text
library_MVC/
├── .htaccess                          # Điều hướng toàn bộ request vào index.php
├── index.php                          # Điểm vào ứng dụng (Front Controller & Router)
├── migration.sql                      # Script khởi tạo 20 bảng CSDL & dữ liệu mẫu
├── README.md                          # Hướng dẫn cài đặt & kiểm thử
├── app/
│   ├── config/
│   │   ├── config.php                 # Hằng số biểu phí, tiền phạt, BASE_URL
│   │   └── database.php               # Thông số kết nối MySQL PDO
│   ├── libs/
│   │   ├── Database.php               # Kết nối CSDL Singleton PDO
│   │   ├── Controller.php             # Base Controller (render view, trả về json)
│   │   ├── Router.php                 # Bộ định tuyến Clean URL
│   │   └── AuthMiddleware.php         # Kiểm tra phiên đăng nhập & phân quyền RBAC
│   ├── controllers/
│   │   ├── HomeController.php         # Trang đích
│   │   ├── AuthController.php         # Phụ trách: Sơn (UC01 - UC04)
│   │   ├── LoanController.php         # Phụ trách: Tú (UC05 - UC08)
│   │   ├── ReturnController.php       # Phụ trách: Ngân (UC09 - UC12)
│   │   ├── CardController.php         # Phụ trách: Hòa (UC13 - UC16)
│   │   └── AdminController.php        # Phụ trách: Thủy (UC17 - UC23)
│   ├── models/
│   │   ├── User.php                   # Tương tác bảng: tai_khoan, doc_gia, nhan_vien
│   │   ├── ReaderApplication.php      # Tương tác bảng: ho_so_dang_ky_the, nguoi_giam_ho
│   │   ├── LibraryCard.php            # Tương tác bảng: the_doc_gia, gia_han_the
│   │   ├── Book.php                   # Tương tác bảng: dau_sach, cuon_sach
│   │   ├── LoanPackage.php            # Tương tác bảng: goi_muon, dang_ky_goi_muon
│   │   ├── Loan.php                   # Tương tác bảng: phieu_muon, ct_phieu_muon
│   │   ├── Violation.php              # Tương tác bảng: vi_pham, phieu_nhac_nho, ct_nhac_nho
│   │   └── Report.php                 # Tương tác bảng: bao_cao_thong_ke, ct_bao_cao_sach
│   ├── services/
│   │   ├── LoanService.php            # Transaction mượn sách & kiểm tra hạn mức gói
│   │   ├── ReturnService.php          # Công thức tính phạt trễ hạn & bồi thường hỏng/mất
│   │   └── ReportService.php          # Tổng hợp thống kê doanh thu & lượt mượn
│   └── views/
│       ├── layouts/                   # header, footer, navbar chung
│       ├── auth/                      # Màn hình đăng nhập, đăng ký thẻ, đổi MK lần đầu
│       ├── loan/                      # Màn hình lập phiếu mượn, đăng ký gói
│       ├── return/                    # Màn hình nhận trả sách, xử lý vi phạm, phiếu nhắc
│       ├── card/                      # Màn hình tra cứu sách OPAC, quản lý thẻ
│       └── admin/                     # Quản lý nhân viên, quản lý sách, báo cáo doanh thu
└── public/
    ├── css/                           # File định dạng style.css, bootstrap.min.css
    ├── js/                            # Script xử lý tính toán form & AJAX
    └── uploads/                       # Thư mục lưu trữ ảnh chân dung 2x3 độc giả
```

---

## 3. Phân hệ 5 Nghiệp vụ cốt lõi

| STT | Nghiệp vụ | Use Case chi tiết | Phụ trách | Bảng CSDL chính |
| :---: | :--- | :--- | :---: | :--- |
| **1** | **Tài khoản & Độc giả** | **UC01**: Đăng ký thẻ trực tuyến<br>**UC02**: Đổi mật khẩu lần đầu<br>**UC03**: Đăng nhập<br>**UC04**: Cập nhật thông tin | **Sơn** | `tai_khoan`, `doc_gia`, `ho_so_dang_ky_the`, `nguoi_giam_ho` |
| **2** | **Gói dịch vụ & Mượn sách** | **UC05**: Lập phiếu mượn<br>**UC06**: Kiểm tra tồn kho<br>**UC07**: Đăng ký gói mượn<br>**UC08**: Gia hạn mượn sách | **Tú** | `goi_muon`, `dang_ky_goi_muon`, `phieu_muon`, `ct_phieu_muon`, `lich_su_gia_han_muon`, `dat_truoc` |
| **3** | **Trả sách & Xử lý vi phạm** | **UC09**: Quét nhắc nhở quá hạn<br>**UC10**: Kiểm tra tình trạng sách trả<br>**UC11**: Trả sách<br>**UC12**: Thu phạt & bồi thường | **Ngân** | `phieu_muon`, `ct_phieu_muon`, `vi_pham`, `phieu_nhac_nho`, `ct_nhac_nho`, `cuon_sach` |
| **4** | **Thẻ độc giả & Tra cứu** | **UC13**: Gia hạn thẻ độc giả<br>**UC14**: Hủy thẻ độc giả<br>**UC15**: Kiểm tra thẻ hợp lệ<br>**UC16**: Tra cứu sách (OPAC) | **Hòa** | `the_doc_gia`, `gia_han_the`, `dau_sach`, `cuon_sach` |
| **5** | **Quản trị & Báo cáo** | **UC17-19**: Thêm/Sửa/Xóa sách<br>**UC20-22**: Quản lý nhân viên<br>**UC23**: Báo cáo doanh thu | **Thủy** | `dau_sach`, `cuon_sach`, `nhan_vien`, `tai_khoan`, `bao_cao_thong_ke`, `ct_bao_cao_sach` |

---

## 4. Tài khoản kiểm thử phân quyền (RBAC)

Hệ thống được nạp sẵn dữ liệu kiểm thử trong `migration.sql` với 3 cấp độ tài khoản:

| Vai trò (Role) | Tên đăng nhập (Username) | Mật khẩu | Quyền hạn truy cập |
| :--- | :--- | :--- | :--- |
| **Quản trị viên (Admin)** | `admin@thuyloi.vn` | `admin123` | Toàn quyền hệ thống: Quản lý nhân sự, xem báo cáo doanh thu, biên mục sách. |
| **Nhân viên (Staff)** | `staff@thuyloi.vn` | `123456@` | Lập phiếu mượn, nhận trả sách, xử lý vi phạm thu tiền, gia hạn/hủy thẻ, kiểm kê kho. |
| **Độc giả (Reader - Đã kích hoạt)** | `docgia@gmail.com` | `123456@` | Tra cứu sách (OPAC), xem thông tin cá nhân, đăng ký gói dịch vụ mượn về nhà. |
| **Độc giả mới (Chưa kích hoạt)** | Số thẻ: `THE2026002`<br>Ngày sinh: `2004-05-15` | *Chưa có* | Kiểm thử tính năng **UC02: Đổi mật khẩu lần đầu** để kích hoạt tài khoản. |

---

## 5. Hướng dẫn cài đặt Local bằng XAMPP

### Bước 1: Sao chép mã nguồn vào thư mục Web
1. Cài đặt và mở **XAMPP Control Panel**, nhấn **Start** cả 2 dịch vụ **Apache** và **MySQL**.
2. Clone hoặc giải nén thư mục dự án vào thư mục `htdocs` của XAMPP:
   ```text
   C:\xampp\htdocs\library_MVC
   ```

### Bước 2: Khởi tạo Cơ sở dữ liệu
1. Mở trình duyệt, truy cập công cụ quản trị CSDL: `http://localhost/phpmyadmin`.
2. Tạo mới một database với thông số:
   - **Tên cơ sở dữ liệu:** `quan_ly_thu_vien`
   - **Bảng mã (Collation):** `utf8mb4_unicode_ci`
3. Nhấp vào tab **Nhập (Import)** -> Chọn file `migration.sql` nằm ở thư mục gốc dự án -> Bấm **Thực hiện (Go)** để tạo 20 bảng và nạp dữ liệu mẫu.

### Bước 3: Cấu hình kết nối CSDL & Đường dẫn
Mở file `app/config/database.php` và kiểm tra thông tin kết nối local:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'quan_ly_thu_vien');
define('DB_USER', 'root');
define('DB_PASS', '');           // Mặc định XAMPP để trống password
define('DB_CHARSET', 'utf8mb4');
```

Mở file `app/config/config.php` và cấu hình URL gốc của bạn:
```php
define('BASE_URL', 'http://localhost/library_MVC');
```

### Bước 4: Trải nghiệm ứng dụng
Truy cập hệ thống qua trình duyệt theo địa chỉ:
```text
http://localhost/library_MVC
```

---

## 6. Hướng dẫn kết nối CSDL Đám mây (Cloud Database)

Nếu nhóm muốn làm việc cộng tác từ xa mà không phải import database thủ công trên từng máy, hoặc deploy ứng dụng lên hosting online:

### Cách 1: Sử dụng dịch vụ Cloud MySQL (Khuyên dùng: Aiven.io hoặc TiDB Cloud)
1. Đăng ký tài khoản miễn phí tại [Aiven.io](https://aiven.io/) hoặc [Clever Cloud](https://www.clever-cloud.com/).
2. Tạo một dịch vụ **MySQL Free Tier**.
3. Lấy thông tin kết nối từ trang quản trị:
   - **Host / Service URI** (Ví dụ: `mysql-xxxx.aivencloud.com`)
   - **Port** (Ví dụ: `15234`)
   - **Database Name** (Ví dụ: `defaultdb` hoặc `quan_ly_thu_vien`)
   - **User** (Ví dụ: `avnadmin`)
   - **Password** (Ví dụ: `AVNS_xxxxxxxx`)
4. Dùng phần mềm **HeidiSQL**, **DBeaver** hoặc **MySQL Workbench** kết nối vào Cloud DB này, mở file `migration.sql` và bấm **Execute Script** để tạo bảng.
5. Cập nhật lại file `app/config/database.php` trên mã nguồn của cả nhóm:
   ```php
   define('DB_HOST', 'mysql-xxxx.aivencloud.com');
   define('DB_PORT', '15234');
   define('DB_NAME', 'quan_ly_thu_vien');
   define('DB_USER', 'avnadmin');
   define('DB_PASS', 'Mật_khẩu_cloud_của_bạn');
   define('DB_CHARSET', 'utf8mb4');
   ```

*Lưu ý:* Nếu sử dụng Port khác mặc định 3306, cập nhật chuỗi kết nối trong file `app/libs/Database.php`:
```php
$dsn = "mysql:host=" . DB_HOST . ";port=" . (defined('DB_PORT') ? DB_PORT : 3306) . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
```

---

## 7. Kịch bản kiểm thử (Test Cases Flow)

Tester có thể thực hiện tuần tự theo luồng nghiệp vụ thực tế dưới đây để kiểm tra trọn vẹn 23 Use Case:

### Kịch bản 1: Đăng ký & Kích hoạt tài khoản độc giả (Module Sơn - UC01, UC02, UC03)
1. Truy cập: `http://localhost/library_MVC/auth/register`.
2. Chọn tab **Người lớn**: Điền họ tên, số CCCD, ngày sinh, email, tải ảnh và nhập mã Captcha -> Bấm **Đăng ký**.
3. Kiểm tra CSDL bảng `ho_so_dang_ky_the` xuất hiện bản ghi mới ở trạng thái `CHO_DUYET`.
4. Truy cập: `http://localhost/library_MVC/auth/firstChangePassword` để kiểm thử đổi mật khẩu lần đầu:
   - Nhập số thẻ: `THE2026002`, Ngày sinh: `2004-05-15`.
   - Nhập mật khẩu mới: `123456@` -> Bấm **Lưu**.
   - Hệ thống thông báo thành công và chuyển sang form đăng nhập.

### Kịch bản 2: Đăng ký gói dịch vụ & Mượn sách (Module Tú - UC05, UC07)
1. Đăng nhập bằng tài khoản Độc giả: `docgia@gmail.com` / `123456@`.
2. Vào mục **Gói dịch vụ mượn về**: Chọn gói **Gói Tiêu Chuẩn 1 (200.000đ/năm - mượn 2 cuốn, trần 300.000đ)** -> Xác nhận đăng ký.
3. Đăng xuất, đăng nhập lại bằng tài khoản Nhân viên: `staff@thuyloi.vn` / `123456@`.
4. Vào menu **Lập phiếu mượn**:
   - Nhập mã thẻ: `THE2026001`.
   - Nhập mã cuốn sách: `CS-00001` (và bấm thêm dòng mượn thứ 2 `CS-00002`).
   - Bấm **Xác nhận lập phiếu mượn**.
   - Kiểm tra hệ thống tự tính hạn trả `+30 ngày` và trạng thái 2 cuốn sách chuyển sang `DANG_DUOC_MUON`.

### Kịch bản 3: Trả sách & Tính tiền phạt vi phạm (Module Ngân - UC10, UC11, UC12)
1. Sử dụng tài khoản Nhân viên, vào menu **Trả sách & Vi phạm**.
2. Tra cứu mã phiếu mượn vừa tạo (hoặc nhập ID dòng mượn).
3. **Trường hợp trả đúng hạn:** Chọn tình trạng `1. Sách còn nguyên vẹn` -> Bấm hoàn tất -> Sách tự chuyển về `CON_TRONG_KHO`.
4. **Trường hợp vi phạm:** 
   - Đổi tình trạng sang `2. Bị hư hỏng / rách trang` hoặc chỉnh ngày hẹn trả lùi về quá khứ để giả lập quá hạn.
   - Kiểm tra xem giao diện có tự động cộng tiền: `Phạt quá hạn (2.000đ/ngày)` + `Bồi thường (Giá bìa + 30.000đ phí nghiệp vụ)`.
   - Bấm xác nhận nộp tiền -> Bản ghi lưu vào bảng `vi_pham` với trạng thái `DA_XU_LY`.

### Kịch bản 4: Quản lý thẻ độc giả & Tra cứu OPAC (Module Hòa - UC13, UC15, UC16)
1. Vào trang chủ **Tra cứu sách**: Tìm kiếm theo tác giả, từ khóa hoặc thể loại -> Bấm nút **Xem chi tiết** để mở Popup kiểm tra số cuốn còn trong kho và vị trí lưu trữ trên giá kệ.
2. Với quyền Nhân viên, thực hiện **Gia hạn thẻ**:
   - Nhập mã thẻ sắp hết hạn.
   - Hệ thống tự động nhận diện: Nếu độc giả $>60$ tuổi hoặc $<16$ tuổi thì phí gia hạn $= 0$ VNĐ; nếu là người lớn bình thường thì tính phí $20.000$ VNĐ.
   - Bấm gia hạn -> Ngày hết hạn của thẻ được cộng dồn thêm 1 năm.

### Kịch bản 5: Quản trị nhân viên & Thống kê doanh thu (Module Thủy - UC20, UC23)
1. Đăng nhập bằng tài khoản Quản lý: `admin@thuyloi.vn` / `admin123`.
2. Vào mục **Quản lý nhân viên**: Thêm mới 1 nhân viên thư viện -> Kiểm tra hệ thống tự động sinh mã nhân viên và cấp tài khoản đăng nhập tương ứng.
3. Vào mục **Báo cáo & Doanh thu**:
   - Chọn khoảng ngày từ đầu tháng đến cuối tháng -> Bấm **Kết xuất báo cáo**.
   - Kiểm tra các số liệu KPI: Tổng số thẻ cấp mới, tổng lượt mượn sách, cơ cấu doanh thu từ 3 nguồn (Tiền thẻ + Tiền gói mượn + Tiền phạt vi phạm).
   - Bấm nút **In báo cáo** để kiểm tra giao diện in ấn Print CSS.

---

## 8. Khắc phục lỗi thường gặp (Troubleshooting)

### 1. Lỗi `404 Not Found` khi bấm vào các đường link
- **Nguyên nhân:** Apache trên XAMPP chưa kích hoạt module đọc file `.htaccess` (`mod_rewrite`).
- **Cách sửa:**
  1. Mở file cấu hình Apache: `C:\xampp\apache\conf\httpd.conf`.
  2. Tìm dòng `#LoadModule rewrite_module modules/mod_rewrite.so` và xóa dấu `#` ở đầu dòng.
  3. Tìm khối `<Directory "C:/xampp/htdocs">` và sửa `AllowOverride None` thành `AllowOverride All`.
  4. Khởi động lại (Restart) Apache trên XAMPP.

### 2. Lỗi `Database connection error: Access denied for user 'root'@'localhost'`
- **Cách sửa:** Kiểm tra file `app/config/database.php`. Nếu MySQL của bạn có mật khẩu root, hãy điền chính xác vào `DB_PASS`.

### 3. Cảnh báo Git: `LF will be replaced by CRLF`
- Đây là cơ chế tự động chuyển đổi ký tự xuống dòng giữa Windows và Linux của Git, hoàn toàn không gây ảnh hưởng đến logic chương trình.
- Để tắt cảnh báo, gõ lệnh: `git config --global core.autocrlf false`.

---
**Nhóm 6 - Chúc thầy cô và các bạn kiểm thử hệ thống thành công!**
