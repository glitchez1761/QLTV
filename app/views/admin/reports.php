<?php $pageTitle = 'Dashboard quản trị'; require __DIR__ . '/../layouts/header.php'; ?>
<div class="page-header">
    <h2>Dashboard quản trị</h2>
    <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=reports" class="btn btn-outline-primary">Xem báo cáo</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><div class="text-muted small">Độc giả</div><div class="display-6 fw-bold"><?= (int)($stats['reader_count'] ?? 0) ?></div></div></div></div>
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><div class="text-muted small">Sách</div><div class="display-6 fw-bold"><?= (int)($stats['book_count'] ?? 0) ?></div></div></div></div>
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><div class="text-muted small">Thẻ đang hoạt động</div><div class="display-6 fw-bold"><?= (int)($stats['active_card_count'] ?? 0) ?></div></div></div></div>
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><div class="text-muted small">Phiếu đang mượn</div><div class="display-6 fw-bold"><?= (int)($stats['active_loan_count'] ?? 0) ?></div></div></div></div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="mb-3">Tổng quan</h5>
        <div class="alert alert-warning mb-0">Có <strong><?= (int)($stats['overdue_loan_count'] ?? 0) ?></strong> tài liệu đang quá hạn cần xử lý.</div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white"><h5 class="mb-0">Phiếu mượn gần đây</h5></div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark"><tr><th>Mã phiếu</th><th>Độc giả</th><th>Mã tài liệu</th><th>Hạn trả</th><th>Trạng thái</th></tr></thead>
            <tbody>
                <?php foreach (($latestLoans ?? []) as $loan): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)($loan['ma_phieu_muon'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($loan['ho_ten'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($loan['ma_tai_lieu'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($loan['han_tra'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($loan['trang_thai'] ?? '')) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
