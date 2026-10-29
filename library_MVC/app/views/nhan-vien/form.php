<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="mb-4"><?= isset($item) ? 'Sửa sách' : 'Thêm sách mới' ?></h2>

        <form method="POST" action="<?= BASE_URL ?><?= isset($item) ? '/sach/update' : '/sach/store' ?>">
            <?php if (isset($item)): ?>
                <input type="hidden" name="MaSach" value="<?= (int)$item['MaSach'] ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tên sách</label>
                    <input type="text" name="TenSach" class="form-control" value="<?= htmlspecialchars((string)($item['TenSach'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="TacGia" class="form-control" value="<?= htmlspecialchars((string)($item['TacGia'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Thể loại</label>
                    <input type="text" name="TheLoai" class="form-control" value="<?= htmlspecialchars((string)($item['TheLoai'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nhà xuất bản</label>
                    <input type="text" name="NhaXuatBan" class="form-control" value="<?= htmlspecialchars((string)($item['NhaXuatBan'] ?? '')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Năm xuất bản</label>
                    <input type="number" name="NamXuatBan" class="form-control" value="<?= htmlspecialchars((string)($item['NamXuatBan'] ?? '')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="SoLuong" class="form-control" min="0" value="<?= htmlspecialchars((string)($item['SoLuong'] ?? 0)) ?>" required>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="<?= BASE_URL ?>/sach" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>
