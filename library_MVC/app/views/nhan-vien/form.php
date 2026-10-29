<h2 class="mb-3">Quản lý nhân viên</h2>
<a href="<?= BASE_URL ?>/nhan-vien/create" class="btn btn-primary mb-3">Thêm nhân viên</a>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>Mã NV</th>
            <th>Họ tên</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>SĐT</th>
            <th>Chức vụ</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars((string)$item['MaNhanVien']) ?></td>
                <td><?= htmlspecialchars((string)$item['HoTen']) ?></td>
                <td><?= htmlspecialchars((string)($item['NgaySinh'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['GioiTinh'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($item['SoDienThoai'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)$item['ChucVu']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/nhan-vien/edit?id=<?= (int)$item['MaNhanVien'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <form method="POST" action="<?= BASE_URL ?>/nhan-vien/delete" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                        <input type="hidden" name="id" value="<?= (int)$item['MaNhanVien'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
