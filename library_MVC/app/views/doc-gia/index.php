<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-3">Quản lý độc giả</h2>
    </div>
    <a href="<?= BASE_URL ?>/doc-gia/create" class="btn btn-primary">+ Thêm mới</a>
</div>

<table class="table table-bordered table-striped align-middle shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>Mã độc giả</th>
            <th>Họ tên</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>SĐT</th>
            <th>Ngày cấp thẻ</th>
            <th>Ngày hết hạn</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars((string)$item['MaDocGia']) ?></td>
                <td><?= htmlspecialchars((string)$item['HoTen']) ?></td>
                <td><?= htmlspecialchars((string)($item['NgaySinh'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['GioiTinh'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['SoDienThoai'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['NgayCapThe'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['NgayHetHan'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['TrangThaiThe'] ?? 'Con han')) ?></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/doc-gia/edit?id=<?= (int)$item['MaDocGia'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <form method="POST" action="<?= BASE_URL ?>/doc-gia/delete" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            <input type="hidden" name="id" value="<?= (int)$item['MaDocGia'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
