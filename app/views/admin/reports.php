<?php
$pageTitle = 'Dashboard quản trị';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Quản trị', 'url' => null],
];
$chartItems = [
    ['label' => 'Độc giả', 'value' => (int)($stats['reader_count'] ?? 0), 'class' => 'primary'],
    ['label' => 'Sách', 'value' => (int)($stats['book_count'] ?? 0), 'class' => 'alt'],
    ['label' => 'Thẻ', 'value' => (int)($stats['active_card_count'] ?? 0), 'class' => 'primary'],
    ['label' => 'Mượn', 'value' => (int)($stats['active_loan_count'] ?? 0), 'class' => 'alt'],
];
$maxChartValue = max(array_map(fn($item) => (int)($item['value'] ?? 0), $chartItems));
$maxChartValue = $maxChartValue > 0 ? $maxChartValue : 1;
require __DIR__ . '/../layouts/header.php';
?>
<div class="admin-shell">
    <aside class="admin-sidebar show">
        <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=dashboard" class="brand">QLTV Admin</a>
        <nav class="nav flex-column">
            <a class="nav-link active" href="<?= BASE_URL ?>/public/index.php?controller=admin&action=dashboard"><span class="icon-inline">📊</span><span class="label">Dashboard</span></a>
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=admin&action=reports"><span class="icon-inline">📈</span><span class="label">Báo cáo</span></a>
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=sach&action=index"><span class="icon-inline">📚</span><span class="label">Quản lý sách</span></a>
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=index"><span class="icon-inline">👥</span><span class="label">Quản lý độc giả</span></a>
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=loan&action=index"><span class="icon-inline">📦</span><span class="label">Phiếu mượn</span></a>
        </nav>
    </aside>
    <div class="admin-content">
        <div class="page-header">
            <div class="d-flex align-items-center">
                <button class="mobile-sidebar-toggle" type="button" aria-label="Toggle sidebar">☰</button>
                <h2>Dashboard quản trị</h2>
            </div>
            <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=reports" class="btn btn-outline-primary">Xem báo cáo</a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Độc giả</div><div class="stats-value"><?= (int)($stats['reader_count'] ?? 0) ?></div></div></div></div>
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Sách</div><div class="stats-value"><?= (int)($stats['book_count'] ?? 0) ?></div></div></div></div>
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Thẻ hoạt động</div><div class="stats-value"><?= (int)($stats['active_card_count'] ?? 0) ?></div></div></div></div>
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Phiếu đang mượn</div><div class="stats-value"><?= (int)($stats['active_loan_count'] ?? 0) ?></div></div></div></div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="card chart-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Biểu đồ hoạt động</h5>
                            <span class="badge text-bg-primary-subtle text-primary">Thống kê nhanh</span>
                        </div>
                        <div class="chart-bars">
                            <?php foreach ($chartItems as $chart): ?>
                                <div class="chart-bar-wrap">
                                    <div class="chart-bar <?= ($chart['class'] ?? '') === 'alt' ? 'alt' : '' ?>" style="height: <?= max(18, ((int)$chart['value'] / $maxChartValue) * 100) ?>%;"></div>
                                    <div class="chart-label"><?= htmlspecialchars($chart['label'], ENT_QUOTES, 'UTF-8') ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="mb-3">Tổng quan</h5>
                        <div class="alert alert-warning mb-0">Có <strong><?= (int)($stats['overdue_loan_count'] ?? 0) ?></strong> tài liệu đang quá hạn cần xử lý.</div>
                    </div>
                </div>
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
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
