<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="mb-4"><?= isset($item) ? 'Sửa biên bản vi phạm' : 'Tạo biên bản vi phạm' ?></h2>

        <form method="POST" action="<?= BASE_URL ?><?= isset($item) ? '/vi-pham/update' : '/vi-pham/store' ?>">
            <?php if (isset($item)): ?>
                <input type="hidden" name="MaBienBan" value="<?= (int)$item['MaBienBan'] ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Phiếu mượn</label>
                    <select name="MaPhieuMuon" class="form-select" required>
                        <option value="">-- Chọn phiếu mượn --</option>
                        <?php foreach ($phieuMuons as $phieuMuon): ?>
                            <option value="<?= (int)$phieuMuon['MaPhieuMuon'] ?>" <?= (isset($item) && (int)$item['MaPhieuMuon'] === (int)$phieuMuon['MaPhieuMuon']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$phieuMuon['MaPhieuMuon']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nhân viên lập</label>
                    <select name="MaNhanVien" class="form-select" required>
                        <option value="">-- Chọn nhân viên --</option>
                        <?php foreach ($nhanViens as $nhanVien): ?>
                            <option value="<?= (int)$nhanVien['MaNhanVien'] ?>" <?= (isset($item) && (int)$item['MaNhanVien'] === (int)$nhanVien['MaNhanVien']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$nhanVien['HoTen']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày lập</label>
                    <input type="date" name="NgayLap" class="form-control" value="<?= htmlspecialchars((string)($item['NgayLap'] ?? date('Y-m-d'))) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Loại vi phạm</label>
                    <input type="text" name="LoaiViPham" class="form-control" value="<?= htmlspecialchars((string)($item['LoaiViPham'] ?? '')) ?>" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Mô tả</label>
                    <textarea name="MoTa" class="form-control" rows="3"><?= htmlspecialchars((string)($item['MoTa'] ?? '')) ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tiền phạt</label>
                    <input type="number" step="0.01" name="TienPhat" class="form-control" value="<?= htmlspecialchars((string)($item['TienPhat'] ?? 0)) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Trạng thái</label>
                    <select name="TrangThai" class="form-select">
                        <option value="Chua xu ly" <?= (isset($item) && ($item['TrangThai'] ?? '') === 'Chua xu ly') ? 'selected' : '' ?>>Chưa xử lý</option>
                        <option value="Da xu ly" <?= (isset($item) && ($item['TrangThai'] ?? '') === 'Da xu ly') ? 'selected' : '' ?>>Đã xử lý</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="<?= BASE_URL ?>/vi-pham" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>
