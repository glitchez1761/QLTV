<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QLTV</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
</head>
<body>
    <?php require __DIR__ . '/../layouts/navbar.php'; ?>
    <div class="container py-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Sách</h5>
                        <p class="card-text">Quản lý dữ liệu sách, nhà xuất bản, số lượng tồn kho.</p>
                        <a href="<?= BASE_URL ?>/public/index.php?controller=sach&action=index" class="btn btn-primary">Vào module</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Độc giả</h5>
                        <p class="card-text">Quản lý hồ sơ, thẻ, trạng thái thẻ và thông tin độc giả.</p>
                        <a href="<?= BASE_URL ?>/public/index.php?controller=docgia&action=index" class="btn btn-primary">Vào module</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Mượn trả</h5>
                        <p class="card-text">Theo dõi phiếu mượn, gia hạn và xử lý tài liệu đang cho mượn.</p>
                        <a href="<?= BASE_URL ?>/public/index.php?controller=loan&action=index" class="btn btn-primary">Vào module</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Quản trị</h5>
                        <p class="card-text">Theo dõi số lượng độc giả, sách, thẻ và báo cáo quá hạn.</p>
                        <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=dashboard" class="btn btn-secondary">Vào dashboard</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Báo cáo</h5>
                        <p class="card-text">Xem thống kê tổng quan và các chỉ số hoạt động thư viện.</p>
                        <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=reports" class="btn btn-secondary">Xem báo cáo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
