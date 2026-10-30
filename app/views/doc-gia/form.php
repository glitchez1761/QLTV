<?php
$pageTitle = isset($book) ? 'Sửa sách' : 'Thêm sách';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Sách', 'url' => BASE_URL . '/public/index.php?controller=sach&action=index'],
    ['label' => isset($book) ? 'Sửa sách' : 'Thêm sách', 'url' => null],
];
require __DIR__ . '/../layouts/header.php';
?>
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="mb-4"><?= isset($book) ? 'Sửa sách' : 'Thêm sách' ?></h2>
        <form method="POST" action="<?= BASE_URL ?>/public/index.php?controller=sach&action=<?= isset($book) ? 'update&id=' . urlencode($book['MaSach']) : 'store' ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Mã sách</label>
                    <input type="text" name="MaSach" class="form-control" value="<?= htmlspecialchars($book['MaSach'] ?? '') ?>" <?= isset($book) ? 'readonly' : 'required' ?>>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tên sách</label>
                    <input type="text" name="TenSach" class="form-control" value="<?= htmlspecialchars($book['TenSach'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="TacGia" class="form-control" value="<?= htmlspecialchars($book['TacGia'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nhà xuất bản</label>
                    <input type="text" name="NhaXuatBan" class="form-control" value="<?= htmlspecialchars($book['NhaXuatBan'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số lượng tồn</label>
                    <input type="number" name="SoLuongTon" class="form-control" value="<?= htmlspecialchars($book['SoLuongTon'] ?? 0) ?>" required>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= isset($book) ? 'Cập nhật' : 'Lưu' ?></button>
                <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=index" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
