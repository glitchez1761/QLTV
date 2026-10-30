<?php $pageTitle = 'Quản lý sách'; require __DIR__ . '/../layouts/header.php'; ?>
<div class="page-header">
    <h2>Quản lý sách</h2>
    <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=add" class="btn btn-primary">+ Thêm sách</a>
</div>

<table class="table table-bordered table-striped shadow-sm bg-white">
    <thead class="table-dark">
        <tr>
            <th>Mã sách</th>
            <th>Tên sách</th>
            <th>Tác giả</th>
            <th>Nhà xuất bản</th>
            <th>Số lượng tồn</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['MaSach']) ?></td>
                <td><?= htmlspecialchars($book['TenSach']) ?></td>
                <td><?= htmlspecialchars($book['TacGia']) ?></td>
                <td><?= htmlspecialchars($book['NhaXuatBan']) ?></td>
                <td><?= htmlspecialchars($book['SoLuongTon']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=edit&id=<?= urlencode($book['MaSach']) ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=delete&id=<?= urlencode($book['MaSach']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
