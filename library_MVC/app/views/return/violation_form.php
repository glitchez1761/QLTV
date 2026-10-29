<?php if (isset($violations)): ?>
<div class="mb-3"><a href="<?= BASE_URL ?>/return" class="text-decoration-none">&larr; Tiếp nhận trả sách</a></div>
<h1 class="h3 mb-3">Vi phạm chưa hoàn tất</h1>
<div class="table-responsive"><table class="table table-hover align-middle">
    <thead><tr><th>Độc giả</th><th>Sách / mã tài liệu</th><th>Loại vi phạm</th><th>Tiền cần thu</th><th>Thao tác</th></tr></thead>
    <tbody><?php foreach ($violations as $item): ?><tr>
        <td><?= htmlspecialchars($item['ho_ten'], ENT_QUOTES, 'UTF-8') ?><br><small><?= htmlspecialchars($item['ma_the'], ENT_QUOTES, 'UTF-8') ?></small></td>
        <td><?= htmlspecialchars($item['ten_sach'], ENT_QUOTES, 'UTF-8') ?><br><small><?= htmlspecialchars($item['ma_tai_lieu'], ENT_QUOTES, 'UTF-8') ?></small></td>
        <td><?= htmlspecialchars($item['loai_vi_pham'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= number_format((float)$item['tong_tien'], 0, ',', '.') ?>đ</td>
        <td><a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/violations/detail?id=<?= (int)$item['violation_id'] ?>">Chi tiết / thu phí</a></td>
    </tr><?php endforeach; ?>
    <?php if (empty($violations)): ?><tr><td colspan="5" class="text-center text-secondary py-4">Không có vi phạm chưa hoàn tất.</td></tr><?php endif; ?></tbody>
</table></div>
<?php else: ?>
<div class="mb-3"><a href="<?= BASE_URL ?>/violations" class="text-decoration-none">&larr; Danh sách vi phạm</a></div>
<h1 class="h3 mb-3">Chi tiết vi phạm</h1>
<?php if (!empty($violation)): ?>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <p><strong>Độc giả:</strong> <?= htmlspecialchars($violation['ho_ten'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Tài liệu:</strong> <?= htmlspecialchars($violation['ten_sach'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($violation['ma_tai_lieu'], ENT_QUOTES, 'UTF-8') ?>)</p>
        <p><strong>Loại:</strong> <?= htmlspecialchars($violation['loai_vi_pham'], ENT_QUOTES, 'UTF-8') ?> · <strong>Ngày quá hạn:</strong> <?= (int)$violation['so_ngay_qua_han'] ?></p>
        <p><strong>Tiền phạt:</strong> <?= number_format((float)$violation['tien_phat'], 0, ',', '.') ?>đ</p>
        <p><strong>Bồi thường:</strong> <?= number_format((float)$violation['tien_boi_thuong'], 0, ',', '.') ?>đ · <strong>Phí xử lý:</strong> <?= number_format((float)$violation['chi_phi_xu_ly'], 0, ',', '.') ?>đ</p>
        <p class="fs-5"><strong>Tổng cộng:</strong> <?= number_format((float)$violation['tong_tien'], 0, ',', '.') ?>đ</p>
        <?php if ($violation['trang_thai'] !== 'DA_XU_LY'): ?>
            <form method="post" action="<?= BASE_URL ?>/violations/pay" data-confirm="Xác nhận đã thu tiền và hoàn tất vi phạm?">
                <input type="hidden" name="violation_id" value="<?= (int)$violation['violation_id'] ?>">
                <button class="btn btn-success">Xác nhận đã thanh toán</button>
            </form>
        <?php else: ?><span class="badge text-bg-success">Đã xử lý</span><?php endif; ?>
    </div></div>
<?php else: ?><div class="alert alert-warning">Không tìm thấy vi phạm.</div><?php endif; ?>
<?php endif; ?>
