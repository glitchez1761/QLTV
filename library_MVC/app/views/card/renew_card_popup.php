<div class="row justify-content-center"><div class="col-lg-6">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h3">Gia hạn thẻ độc giả</h1>
        <?php if (!empty($card)): ?>
            <p class="text-secondary"><?= htmlspecialchars($card['ho_ten'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($card['ma_the'], ENT_QUOTES, 'UTF-8') ?></p>
            <p>Hạn hiện tại: <strong><?= htmlspecialchars($card['ngay_het_han'], ENT_QUOTES, 'UTF-8') ?></strong></p>
            <form method="post" action="<?= BASE_URL ?>/cards/renew" data-confirm="Xác nhận gia hạn thẻ thêm một năm?">
                <input type="hidden" name="card_id" value="<?= (int)$card['card_id'] ?>">
                <p class="form-text">Phí gia hạn được tính theo đối tượng độc giả và cấu hình hiện hành.</p>
                <button class="btn btn-primary">Gia hạn thêm 1 năm</button>
                <a class="btn btn-link" href="<?= BASE_URL ?>/cards">Quay lại</a>
            </form>
        <?php else: ?><div class="alert alert-warning">Không tìm thấy thẻ độc giả.</div><?php endif; ?>
    </div></div>
</div></div>
