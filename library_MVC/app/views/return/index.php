<div class="mb-4">
    <h1 class="h3 mb-1">Tiếp nhận trả tài liệu</h1>
    <p class="text-secondary">Tra cứu theo mã phiếu, mã thẻ, tên độc giả hoặc mã tài liệu.</p>
</div>
<form method="get" action="<?= BASE_URL ?>/return" class="row g-2 mb-4">
    <div class="col-md-9"><label class="visually-hidden" for="return-query">Thông tin tra cứu</label><input id="return-query" name="query" class="form-control" value="<?= htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Mã phiếu / mã thẻ / tên độc giả / mã tài liệu"></div>
    <div class="col-md-3 d-grid"><button class="btn btn-success">Tra cứu</button></div>
</form>
<?php if (($query ?? '') !== ''): ?>
    <div class="table-responsive"><table class="table table-hover align-middle">
        <thead><tr><th>Phiếu mượn</th><th>Độc giả / thẻ</th><th>Tài liệu</th><th>Hạn trả</th><th>Thao tác</th></tr></thead>
        <tbody>
        <?php foreach (($loanItems ?? []) as $item): ?><tr>
            <td><?= htmlspecialchars($item['ma_phieu_muon'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($item['ho_ten'], ENT_QUOTES, 'UTF-8') ?><br><small><?= htmlspecialchars($item['ma_the'], ENT_QUOTES, 'UTF-8') ?></small></td>
            <td><?= htmlspecialchars($item['ten_sach'], ENT_QUOTES, 'UTF-8') ?><br><small><?= htmlspecialchars($item['ma_tai_lieu'], ENT_QUOTES, 'UTF-8') ?></small></td>
            <td><?= htmlspecialchars($item['han_tra'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><a class="btn btn-sm btn-primary" href="<?= BASE_URL ?>/return/check?id=<?= (int)$item['loan_detail_id'] ?>">Tiếp nhận trả</a></td>
        </tr><?php endforeach; ?>
        <?php if (empty($loanItems)): ?><tr><td colspan="5" class="text-center text-secondary py-4">Không tìm thấy tài liệu đang mượn.</td></tr><?php endif; ?>
        </tbody>
    </table></div>
<?php endif; ?>
<p class="mt-4"><a href="<?= BASE_URL ?>/violations">Xem vi phạm chưa hoàn tất</a></p>
