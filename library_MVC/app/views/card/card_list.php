<div class="d-flex justify-content-between align-items-center mb-3"><div><h1 class="h3 mb-1">Quản lý thẻ độc giả</h1><p class="text-secondary mb-0">Tìm, gia hạn hoặc hủy hiệu lực thẻ.</p></div></div>
<form method="get" action="<?= BASE_URL ?>/cards" class="row g-2 mb-3" data-card-search>
    <div class="col-sm-9"><label class="visually-hidden" for="card-keyword">Tìm độc giả</label><input id="card-keyword" class="form-control" name="keyword" value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Mã thẻ, tên hoặc điện thoại"></div>
    <div class="col-sm-3 d-grid"><button class="btn btn-outline-primary">Tìm thẻ</button></div>
</form>
<div class="table-responsive"><table class="table table-hover align-middle">
    <thead><tr><th>Mã thẻ</th><th>Độc giả</th><th>Liên hệ</th><th>Ngày hết hạn</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
    <tbody><?php foreach (($cards ?? []) as $card): ?><tr>
        <td><?= htmlspecialchars($card['ma_the'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($card['ho_ten'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($card['so_dien_thoai'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($card['ngay_het_han'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($card['trang_thai'], ENT_QUOTES, 'UTF-8') ?></td>
        <td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/cards/renew?id=<?= (int)$card['card_id'] ?>">Gia hạn</a>
            <?php if ($card['trang_thai'] !== 'BI_HUY'): ?><form class="d-inline" method="post" action="<?= BASE_URL ?>/cards/cancel" data-confirm="Xác nhận hủy thẻ này?"><input type="hidden" name="card_id" value="<?= (int)$card['card_id'] ?>"><input type="hidden" name="reason" value="Hủy tại quầy"><button class="btn btn-sm btn-outline-danger">Hủy</button></form><?php endif; ?>
        </td>
    </tr><?php endforeach; ?>
    <?php if (empty($cards)): ?><tr><td colspan="6" class="text-center text-secondary py-4">Không tìm thấy thẻ.</td></tr><?php endif; ?></tbody>
</table></div>
