<div class="d-flex justify-content-between align-items-center mb-3"><div><h1 class="h3 mb-1">Quản lý nhân viên</h1><p class="text-secondary mb-0">Tài khoản khởi tạo yêu cầu đổi mật khẩu ở lần đăng nhập đầu tiên.</p></div><a class="btn btn-primary" href="<?= BASE_URL ?>/admin/staff/create">Thêm nhân viên</a></div>
<div class="table-responsive"><table class="table table-hover align-middle">
    <thead><tr><th>Mã nhân viên</th><th>Họ tên</th><th>Email</th><th>Điện thoại</th><th>Chức vụ</th></tr></thead>
    <tbody><?php foreach (($staffList ?? []) as $staff): ?><tr>
        <td><?= htmlspecialchars($staff['ma_nv'], ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($staff['ho_ten'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($staff['email'], ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($staff['so_dien_thoai'] ?? '', ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($staff['chuc_vu'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    </tr><?php endforeach; ?>
    <?php if (empty($staffList)): ?><tr><td colspan="5" class="text-center text-secondary py-4">Chưa có nhân viên.</td></tr><?php endif; ?></tbody>
</table></div>
