<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-3">Quản lý phiếu mượn</h2>
    </div>
    <a href="<?= BASE_URL ?>/phieu-muon/create" class="btn btn-primary">+ Thêm mới</a>
</div>

<table class="table table-bordered table-striped align-middle shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>Mã phiếu</th>
            <th>Độc giả</th>
            <th>Nhân viên</th>
            <th>Sách</th>
            <th>Ngày mượn</th>
            <th>Hạn trả</th>
            <th>Ngày trả</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars((string)$item['MaPhieuMuon']) ?></td>
                <td><?= htmlspecialchars((string)($item['TenDocGia'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['TenNhanVien'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['TenSach'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['NgayMuon'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['HanTra'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['NgayTra'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['TrangThai'] ?? 'Dang muon')) ?></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/phieu-muon/edit?id=<?= (int)$item['MaPhieuMuon'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <form method="POST" action="<?= BASE_URL ?>/phieu-muon/delete" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            <input type="hidden" name="id" value="<?= (int)$item['MaPhieuMuon'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
