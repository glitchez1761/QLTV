<?php
$pageTitle = isset($book) ? 'Sửa sách' : 'Thêm sách';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Sách', 'url' => BASE_URL . '/public/index.php?controller=sach&action=index'],
    ['label' => isset($book) ? 'Sửa sách' : 'Thêm sách', 'url' => null],
];
require __DIR__ . '/../layouts/header.php';
?>
<div class="form-panel">
    <div class="page-header mb-4">
        <h2><?= isset($book) ? '✏️ Sửa sách' : '📚 Thêm sách' ?></h2>
    </div>
    <form method="POST" action="<?= BASE_URL ?>/public/index.php?controller=sach&action=<?= isset($book) ? 'update&id=' . urlencode($book['MaSach']) : 'store' ?>">
        <div class="field-grid">
            <div>
                <label class="form-label">Mã sách</label>
                <input type="text" name="MaSach" class="form-control" value="<?= htmlspecialchars($book['MaSach'] ?? '') ?>" <?= isset($book) ? 'readonly' : 'required' ?>>
            </div>
            <div>
                <label class="form-label">Tên sách</label>
                <input type="text" name="TenSach" class="form-control" value="<?= htmlspecialchars($book['TenSach'] ?? '') ?>" required>
            </div>
            <div>
                <label class="form-label">Tác giả</label>
                <input type="text" name="TacGia" class="form-control" value="<?= htmlspecialchars($book['TacGia'] ?? '') ?>" required>
            </div>
            <div>
                <label class="form-label">Nhà xuất bản</label>
                <input type="text" name="NhaXuatBan" class="form-control" value="<?= htmlspecialchars($book['NhaXuatBan'] ?? '') ?>" required>
            </div>
            <div>
                <label class="form-label">Số lượng tồn</label>
                <input type="number" name="SoLuongTon" class="form-control" value="<?= htmlspecialchars($book['SoLuongTon'] ?? 0) ?>" required>
            </div>
            <div>
                <label class="form-label">Trạng thái</label>
                <select class="form-select" name="TrangThai">
                    <option value="Còn" selected>Còn</option>
                    <option value="Hết">Hết</option>
                </select>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2 flex-wrap">
            <button type="submit" class="btn btn-primary action-btn"><?= isset($book) ? '💾 Cập nhật' : '💾 Lưu sách' ?></button>
            <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=index" class="btn btn-secondary action-btn">↩️ Quay lại</a>
        </div>
    </form>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
