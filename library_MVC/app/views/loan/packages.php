<div class="mb-4"><h1 class="h3">Gói mượn sách</h1><p class="text-secondary">Chọn gói phù hợp để đăng ký quyền mượn tài liệu về nhà.</p></div>
<div class="row g-3">
<?php foreach (($packages ?? []) as $package): ?>
    <div class="col-md-6 col-xl-4"><div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h5"><?= htmlspecialchars($package['ten_goi'], ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="display-6 fw-bold text-primary"><?= number_format((float)$package['phi_nam'], 0, ',', '.') ?><small class="fs-6">đ</small></p>
            <ul class="text-secondary">
                <li>Tối đa <?= (int)$package['so_tai_lieu_toi_da'] ?> tài liệu</li>
                <li>Tổng giá trị tối đa <?= number_format((float)$package['tong_gia_tri_toi_da'], 0, ',', '.') ?>đ</li>
                <li>Thời hạn mượn <?= (int)$package['thoi_han_muon_ngay'] ?> ngày</li>
                <li>Hiệu lực <?= (int)$package['hieu_luc_thang'] ?> tháng</li>
            </ul>
            <?php if (!empty($cards)): ?>
                <form method="post" action="<?= BASE_URL ?>/packages/register">
                    <label class="form-label" for="card-<?= (int)$package['package_id'] ?>">Thẻ sử dụng</label>
                    <select id="card-<?= (int)$package['package_id'] ?>" name="card_id" class="form-select mb-2" required>
                        <?php foreach ($cards as $card): ?><option value="<?= (int)$card['card_id'] ?>"><?= htmlspecialchars($card['ma_the'], ENT_QUOTES, 'UTF-8') ?></option><?php endforeach; ?>
                    </select>
                    <input type="hidden" name="package_id" value="<?= (int)$package['package_id'] ?>">
                    <label class="form-label" for="payment-<?= (int)$package['package_id'] ?>">Thanh toán</label>
                    <select id="payment-<?= (int)$package['package_id'] ?>" name="payment_method" class="form-select mb-3">
                        <option value="TIEN_MAT">Tiền mặt</option><option value="QR">QR</option><option value="VI_DIEN_TU">Ví điện tử</option><option value="THE_NGAN_HANG">Thẻ ngân hàng</option>
                    </select>
                    <button class="btn btn-primary w-100">Đăng ký gói</button>
                </form>
            <?php else: ?><p class="small text-secondary mb-0">Đăng nhập bằng tài khoản độc giả đã liên kết thẻ để đăng ký.</p><?php endif; ?>
        </div>
    </div></div>
<?php endforeach; ?>
<?php if (empty($packages)): ?><div class="col-12"><div class="alert alert-info">Hiện chưa có gói mượn khả dụng.</div></div><?php endif; ?>
</div>
