<?php $pageTitle = 'Quản lý độc giả'; require __DIR__ . '/../layouts/header.php'; ?>
<div class="page-header">
    <h2>Quản lý độc giả</h2>
    <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=add" class="btn btn-primary">+ Thêm mới</a>
</div>

<table class="table table-bordered table-striped align-middle shadow-sm bg-white">
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
        <?php foreach ($readers as $reader): ?>
            <tr>
                <td><?= htmlspecialchars((string)$reader['MaDocGia']) ?></td>
                <td><?= htmlspecialchars((string)($reader['HoTen'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($reader['NgaySinh'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($reader['GioiTinh'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($reader['SoDienThoai'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($reader['NgayCapThe'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($reader['NgayHetHan'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($reader['TrangThaiThe'] ?? 'Con han')) ?></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=edit&id=<?= (int)$reader['MaDocGia'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=delete&id=<?= (int)$reader['MaDocGia'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
