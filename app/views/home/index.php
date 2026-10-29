<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QLTV</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/public/index.php?controller=home&action=index">QLTV</a>
            <?php if (isset($_SESSION['user'])): ?>
                <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>/public/index.php?controller=auth&action=logout">Đăng xuất</a>
            <?php endif; ?>
        </div>
    </nav>
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
                        <h5 class="card-title">Mượn trả</h5>
                        <p class="card-text">Theo dõi phiếu mượn, trả sách và xử lý vi phạm.</p>
                        <a href="<?= BASE_URL ?>/library_MVC/index.php" class="btn btn-secondary">Legacy route</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Admin</h5>
                        <p class="card-text">Quản lý nhân viên, thống kê và báo cáo thư viện.</p>
                        <a href="<?= BASE_URL ?>/library_MVC/index.php" class="btn btn-secondary">Legacy route</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
