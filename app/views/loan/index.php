<?php
$pageTitle = 'Quản lý độc giả';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Độc giả', 'url' => null],
];
require __DIR__ . '/../layouts/header.php';
?>
<div class="page-header">
    <h2>👥 Quản lý độc giả</h2>
    <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=add" class="btn btn-primary action-btn">➕ Thêm mới</a>
</div>

<div class="summary-grid">
    <div class="summary-card info">
        <div class="summary-icon">👥</div>
        <div>
            <div class="label">Tổng độc giả</div>
            <div class="value"><?= count($readers ?? []) ?></div>
        </div>
    </div>
    <div class="summary-card success">
        <div class="summary-icon">✅</div>
        <div>
            <div class="label">Thẻ còn hạn</div>
            <div class="value"><?= count(array_filter($readers ?? [], fn($reader) => (($reader['TrangThaiThe'] ?? 'Con han') === 'Con han' || ($reader['TrangThaiThe'] ?? 'Con han') === 'Con hạn')) ) ?></div>
        </div>
    </div>
    <div class="summary-card warning">
        <div class="summary-icon">⏳</div>
        <div>
            <div class="label">Hết hạn</div>
            <div class="value"><?= count(array_filter($readers ?? [], fn($reader) => ($reader['TrangThaiThe'] ?? 'Con han') === 'Het han')) ?></div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle shadow-sm bg-white">
        <thead class="table-dark">
            <tr>
                <th>Mã độc giả</th>
                <th>Họ tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>SĐT</th>
                <th>Ngày cấp thẻ</th>
                <th>Ngày hết hạn</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($readers as $reader): ?>
                <tr>
                    <td><?= htmlspecialchars((string)$reader['MaDocGia']) ?></td>
                    <td><?= htmlspecialchars((string)($reader['HoTen'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string)($reader['NgaySinh'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string)($reader['GioiTinh'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string)($reader['SoDienThoai'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string)($reader['NgayCapThe'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string)($reader['NgayHetHan'] ?? '')) ?></td>
                    <td>
                        <?php
                            $status = $reader['TrangThaiThe'] ?? 'Con han';
                            $badgeClass = ($status === 'Het han' || $status === 'Hết hạn') ? 'bg-danger' : 'bg-success';
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=edit&id=<?= (int)$reader['MaDocGia'] ?>" class="btn btn-sm btn-warning action-btn">✏️ Sửa</a>
                            <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=delete&id=<?= (int)$reader['MaDocGia'] ?>" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
