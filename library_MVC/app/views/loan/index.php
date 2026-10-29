<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div><h1 class="h3 mb-1">Phiếu mượn đang mở</h1><p class="text-secondary mb-0">Tra cứu các tài liệu chưa được trả.</p></div>
</div>
<form class="row g-2 mb-3" method="get" action="<?= BASE_URL ?>/loans">
    <div class="col-sm-9"><label class="visually-hidden" for="loan-keyword">Tìm theo độc giả, mã thẻ hoặc sách</label><input id="loan-keyword" name="keyword" value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control" placeholder="Tên độc giả, mã thẻ, mã phiếu hoặc mã tài liệu"></div>
    <div class="col-sm-3 d-grid"><button class="btn btn-outline-primary">Tìm phiếu mượn</button></div>
</form>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead><tr><th>Phiếu mượn</th><th>Độc giả / thẻ</th><th>Tài liệu</th><th>Hạn trả</th><th>Trạng thái</th><th></th></tr></thead>
        <tbody>
        <?php foreach (($loans ?? []) as $loan): ?>
            <tr>
                <td><?= htmlspecialchars($loan['ma_phieu_muon'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($loan['ho_ten'], ENT_QUOTES, 'UTF-8') ?><br><small><?= htmlspecialchars($loan['ma_the'], ENT_QUOTES, 'UTF-8') ?></small></td>
                <td><?= htmlspecialchars($loan['ten_sach'], ENT_QUOTES, 'UTF-8') ?><br><small><?= htmlspecialchars($loan['ma_tai_lieu'], ENT_QUOTES, 'UTF-8') ?></small></td>
                <td><?= htmlspecialchars($loan['han_tra'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><span class="badge text-bg-<?= $loan['han_tra'] < date('Y-m-d') ? 'danger' : 'success' ?>"><?= $loan['han_tra'] < date('Y-m-d') ? 'Quá hạn' : 'Đang mượn' ?></span></td>
                <td><?php if ((int)$loan['so_lan_gia_han'] < 1 && $loan['han_tra'] >= date('Y-m-d')): ?><form method="post" action="<?= BASE_URL ?>/loan/renew" data-confirm="Gia hạn tài liệu này thêm 30 ngày?"><input type="hidden" name="loan_detail_id" value="<?= (int)$loan['loan_detail_id'] ?>"><button class="btn btn-sm btn-outline-primary">Gia hạn</button></form><?php endif; ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($loans)): ?><tr><td colspan="6" class="text-center text-secondary py-4">Không có phiếu mượn phù hợp.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
