<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-0">
            <i class="bi bi-bar-chart-line text-primary me-2"></i>Báo Cáo Hoạt Động & Doanh Thu Thư Viện
        </h4>
        <p class="text-muted small mb-0">Dữ liệu thống kê từ ngày <strong><?= date('d/m/Y', strtotime($from)) ?></strong> đến ngày <strong><?= date('d/m/Y', strtotime($to)) ?></strong></p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i> In báo cáo
        </button>
        <a href="<?= BASE_URL ?>/admin/reports" class="btn btn-primary btn-sm">
            <i class="bi bi-funnel me-1"></i> Thay đổi thời gian
        </a>
    </div>
</div>

<!-- Khối 1: Các thẻ chỉ số tổng quan (KPIs) (UC23) -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Thẻ độc giả mới cấp</div>
                        <div class="fs-3 fw-bold"><?= number_format($newCards ?? 0) ?></div>
                    </div>
                    <i class="bi bi-person-vcard display-6 text-white-50"></i>
                </div>
                <div class="small text-white-50 mt-2">Tổng số hồ sơ được phê duyệt thẻ mới</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Lượt mượn sách trong kỳ</div>
                        <div class="fs-3 fw-bold">
                            <?= array_sum(array_column($borrowList ?? [], 'borrow_count')) ?>
                        </div>
                    </div>
                    <i class="bi bi-journal-arrow-up display-6 text-white-50"></i>
                </div>
                <div class="small text-white-50 mt-2">Tổng số lượt lưu thông tài liệu</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-dark text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Tổng doanh thu thư viện</div>
                        <div class="fs-3 fw-bold text-warning"><?= number_format($revenue['total'] ?? 0) ?> VNĐ</div>
                    </div>
                    <i class="bi bi-cash-coin display-6 text-white-50"></i>
                </div>
                <div class="small text-white-50 mt-2">Doanh thu từ thẻ, gói dịch vụ và tiền phạt</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Khối 2: Chi tiết cơ cấu doanh thu theo nguồn thu (UC23) -->
    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="card-title mb-0 fw-bold">Cơ Cấu Doanh Thu Thu Được</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th>Nguồn thu phí</th>
                            <th class="text-end">Số tiền thu</th>
                            <th class="text-end">Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <i class="bi bi-credit-card me-2 text-primary"></i>Phí cấp & gia hạn thẻ
                                <div class="text-muted small">Phí thường niên 20k/năm</div>
                            </td>
                            <td class="text-end fw-bold"><?= number_format($revenue['card_fee'] ?? 0) ?> đ</td>
                            <td class="text-end text-muted small">
                                <?= ($revenue['total'] > 0) ? round(($revenue['card_fee'] / $revenue['total']) * 100, 1) : 0 ?>%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="bi bi-box-seam me-2 text-success"></i>Đăng ký gói mượn về nhà
                                <div class="text-muted small">Gói 200k, 300k, 500k</div>
                            </td>
                            <td class="text-end fw-bold"><?= number_format($revenue['package_fee'] ?? 0) ?> đ</td>
                            <td class="text-end text-muted small">
                                <?= ($revenue['total'] > 0) ? round(($revenue['package_fee'] / $revenue['total']) * 100, 1) : 0 ?>%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="bi bi-exclamation-triangle me-2 text-danger"></i>Tiền phạt & bồi thường
                                <div class="text-muted small">Phạt quá hạn 2k/ngày + hỏng/mất</div>
                            </td>
                            <td class="text-end fw-bold text-danger"><?= number_format($revenue['fine_fee'] ?? 0) ?> đ</td>
                            <td class="text-end text-muted small">
                                <?= ($revenue['total'] > 0) ? round(($revenue['fine_fee'] / $revenue['total']) * 100, 1) : 0 ?>%
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fw-bold">
                            <td>TỔNG CỘNG</td>
                            <td class="text-end text-primary fs-6"><?= number_format($revenue['total'] ?? 0) ?> VNĐ</td>
                            <td class="text-end">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Khối 3: Top 10 đầu sách được mượn nhiều nhất trong tháng (UC23) -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="card-title mb-0 fw-bold">Top Đầu Sách Được Mượn Nhiều Nhất</h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($borrowList)): ?>
                    <div class="text-center py-5 text-muted small">
                        Không có lượt mượn sách nào trong khoảng thời gian này.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th style="width: 50px;" class="text-center">#</th>
                                    <th>Tên đầu sách</th>
                                    <th class="text-center" style="width: 140px;">Số lượt mượn</th>
                                    <th style="width: 150px;">Tần suất</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $maxBorrow = max(array_column($borrowList, 'borrow_count') ?: [1]);
                                foreach ($borrowList as $idx => $item): 
                                    $percent = round(($item['borrow_count'] / $maxBorrow) * 100);
                                ?>
                                    <tr>
                                        <td class="text-center fw-bold text-muted"><?= $idx + 1 ?></td>
                                        <td class="fw-bold text-dark small"><?= htmlspecialchars($item['ten_sach']) ?></td>
                                        <td class="text-center fw-bold text-primary"><?= $item['borrow_count'] ?> lượt</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: <?= $percent ?>%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>