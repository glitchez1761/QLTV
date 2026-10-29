<h2 class="mb-3">Quản lý biên bản vi phạm</h2>
<a href="<?= BASE_URL ?>/vi-pham/create" class="btn btn-primary mb-3">Tạo biên bản</a>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>Mã biên bản</th>
            <th>Phiếu mượn</th>
            <th>Nhân viên</th>
            <th>Ngày lập</th>
            <th>Loại vi phạm</th>
            <th>Tiền phạt</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars((string)$item['MaBienBan']) ?></td>
                <td><?= htmlspecialchars((string)($item['MaPhieuMuon'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['TenNhanVien'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['NgayLap'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['LoaiViPham'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['TienPhat'] ?? 0)) ?></td>
                <td><?= htmlspecialchars((string)($item['TrangThai'] ?? 'Chua xu ly')) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/vi-pham/edit?id=<?= (int)$item['MaBienBan'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <form method="POST" action="<?= BASE_URL ?>/vi-pham/delete" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                        <input type="hidden" name="id" value="<?= (int)$item['MaBienBan'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
