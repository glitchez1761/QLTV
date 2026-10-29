<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sách</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Quản lý sách</h2>
            <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=add" class="btn btn-primary">Thêm sách</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
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
                            <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=delete&id=<?= urlencode($book['MaSach']) ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
