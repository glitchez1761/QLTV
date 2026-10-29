<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div><h1 class="h3 mb-1">Phiếu nhắc nhở quá hạn</h1><p class="text-secondary mb-0">Danh sách các đợt quét tài liệu quá hạn.</p></div>
    <form method="post" action="<?= BASE_URL ?>/reminders/scan"><button class="btn btn-outline-primary">Quét quá hạn ngay</button></form>
</div>
<div class="table-responsive"><table class="table table-hover align-middle">
    <thead><tr><th>Mã phiếu</th><th>Độc giả</th><th>Liên hệ</th><th>Số ngày quá hạn</th><th>Phạt tạm tính</th><th>Ngày lập</th><th>Trạng thái</th></tr></thead>
    <tbody><?php foreach (($reminders ?? []) as $reminder): ?><tr>
        <td><?= htmlspecialchars($reminder['ma_phieu_nhac_nho'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($reminder['ten_doc_gia_snapshot'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($reminder['so_dien_thoai_snapshot'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= (int)$reminder['tong_ngay_qua_han'] ?></td>
        <td><?= number_format((float)$reminder['tong_tien_phat_tam_tinh'], 0, ',', '.') ?>đ</td>
        <td><?= htmlspecialchars($reminder['ngay_lap'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($reminder['trang_thai'], ENT_QUOTES, 'UTF-8') ?></td>
    </tr><?php endforeach; ?>
    <?php if (empty($reminders)): ?><tr><td colspan="7" class="text-center text-secondary py-4">Chưa có phiếu nhắc nhở.</td></tr><?php endif; ?></tbody>
</table></div>
