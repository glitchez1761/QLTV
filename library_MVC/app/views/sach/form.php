<h2 class="mb-3">Quản lý sách</h2>
<a href="<?= BASE_URL ?>/sach/create" class="btn btn-primary mb-3">Thêm sách mới</a>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>Mã sách</th>
            <th>Tên sách</th>
            <th>Tác giả</th>
            <th>Thể loại</th>
            <th>NXB</th>
            <th>Năm</th>
            <th>Số lượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars((string)$item['MaSach']) ?></td>
                <td><?= htmlspecialchars((string)$item['TenSach']) ?></td>
                <td><?= htmlspecialchars((string)$item['TacGia']) ?></td>
                <td><?= htmlspecialchars((string)$item['TheLoai']) ?></td>
                <td><?= htmlspecialchars((string)($item['NhaXuatBan'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['NamXuatBan'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['SoLuong'] ?? 0)) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/sach/edit?id=<?= (int)$item['MaSach'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <form method="POST" action="<?= BASE_URL ?>/sach/delete" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                        <input type="hidden" name="id" value="<?= (int)$item['MaSach'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
