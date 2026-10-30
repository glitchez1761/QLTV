<?php
$pageTitle = 'Quản lý sách';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Sách', 'url' => null],
];
require __DIR__ . '/../layouts/header.php';
?>
<div class="page-header">
    <h2>📚 Quản lý sách</h2>
    <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=add" class="btn btn-primary action-btn">➕ Thêm sách</a>
</div>

<div class="summary-grid">
    <div class="summary-card info">
        <div class="summary-icon">📚</div>
        <div>
            <div class="label">Tổng sách</div>
            <div class="value"><?= count($books ?? []) ?></div>
        </div>
    </div>
    <div class="summary-card success">
        <div class="summary-icon">✅</div>
        <div>
            <div class="label">Còn trong kho</div>
            <div class="value"><?= array_sum(array_map(fn($book) => (int)($book['SoLuongTon'] ?? 0), $books ?? [])) ?></div>
        </div>
    </div>
    <div class="summary-card warning">
        <div class="summary-icon">⚠️</div>
        <div>
            <div class="label">Sắp hết</div>
            <div class="value"><?= count(array_filter($books ?? [], fn($book) => (int)($book['SoLuongTon'] ?? 0) <= 5)) ?></div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped shadow-sm bg-white">
        <thead class="table-dark">
            <tr>
                <th>Mã sách</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>Nhà xuất bản</th>
                <th>Số lượng tồn</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['MaSach']) ?></td>
                    <td><?= htmlspecialchars($book['TenSach']) ?></td>
                    <td><?= htmlspecialchars($book['TacGia']) ?></td>
                    <td><?= htmlspecialchars($book['NhaXuatBan']) ?></td>
                    <td><?= htmlspecialchars($book['SoLuongTon']) ?></td>
                    <td>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=edit&id=<?= urlencode($book['MaSach']) ?>" class="btn btn-warning btn-sm action-btn">✏️ Sửa</a>
                            <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=delete&id=<?= urlencode($book['MaSach']) ?>" class="btn btn-danger btn-sm action-btn" onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
