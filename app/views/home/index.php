<?php
$pageTitle = 'Báo cáo thống kê';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Quản trị', 'url' => BASE_URL . '/public/index.php?controller=admin&action=dashboard'],
    ['label' => 'Báo cáo', 'url' => null],
];
$reportChart = [
    ['label' => 'Độc giả', 'value' => (int)($stats['reader_count'] ?? 0), 'class' => 'primary'],
    ['label' => 'Sách', 'value' => (int)($stats['book_count'] ?? 0), 'class' => 'alt'],
    ['label' => 'Thẻ', 'value' => (int)($stats['active_card_count'] ?? 0), 'class' => 'primary'],
    ['label' => 'Quá hạn', 'value' => (int)($stats['overdue_loan_count'] ?? 0), 'class' => 'alt'],
];
$chartMax = max(array_map(fn($item) => (int)($item['value'] ?? 0), $reportChart));
$chartMax = $chartMax > 0 ? $chartMax : 1;
require __DIR__ . '/../layouts/header.php';
?>
<div class="admin-shell">
    <aside class="admin-sidebar show">
        <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=dashboard" class="brand">QLTV Admin</a>
        <nav class="nav flex-column">
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=admin&action=dashboard"><span class="icon-inline">📊</span><span class="label">Dashboard</span></a>
            <a class="nav-link active" href="<?= BASE_URL ?>/public/index.php?controller=admin&action=reports"><span class="icon-inline">📈</span><span class="label">Báo cáo</span></a>
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=sach&action=index"><span class="icon-inline">📚</span><span class="label">Quản lý sách</span></a>
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=index"><span class="icon-inline">👥</span><span class="label">Quản lý độc giả</span></a>
            <a class="nav-link" href="<?= BASE_URL ?>/public/index.php?controller=loan&action=index"><span class="icon-inline">📦</span><span class="label">Phiếu mượn</span></a>
        </nav>
    </aside>
    <div class="admin-content">
        <div class="page-header">
            <div class="d-flex align-items-center">
                <button class="mobile-sidebar-toggle" type="button" aria-label="Toggle sidebar">☰</button>
                <h2>Báo cáo thống kê</h2>
            </div>
            <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=dashboard" class="btn btn-outline-secondary">Về dashboard</a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Tổng độc giả</div><div class="stats-value"><?= (int)($stats['reader_count'] ?? 0) ?></div></div></div></div>
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Tổng sách</div><div class="stats-value"><?= (int)($stats['book_count'] ?? 0) ?></div></div></div></div>
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Phiếu đang mượn</div><div class="stats-value"><?= (int)($stats['active_loan_count'] ?? 0) ?></div></div></div></div>
            <div class="col-md-3"><div class="stats-card"><div class="card-body"><div class="stats-label">Quá hạn</div><div class="stats-value"><?= (int)($stats['overdue_loan_count'] ?? 0) ?></div></div></div></div>
        </div>

        <div class="card chart-card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Biểu đồ báo cáo</h5>
                    <span class="badge text-bg-success-subtle text-success">Theo dõi nhanh</span>
                </div>
                <div class="chart-bars">
                    <?php foreach ($reportChart as $item): ?>
                        <div class="chart-bar-wrap">
                            <div class="chart-bar <?= ($item['class'] ?? '') === 'alt' ? 'alt' : '' ?>" style="height: <?= max(18, ((int)$item['value'] / $chartMax) * 100) ?>%;"></div>
                            <div class="chart-label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white"><h5 class="mb-0">Chi tiết hoạt động</h5></div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-dark"><tr><th>Nhóm</th><th>Giá trị</th><th>Ghi chú</th></tr></thead>
                    <tbody>
                        <tr><td>Độc giả</td><td><?= (int)($stats['reader_count'] ?? 0) ?></td><td>Hồ sơ đang hoạt động trong hệ thống</td></tr>
                        <tr><td>Sách</td><td><?= (int)($stats['book_count'] ?? 0) ?></td><td>Tổng đầu sách trong kho</td></tr>
                        <tr><td>Thẻ</td><td><?= (int)($stats['active_card_count'] ?? 0) ?></td><td>Thẻ còn hiệu lực</td></tr>
                        <tr><td>Phiếu quá hạn</td><td><?= (int)($stats['overdue_loan_count'] ?? 0) ?></td><td>Đòi hỏi xử lý</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
