<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="mb-4"><?= isset($item) ? 'Sửa độc giả' : 'Thêm độc giả' ?></h2>

        <form method="POST" action="<?= BASE_URL ?><?= isset($item) ? '/doc-gia/update' : '/doc-gia/store' ?>">
            <?php if (isset($item)): ?>
                <input type="hidden" name="MaDocGia" value="<?= (int)$item['MaDocGia'] ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="HoTen" class="form-control" value="<?= htmlspecialchars((string)($item['HoTen'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars((string)($item['NgaySinh'] ?? '')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Giới tính</label>
                    <input type="text" name="GioiTinh" class="form-control" value="<?= htmlspecialchars((string)($item['GioiTinh'] ?? '')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="SoDienThoai" class="form-control" value="<?= htmlspecialchars((string)($item['SoDienThoai'] ?? '')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="DiaChi" class="form-control" value="<?= htmlspecialchars((string)($item['DiaChi'] ?? '')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars((string)($item['Email'] ?? '')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày cấp thẻ</label>
                    <input type="date" name="NgayCapThe" class="form-control" value="<?= htmlspecialchars((string)($item['NgayCapThe'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày hết hạn</label>
                    <input type="date" name="NgayHetHan" class="form-control" value="<?= htmlspecialchars((string)($item['NgayHetHan'] ?? '')) ?>" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Trạng thái thẻ</label>
                    <select name="TrangThaiThe" class="form-select">
                        <option value="Con han" <?= (isset($item) && ($item['TrangThaiThe'] ?? '') === 'Con han') ? 'selected' : '' ?>>Con hạn</option>
                        <option value="Het han" <?= (isset($item) && ($item['TrangThaiThe'] ?? '') === 'Het han') ? 'selected' : '' ?>>Hết hạn</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="<?= BASE_URL ?>/doc-gia" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>
