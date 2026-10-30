<?php
$pageTitle = 'Phiếu mượn';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Mượn trả', 'url' => null],
];
require __DIR__ . '/../layouts/header.php';
?>
<div class="page-header">
    <div>
        <h2>📦 Phiếu mượn</h2>
    </div>
    <a href="<?= BASE_URL ?>/public/index.php?controller=loan&action=create" class="btn btn-primary action-btn">➕ Lập phiếu mượn</a>
</div>

<div class="summary-grid">
    <div class="summary-card info">
        <div class="summary-icon">📦</div>
        <div>
            <div class="label">Đang mượn</div>
            <div class="value"><?= count($loans ?? []) ?></div>
        </div>
    </div>
    <div class="summary-card warning">
        <div class="summary-icon">⏰</div>
        <div>
            <div class="label">Quá hạn</div>
            <div class="value"><?= count(array_filter($loans ?? [], fn($loan) => !empty($loan['han_tra']) && $loan['han_tra'] < date('Y-m-d'))) ?></div>
        </div>
    </div>
    <div class="summary-card success">
        <div class="summary-icon">🔄</div>
        <div>
            <div class="label">Gia hạn</div>
            <div class="value"><?= count(array_filter($loans ?? [], fn($loan) => !empty($loan['so_lan_gia_han']) && (int)$loan['so_lan_gia_han'] > 0)) ?></div>
        </div>
    </div>
</div>

<form class="row g-2 mb-3" method="get" action="<?= BASE_URL ?>/public/index.php?controller=loan&action=index">
    <div class="col-sm-9">
        <input id="loan-keyword" name="keyword" value="<?= htmlspecialchars((string)($_GET['keyword'] ?? '')) ?>" class="form-control" placeholder="🔎 Tìm theo độc giả, mã thẻ hoặc sách">
    </div>
    <div class="col-sm-3 d-grid">
        <button class="btn btn-outline-primary action-btn">🔍 Tìm phiếu</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle shadow-sm bg-white">
        <thead class="table-dark">
            <tr>
                <th>Phiếu mượn</th>
                <th>Độc giả / thẻ</th>
                <th>Tài liệu</th>
                <th>Hạn trả</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($loans ?? []) as $loan): ?>
                <tr>
                    <td><?= htmlspecialchars((string)($loan['ma_phieu_muon'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string)($loan['ho_ten'] ?? '')) ?><br><small><?= htmlspecialchars((string)($loan['ma_the'] ?? '')) ?></small></td>
                    <td><?= htmlspecialchars((string)($loan['ten_sach'] ?? '')) ?><br><small><?= htmlspecialchars((string)($loan['ma_tai_lieu'] ?? '')) ?></small></td>
                    <td><?= htmlspecialchars((string)($loan['han_tra'] ?? '')) ?></td>
                    <td>
                        <span class="badge text-bg-<?= (!empty($loan['han_tra']) && $loan['han_tra'] < date('Y-m-d')) ? 'danger' : 'success' ?>">
                            <?= (!empty($loan['han_tra']) && $loan['han_tra'] < date('Y-m-d')) ? 'Quá hạn' : 'Đang mượn' ?>
                        </span>
                    </td>
                    <td>
                        <?php if (empty($loan['so_lan_gia_han']) || (int)$loan['so_lan_gia_han'] < 1): ?>
                            <a href="<?= BASE_URL ?>/public/index.php?controller=loan&action=renew&id=<?= (int)($loan['loan_detail_id'] ?? 0) ?>" class="btn btn-sm btn-outline-primary action-btn" onclick="return confirm('Gia hạn tài liệu này?');">🔄 Gia hạn</a>
                        <?php else: ?>
                            <span class="text-muted small">Đã gia hạn</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($loans)): ?>
                <tr><td colspan="6" class="text-center text-secondary py-4">Không có phiếu mượn phù hợp.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
