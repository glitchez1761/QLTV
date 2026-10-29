<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3">Thông tin tài khoản</h1>
                <?php if (!empty($profile)): ?>
                    <dl class="row mt-4">
                        <dt class="col-sm-4">Họ tên</dt><dd class="col-sm-8"><?= htmlspecialchars($profile['ho_ten'] ?? '—', ENT_QUOTES, 'UTF-8') ?></dd>
                        <dt class="col-sm-4">Mã thẻ / nhân viên</dt><dd class="col-sm-8"><?= htmlspecialchars($profile['ma_the'] ?? $profile['ma_nv'] ?? '—', ENT_QUOTES, 'UTF-8') ?></dd>
                        <dt class="col-sm-4">Email</dt><dd class="col-sm-8"><?= htmlspecialchars($profile['email'] ?? '—', ENT_QUOTES, 'UTF-8') ?></dd>
                        <dt class="col-sm-4">Số điện thoại</dt><dd class="col-sm-8"><?= htmlspecialchars($profile['so_dien_thoai'] ?? '—', ENT_QUOTES, 'UTF-8') ?></dd>
                        <?php if (isset($profile['ngay_het_han'])): ?><dt class="col-sm-4">Thẻ hết hạn</dt><dd class="col-sm-8"><?= htmlspecialchars($profile['ngay_het_han'], ENT_QUOTES, 'UTF-8') ?></dd><?php endif; ?>
                    </dl>
                <?php else: ?>
                    <p class="text-secondary mt-3">Chưa có hồ sơ cá nhân được liên kết với tài khoản này.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
