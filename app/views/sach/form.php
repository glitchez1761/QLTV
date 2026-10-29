<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($book) ? 'Sửa sách' : 'Thêm sách' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4"><?= isset($book) ? 'Sửa sách' : 'Thêm sách' ?></h2>

        <form method="POST" action="<?= BASE_URL ?>/public/index.php?controller=sach&action=<?= isset($book) ? 'update&id=' . urlencode($book['MaSach']) : 'store' ?>">
            <div class="mb-3">
                <label class="form-label">Mã sách</label>
                <input type="text" name="MaSach" class="form-control" value="<?= htmlspecialchars($book['MaSach'] ?? '') ?>" <?= isset($book) ? 'readonly' : 'required' ?>>
            </div>

            <div class="mb-3">
                <label class="form-label">Tên sách</label>
                <input type="text" name="TenSach" class="form-control" value="<?= htmlspecialchars($book['TenSach'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tác giả</label>
                <input type="text" name="TacGia" class="form-control" value="<?= htmlspecialchars($book['TacGia'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nhà xuất bản</label>
                <input type="text" name="NhaXuatBan" class="form-control" value="<?= htmlspecialchars($book['NhaXuatBan'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Số lượng tồn</label>
                <input type="number" name="SoLuongTon" class="form-control" value="<?= htmlspecialchars($book['SoLuongTon'] ?? 0) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($book) ? 'Cập nhật' : 'Lưu' ?></button>
            <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=index" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>
</html>
