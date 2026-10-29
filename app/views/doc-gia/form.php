<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($reader) ? 'Sửa độc giả' : 'Thêm độc giả' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4"><?= isset($reader) ? 'Sửa độc giả' : 'Thêm độc giả' ?></h2>

        <form method="POST" action="<?= BASE_URL ?>/public/index.php?controller=docgia&action=<?= isset($reader) ? 'update&id=' . urlencode($reader['MaDocGia']) : 'store' ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="HoTen" class="form-control" value="<?= htmlspecialchars((string)($reader['HoTen'] ?? '')) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars((string)($reader['NgaySinh'] ?? '')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Giới tính</label>
                    <input type="text" name="GioiTinh" class="form-control" value="<?= htmlspecialchars((string)($reader['GioiTinh'] ?? '')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="SoDienThoai" class="form-control" value="<?= htmlspecialchars((string)($reader['SoDienThoai'] ?? '')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="DiaChi" class="form-control" value="<?= htmlspecialchars((string)($reader['DiaChi'] ?? '')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars((string)($reader['Email'] ?? '')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ngày cấp thẻ</label>
                    <input type="date" name="NgayCapThe" class="form-control" value="<?= htmlspecialchars((string)($reader['NgayCapThe'] ?? '')) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ngày hết hạn</label>
                    <input type="date" name="NgayHetHan" class="form-control" value="<?= htmlspecialchars((string)($reader['NgayHetHan'] ?? '')) ?>" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Trạng thái thẻ</label>
                    <select name="TrangThaiThe" class="form-select">
                        <option value="Con han" <?= (isset($reader) && ($reader['TrangThaiThe'] ?? '') === 'Con han') ? 'selected' : '' ?>>Con hạn</option>
                        <option value="Het han" <?= (isset($reader) && ($reader['TrangThaiThe'] ?? '') === 'Het han') ? 'selected' : '' ?>>Hết hạn</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= isset($reader) ? 'Cập nhật' : 'Lưu' ?></button>
                <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=index" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</body>
</html>
