<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu mượn</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-1">Phiếu mượn đang mở</h2>
                <small class="text-secondary">Tra cứu các tài liệu chưa được trả.</small>
            </div>
            <a href="<?= BASE_URL ?>/public/index.php?controller=loan&action=create" class="btn btn-primary">+ Lập phiếu mượn</a>
        </div>

        <form class="row g-2 mb-3" method="get" action="<?= BASE_URL ?>/public/index.php?controller=loan&action=index">
            <div class="col-sm-9">
                <input id="loan-keyword" name="keyword" value="<?= htmlspecialchars((string)($_GET['keyword'] ?? '')) ?>" class="form-control" placeholder="Tìm theo độc giả, mã thẻ hoặc sách">
            </div>
            <div class="col-sm-3 d-grid">
                <button class="btn btn-outline-primary">Tìm phiếu mượn</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Phiếu mượn</th>
                        <th>Độc giả / thẻ</th>
                        <th>Tài liệu</th>
                        <th>Hạn trả</th>
                        <th>Trạng thái</th>
                        <th></th>
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
                                <span class="badge text-bg-<?= ($loan['han_tra'] ?? '') < date('Y-m-d') ? 'danger' : 'success' ?>">
                                    <?= (($loan['han_tra'] ?? '') < date('Y-m-d')) ? 'Quá hạn' : 'Đang mượn' ?>
                                </span>
                            </td>
                            <td>
                                <?php if (((int)($loan['so_lan_gia_han'] ?? 0)) < 1 && (($loan['han_tra'] ?? '') >= date('Y-m-d')): ?>
                                    <a href="<?= BASE_URL ?>/public/index.php?controller=loan&action=renew&id=<?= (int)($loan['loan_detail_id'] ?? 0) ?>" class="btn btn-sm btn-outline-primary" onclick="return confirm('Gia hạn tài liệu này?');">Gia hạn</a>
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
    </div>
</body>
</html>
