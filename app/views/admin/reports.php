<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo thống kê</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Báo cáo thống kê</h2>
            <a href="<?= BASE_URL ?>/public/index.php?controller=admin&action=dashboard" class="btn btn-outline-secondary">Về dashboard</a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Tổng độc giả</div>
                        <div class="display-6 fw-bold"><?= (int)($stats['reader_count'] ?? 0) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Tổng sách</div>
                        <div class="display-6 fw-bold"><?= (int)($stats['book_count'] ?? 0) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Phiếu đang mượn</div>
                        <div class="display-6 fw-bold"><?= (int)($stats['active_loan_count'] ?? 0) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Quá hạn</div>
                        <div class="display-6 fw-bold"><?= (int)($stats['overdue_loan_count'] ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Chi tiết hoạt động</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nhóm</th>
                            <th>Giá trị</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Độc giả</td>
                            <td><?= (int)($stats['reader_count'] ?? 0) ?></td>
                            <td>Hồ sơ đang hoạt động trong hệ thống</td>
                        </tr>
                        <tr>
                            <td>Sách</td>
                            <td><?= (int)($stats['book_count'] ?? 0) ?></td>
                            <td>Tổng đầu sách trong kho</td>
                        </tr>
                        <tr>
                            <td>Thẻ</td>
                            <td><?= (int)($stats['active_card_count'] ?? 0) ?></td>
                            <td>Thẻ còn hiệu lực</td>
                        </tr>
                        <tr>
                            <td>Phiếu quá hạn</td>
                            <td><?= (int)($stats['overdue_loan_count'] ?? 0) ?></td>
                            <td>Đòi hỏi xử lý</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
