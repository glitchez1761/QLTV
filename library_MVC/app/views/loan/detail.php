<div class="mb-3"><a href="<?= BASE_URL ?>/loans" class="text-decoration-none">&larr; Danh sách phiếu mượn</a></div>
<?php if (!empty($loan)): ?>
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
        <h1 class="h3"><?= htmlspecialchars($loan['ma_phieu_muon'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="mb-0">Độc giả: <strong><?= htmlspecialchars($loan['ho_ten'], ENT_QUOTES, 'UTF-8') ?></strong> &middot; Thẻ: <?= htmlspecialchars($loan['ma_the'], ENT_QUOTES, 'UTF-8') ?></p>
    </div></div>
    <div class="table-responsive"><table class="table table-striped">
        <thead><tr><th>Sách</th><th>Mã tài liệu</th><th>Hạn trả</th><th>Ngày trả</th><th>Trạng thái</th></tr></thead>
        <tbody><?php foreach (($details ?? []) as $detail): ?><tr>
            <td><?= htmlspecialchars($detail['ten_sach'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($detail['ma_tai_lieu'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($detail['han_tra'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($detail['ngay_tra'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($detail['trang_thai'], ENT_QUOTES, 'UTF-8') ?></td>
        </tr><?php endforeach; ?></tbody>
    </table></div>
<?php else: ?><div class="alert alert-warning">Không tìm thấy phiếu mượn.</div><?php endif; ?>
