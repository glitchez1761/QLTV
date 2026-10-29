<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="mb-4"><?= isset($item) ? 'Sửa nhân viên' : 'Thêm nhân viên' ?></h2>

        <form method="POST" action="<?= BASE_URL ?><?= isset($item) ? '/nhan-vien/update' : '/nhan-vien/store' ?>">
            <?php if (isset($item)): ?>
                <input type="hidden" name="MaNhanVien" value="<?= (int)$item['MaNhanVien'] ?>">
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
                    <label class="form-label">Chức vụ</label>
                    <input type="text" name="ChucVu" class="form-control" value="<?= htmlspecialchars((string)($item['ChucVu'] ?? '')) ?>" required>
                </div>
                <?php if (!isset($item)): ?>
                    <div class="col-md-6">
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" name="TenDangNhap" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="MatKhau" class="form-control" required>
                    </div>
                <?php else: ?>
                    <div class="col-md-12">
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" name="TenDangNhap" class="form-control" value="<?= htmlspecialchars((string)($item['TenDangNhap'] ?? '')) ?>" required>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="<?= BASE_URL ?>/nhan-vien" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>
