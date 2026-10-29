<div class="mb-3"><a href="<?= BASE_URL ?>/return" class="text-decoration-none">&larr; Danh sách đang mượn</a></div>
<div class="row justify-content-center"><div class="col-lg-7">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h3">Kiểm tra tình trạng tài liệu</h1>
        <?php if (!empty($loanItem)): ?>
            <p class="text-secondary"><?= htmlspecialchars($loanItem['ten_sach'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($loanItem['ma_tai_lieu'], ENT_QUOTES, 'UTF-8') ?></p>
            <form method="post" action="<?= BASE_URL ?>/return/process" data-confirm="Xác nhận hoàn tất thủ tục trả tài liệu này?">
                <input type="hidden" name="loan_detail_id" value="<?= (int)$loanItem['loan_detail_id'] ?>">
                <label class="form-label" for="condition">Tình trạng lúc nhận lại</label>
                <select id="condition" name="condition" class="form-select" required>
                    <option value="NGUYEN_VEN">Nguyên vẹn</option><option value="HU_HONG">Hư hỏng</option><option value="MAT">Mất tài liệu</option>
                </select>
                <p class="form-text">Nếu tài liệu bị hỏng hoặc mất, hệ thống tính phí bồi thường theo giá nhập và phí xử lý theo quy định.</p>
                <button class="btn btn-primary mt-2">Xác nhận trả sách</button>
            </form>
        <?php else: ?><div class="alert alert-warning">Không tìm thấy tài liệu đang mượn.</div><?php endif; ?>
    </div></div>
</div></div>
