# 🏥 Hospital Management — PHP MVC

Ứng dụng quản lý bệnh nhân xây dựng theo kiến trúc **MVC (Model - View - Controller)** thuần PHP, không sử dụng framework. Đây là dự án học tập giúp hiểu rõ cách tổ chức code theo mô hình MVC, phân tách trách nhiệm giữa các lớp và tương tác với cơ sở dữ liệu MySQL thông qua PDO.

---

## 📋 Mục lục

- [Tổng quan](#-tổng-quan)
- [Cấu trúc thư mục](#-cấu-trúc-thư-mục)
- [Mô tả chi tiết từng file](#-mô-tả-chi-tiết-từng-file)
- [Luồng hoạt động](#-luồng-hoạt-động)
- [Cơ sở dữ liệu](#-cơ-sở-dữ-liệu)
- [Cấu hình & Cài đặt](#-cấu-hình--cài-đặt)
- [Tính năng](#-tính-năng)
- [Công nghệ sử dụng](#-công-nghệ-sử-dụng)

---

## 🗺 Tổng quan

```
Browser ──► public/index.php ──► Controller ──► Service ──► Model ──► Database
                                     │
                                     └──► View (HTML)
```

Ứng dụng hoạt động theo mô hình **Front Controller**: mọi request đều đi qua một điểm vào duy nhất là `public/index.php`, từ đó điều phối đến đúng Controller → Service → Model → View.

---

## 📁 Cấu trúc thư mục

```
PHPMVC/
│
├── public/                         # 🌐 Thư mục web gốc (document root)
│   ├── index.php                   # Entry point — điểm vào duy nhất của ứng dụng
│   ├── css/                        # (trống) CSS tùy chỉnh
│   └── js/                         # (trống) JavaScript tùy chỉnh
│
└── app/                            # 🔒 Thư mục ứng dụng (không public trực tiếp)
    │
    ├── config/
    │   └── config.php              # Cấu hình toàn cục (DB, domain, path)
    │
    ├── libs/
    │   └── DbConnection.php        # Thư viện kết nối database (PDO)
    │
    ├── models/
    │   └── Patient.php             # Model: đại diện cho đối tượng bệnh nhân
    │
    ├── services/
    │   └── PatientService.php      # Service: xử lý nghiệp vụ & truy vấn DB
    │
    ├── controllers/
    │   └── HomeController.php      # Controller: điều phối request trang chủ
    │
    └── views/
        ├── home/
        │   └── index.php           # View: danh sách bệnh nhân
        └── patient/
            ├── add.php             # View: form thêm bệnh nhân
            ├── edit.php            # View: (đang phát triển) sửa bệnh nhân
            └── delete.php          # View: (đang phát triển) xóa bệnh nhân
```

---

## 📄 Mô tả chi tiết từng file

### ⚙️ `public/index.php` — Entry Point (Front Controller)

> Điểm vào duy nhất của toàn bộ ứng dụng.

```php
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action'])     ? $_GET['action']     : 'index';
```

- Load file cấu hình và thư viện kết nối DB.
- Đọc tham số `controller` và `action` từ URL query string.
- Dựa vào `controller`, nạp và khởi tạo đúng Controller tương ứng.
- Gọi method `index()` của Controller đã chọn.

| URL                             | controller        | action  | Kết quả                   |
| ------------------------------- | ----------------- | ------- | ------------------------- |
| `/index.php`                    | `home` (mặc định) | `index` | Trang danh sách bệnh nhân |
| `/index.php?controller=patient` | `patient`         | `index` | Trang quản lý patient     |

---

### ⚙️ `app/config/config.php` — Cấu hình toàn cục

Định nghĩa các hằng số dùng toàn ứng dụng:

| Hằng số    | Giá trị                     | Mô tả                                 |
| ---------- | --------------------------- | ------------------------------------- |
| `APP_ROOT` | đường dẫn tuyệt đối gốc     | Đường dẫn gốc của project trên server |
| `DOMAIN`   | `https://localhost/PHPMVC/` | URL domain để tạo các link trong view |
| `DB_HOST`  | `localhost`                 | Host database                         |
| `DB_USER`  | `root`                      | Tên đăng nhập MySQL                   |
| `DB_PASS`  | `` (rỗng)                   | Mật khẩu MySQL                        |
| `DB_NAME`  | `testdb`                    | Tên database                          |

> ⚠️ **Lưu ý bảo mật**: Trong môi trường production, không để thông tin database hardcode trong file này. Nên dùng biến môi trường `.env`.

---

### 🔌 `app/libs/DbConnection.php` — Kết nối Database

Class `DbConnection` đóng gói việc khởi tạo kết nối PDO:

```
DbConnection
  ├── __construct()    → Lấy config từ hằng số, tạo kết nối PDO (MySQL)
  └── getConnection()  → Trả về đối tượng PDO connection
```

- Sử dụng `PDO` (PHP Data Objects) thay vì `mysqli` — an toàn hơn, hỗ trợ Prepared Statements.
- Bắt lỗi `PDOException`, nếu kết nối thất bại thì `$conn = null` (không crash app).

---

### 📦 `app/models/Patient.php` — Model Bệnh nhân

Class `Patient` đại diện cho một bệnh nhân trong hệ thống:

| Thuộc tính  | Kiểu    | Mô tả              |
| ----------- | ------- | ------------------ |
| `$id`       | private | ID bệnh nhân       |
| `$fullname` | private | Họ tên đầy đủ      |
| `$gender`   | private | Giới tính (Nam/Nữ) |

**Các phương thức:**

- `getId()` — Lấy ID
- `getFullName()` — Lấy họ tên
- `getGender()` — Lấy giới tính
- `setFullName($fullname)` — Cập nhật họ tên

> Model thuần túy, chỉ lưu trữ dữ liệu. Không chứa logic truy vấn DB.

---

### 🛠 `app/services/PatientService.php` — Lớp Service

Class `PatientService` chứa toàn bộ logic nghiệp vụ liên quan đến bệnh nhân:

**`getAllPatiens()`** — Lấy toàn bộ danh sách bệnh nhân:

1. Khởi tạo `DbConnection` và lấy kết nối.
2. Thực thi câu lệnh `SELECT * FROM patients`.
3. Với mỗi dòng kết quả, tạo đối tượng `Patient` mới.
4. Trả về mảng các đối tượng `Patient`.

> **Lưu ý**: Có typo nhỏ trong tên method — `getAllPatiens()` (thiếu chữ "t"). Trong thực tế nên là `getAllPatients()`.

---

### 🎮 `app/controllers/HomeController.php` — Controller Trang chủ

Class `HomeController` xử lý các request đến trang chủ:

**`index()`**:

1. Khởi tạo `PatientService`.
2. Gọi `getAllPatiens()` để lấy danh sách bệnh nhân.
3. `include` file view `views/home/index.php` (biến `$patients` tự động truyền sang view).

---

### 🖼 Views — Giao diện người dùng

#### `app/views/home/index.php`

- Trang chủ hiển thị **bảng danh sách bệnh nhân**.
- Sử dụng Bootstrap 5.3.8 và Bootstrap Icons.
- Lặp qua mảng `$patients` để render từng hàng trong table.
- Có nút **Thêm mới**, icon **Sửa** và **Xóa** cho mỗi bệnh nhân.

#### `app/views/patient/add.php`

- Form **thêm bệnh nhân mới** với 2 trường: Họ tên và Giới tính.
- Sử dụng Bootstrap 5.3.8.
- ⚠️ Form chưa có `action` thực sự xử lý — đang phát triển.

#### `app/views/patient/edit.php`

- ⚠️ Đang phát triển — chỉ in ra chữ `"edit"`.

#### `app/views/patient/delete.php`

- ⚠️ Đang phát triển — chỉ in ra chữ `"delete"`.

---

## 🔄 Luồng hoạt động

### Luồng đọc dữ liệu (GET — Xem danh sách bệnh nhân)

```
1. Trình duyệt gửi request:
   GET https://localhost/PHPMVC/public/index.php

2. public/index.php
   ├── require_once config.php        → Nạp hằng số cấu hình
   ├── require_once DbConnection.php  → Nạp thư viện DB
   ├── Đọc $_GET['controller'] = 'home' (mặc định)
   └── require_once HomeController.php

3. HomeController::index()
   └── Khởi tạo PatientService

4. PatientService::getAllPatiens()
   ├── new DbConnection()             → Kết nối MySQL qua PDO
   ├── SELECT * FROM patients         → Truy vấn DB
   ├── foreach row → new Patient()    → Tạo object từ từng record
   └── return $patients[]             → Trả về mảng Patient

5. HomeController::index()
   └── include views/home/index.php  → Render HTML với $patients

6. Trình duyệt nhận HTML
   └── Hiển thị bảng danh sách bệnh nhân
```

### Sơ đồ kiến trúc tổng thể

```
┌──────────────┐     GET request      ┌─────────────────────┐
│   Browser    │ ─────────────────►   │  public/index.php   │
│              │ ◄─────────────────   │  (Front Controller) │
└──────────────┘      HTML response   └──────────┬──────────┘
                                                  │ route theo ?controller=
                                                  ▼
                                      ┌─────────────────────┐
                                      │   HomeController    │
                                      │   .index()          │
                                      └──────────┬──────────┘
                                                  │ gọi Service
                                                  ▼
                                      ┌─────────────────────┐
                                      │   PatientService    │
                                      │   .getAllPatiens()  │
                                      └──────────┬──────────┘
                                                  │ tạo đối tượng
                                       ┌──────────┴──────────┐
                                       ▼                     ▼
                           ┌────────────────┐   ┌────────────────────┐
                           │  DbConnection  │   │  Patient (Model)   │
                           │  (PDO/MySQL)   │   │  id, fullname,     │
                           └────────────────┘   │  gender            │
                                                 └────────────────────┘
                                                  │ trả về $patients[]
                                                  ▼
                                      ┌─────────────────────┐
                                      │  views/home/        │
                                      │  index.php (HTML)   │
                                      └─────────────────────┘
```

---

### Luồng khi bấm nút **"Thêm mới"** (Add)

> ⚠️ Hiện tại form UI đã có, nhưng backend xử lý chưa hoàn thiện. Dưới đây là luồng **dự kiến** khi hoàn chỉnh.

```
1. Người dùng bấm nút "Thêm mới" trên trang danh sách
   └── Trình duyệt chuyển đến:
       GET /app/views/patient/add.php
       (⚠️ hiện tại link trỏ thẳng vào view, chưa qua Controller)

2. Hiển thị form thêm bệnh nhân (add.php)
   ├── Trường: Họ tên  (input text)
   └── Trường: Giới tính (select: Nam / Nữ)

3. Người dùng điền form → bấm nút "Thêm"
   └── Trình duyệt gửi:
       POST /index.php?controller=patient&action=add
       Body: name=...&gender=...

4. public/index.php
   └── $controller = 'patient' → require PatientController.php

5. PatientController::add()
   ├── Đọc $_POST['name'], $_POST['gender']
   ├── Validate dữ liệu đầu vào
   └── Gọi PatientService::addPatient($name, $gender)

6. PatientService::addPatient()
   ├── new DbConnection()               → Kết nối DB
   ├── INSERT INTO patients (name, gender) VALUES (?, ?)
   └── header('Location: /index.php')

8. Trình duyệt tải lại trang danh sách
   └── Bệnh nhân mới xuất hiện trong bảng
```

---

### Luồng khi bấm icon **"Sửa"** (Edit)

> ⚠️ View `edit.php` hiện chỉ in ra chữ `"edit"`. Dưới đây là luồng **dự kiến** khi hoàn chỉnh.

```
1. Người dùng bấm icon ✏️ trên hàng bệnh nhân
   └── Trình duyệt chuyển đến:
       GET /app/views/patient/edit.php?id={id}
       (⚠️ hiện tại link trỏ thẳng vào view, chưa qua Controller)

── Luồng đúng (dự kiến) ──────────────────────────────────────────

Bước 1 — Hiển thị form chỉnh sửa:
   GET /index.php?controller=patient&action=edit&id={id}
   └── PatientController::edit()
       ├── Đọc $_GET['id']
       ├── PatientService::getPatientById($id)
       │     ├── SELECT * FROM patients WHERE id = ?
       │     └── return Patient object
       └── include views/patient/edit.php  → Form điền sẵn dữ liệu cũ

Bước 2 — Người dùng sửa và submit:
   POST /index.php?controller=patient&action=edit&id={id}
   └── PatientController::edit()
       ├── Đọc $_POST['name'], $_POST['gender']
       ├── PatientService::updatePatient($id, $name, $gender)
       │     ├── UPDATE patients SET name=?, gender=? WHERE id=?
       │     └── return true/false
       └── Redirect về trang danh sách
```

---

### Luồng khi bấm icon **"Xóa"** (Delete)

> ⚠️ View `delete.php` hiện chỉ in ra chữ `"delete"`. Dưới đây là luồng **dự kiến** khi hoàn chỉnh.

```
1. Người dùng bấm icon 🗑️ trên hàng bệnh nhân
   └── Trình duyệt chuyển đến:
       GET /app/views/patient/delete.php?id={id}
       (⚠️ hiện tại link trỏ thẳng vào view, chưa qua Controller)

── Luồng đúng (dự kiến) ──────────────────────────────────────────

   GET /index.php?controller=patient&action=delete&id={id}
   └── PatientController::delete()
       ├── Đọc $_GET['id']
       ├── (Tùy chọn) Hiển thị popup xác nhận "Bạn có chắc muốn xóa?"
       ├── PatientService::deletePatient($id)
       │     ├── DELETE FROM patients WHERE id = ?
       │     └── return true/false
       └── Redirect về trang danh sách

2. Trình duyệt tải lại trang danh sách
   └── Bệnh nhân đã bị xóa khỏi bảng
```

---

### Tổng hợp tất cả luồng

````
                         ┌──────────────────────────┐
                         │   views/home/index.php    │
                         │   (Danh sách bệnh nhân)   │
                         └────────────┬─────────────┘
                                      │
              ┌───────────────────────┼───────────────────────┐
              │                       │                       │
        [Thêm mới]               [✏️ Sửa]                [🗑️ Xóa]
              │                       │                       │
              ▼                       ▼                       ▼
   GET ?controller=patient  GET ?controller=patient  GET ?controller=patient
     &action=add              &action=edit&id={id}     &action=delete&id={id}
              │                       │                       │
              ▼                       ▼                       ▼
   PatientController        PatientController        PatientController
     ::add()                  ::edit()                 ::delete()
              │                       │                       │
              ▼                       ▼                       ▼
   PatientService           PatientService           PatientService
   ::addPatient()           ::updatePatient()        ::deletePatient()
              │                       │                       │
              ▼                       ▼                       ▼
        INSERT INTO           UPDATE patients          DELETE FROM
          patients              WHERE id=?               patients
                                                        WHERE id=?
              │                       │                       │
              └───────────────────────┴───────────────────────┘
                                      │
                                      ▼
                         Redirect → index.php
                         (Danh sách bệnh nhân cập nhật)
``` Trả về true/false (thành công / thất bại)

7. PatientController::add()
   └── Redirect về trang danh sách:


---

## 🗄 Cơ sở dữ liệu

### Thông tin kết nối

| Thông số | Giá trị |
|---------|---------|
| Host | `localhost` |
| Database | `testdb` |
| User | `root` |
| Password | _(rỗng)_ |

### Bảng `patients`

Dựa theo code trong `PatientService.php`, bảng cần có cấu trúc:

```sql
CREATE DATABASE IF NOT EXISTS testdb;

USE testdb;

CREATE TABLE patients (
    id      INT          AUTO_INCREMENT PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    gender  VARCHAR(10)  NOT NULL
);

-- Dữ liệu mẫu
INSERT INTO patients (name, gender) VALUES
    ('Nguyen Van An', 'Nam'),
    ('Tran Thi Binh', 'Nu'),
    ('Le Minh Cuong', 'Nam');
````

---

## 🚀 Cấu hình & Cài đặt

### Yêu cầu hệ thống

- **PHP** >= 7.4 (hỗ trợ PDO)
- **MySQL** >= 5.7 hoặc **MariaDB** >= 10.3
- **Web Server**: Apache (XAMPP/WAMP) hoặc Nginx

### Các bước cài đặt

1. **Copy project** vào thư mục web server:

   ```
   C:\xampp\htdocs\PHPMVC\
   ```

2. **Tạo database** theo script SQL ở mục trên.

3. **Cập nhật cấu hình** trong `app/config/config.php`:

   ```php
   define('DOMAIN', 'http://localhost/PHPMVC/');
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');       // Thay bằng mật khẩu thực tế
   define('DB_NAME', 'testdb');
   ```

4. **Truy cập ứng dụng** qua trình duyệt:
   ```
   http://localhost/PHPMVC/public/index.php
   ```

---

## ✅ Tính năng

| Tính năng                | Trạng thái                        |
| ------------------------ | --------------------------------- |
| Xem danh sách bệnh nhân  | ✅ Hoàn thành                     |
| Thêm bệnh nhân (form UI) | 🔶 UI xong, chưa có xử lý backend |
| Sửa bệnh nhân            | 🚧 Đang phát triển                |
| Xóa bệnh nhân            | 🚧 Đang phát triển                |
| Xác thực dữ liệu đầu vào | ❌ Chưa có                        |
| Phân quyền / Đăng nhập   | ❌ Chưa có                        |

---

## 🛠 Công nghệ sử dụng

| Công nghệ       | Phiên bản | Mục đích                          |
| --------------- | --------- | --------------------------------- |
| PHP             | >= 7.4    | Ngôn ngữ backend chính            |
| PDO             | Built-in  | Kết nối và truy vấn MySQL an toàn |
| MySQL           | >= 5.7    | Cơ sở dữ liệu                     |
| Bootstrap       | 5.3.8     | Framework CSS giao diện           |
| Bootstrap Icons | 1.13.1    | Bộ icon SVG                       |

---

## 💡 Những điểm cần cải thiện

1. **Typo**: `getAllPatiens()` nên sửa thành `getAllPatients()`.
2. **PatientController**: được tham chiếu trong `index.php` nhưng **chưa được tạo**.
3. **Chức năng Add/Edit/Delete**: Form UI đã có nhưng chưa có xử lý phía backend.
4. **Bảo mật**: Nên dùng Prepared Statements cho các câu lệnh INSERT/UPDATE/DELETE.
5. **Autoloader**: Có thể dùng `spl_autoload_register()` hoặc Composer PSR-4 thay vì `require_once` thủ công.
6. **Tách `.env`**: Thông tin kết nối DB không nên hardcode trong `config.php`.

---

> 📌 **Ghi chú**: Đây là dự án học tập nhằm hiểu rõ kiến trúc MVC trong PHP thuần. Không khuyến khích dùng trực tiếp trong môi trường production mà không bổ sung các lớp bảo mật.
