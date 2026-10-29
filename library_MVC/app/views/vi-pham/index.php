<h2 class="mb-3"><?= isset($item) ? 'Sửa phiếu mượn' : 'Lập phiếu mượn' ?></h2>

<form method="POST" action="<?= BASE_URL ?><?= isset($item) ? '/phieu-muon/update' : '/phieu-muon/store' ?>">
    <?php if (isset($item)): ?>
        <input type="hidden" name="MaPhieuMuon" value="<?= (int)$item['MaPhieuMuon'] ?>">
    <?php endif; ?>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Độc giả</label>
            <select name="MaDocGia" class="form-select" required>
                <option value="">-- Chọn độc giả --</option>
                <?php foreach ($docGias as $docGia): ?>
                    <option value="<?= (int)$docGia['MaDocGia'] ?>" <?= (isset($item) && (int)$item['MaDocGia'] === (int)$docGia['MaDocGia']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$docGia['HoTen']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nhân viên</label>
            <select name="MaNhanVien" class="form-select" required>
                <option value="">-- Chọn nhân viên --</option>
                <?php foreach ($nhanViens as $nhanVien): ?>
                    <option value="<?= (int)$nhanVien['MaNhanVien'] ?>" <?= (isset($item) && (int)$item['MaNhanVien'] === (int)$nhanVien['MaNhanVien']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$nhanVien['HoTen']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Sách</label>
            <select name="MaSach" class="form-select" required>
                <option value="">-- Chọn sách --</option>
                <?php foreach ($sachs as $sach): ?>
                    <option value="<?= (int)$sach['MaSach'] ?>" <?= (isset($item) && (int)$item['MaSach'] === (int)$sach['MaSach']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$sach['TenSach']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Số lượng mượn</label>
            <input type="number" name="SoLuongMuon" class="form-control" min="1" value="<?= htmlspecialchars((string)($item['SoLuongMuon'] ?? 1)) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Ngày mượn</label>
            <input type="date" name="NgayMuon" class="form-control" value="<?= htmlspecialchars((string)($item['NgayMuon'] ?? date('Y-m-d'))) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Hạn trả</label>
            <input type="date" name="HanTra" class="form-control" value="<?= htmlspecialchars((string)($item['HanTra'] ?? '')) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Ngày trả</label>
            <input type="date" name="NgayTra" class="form-control" value="<?= htmlspecialchars((string)($item['NgayTra'] ?? '')) ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Trạng thái</label>
            <select name="TrangThai" class="form-select">
                <option value="Dang muon" <?= (isset($item) && ($item['TrangThai'] ?? '') === 'Dang muon') ? 'selected' : '' ?>>Đang mượn</option>
                <option value="Da tra" <?= (isset($item) && ($item['TrangThai'] ?? '') === 'Da tra') ? 'selected' : '' ?>>Đã trả</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="<?= BASE_URL ?>/phieu-muon" class="btn btn-secondary">Quay lại</a>
    </div>
</form>
