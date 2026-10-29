<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 text-primary fw-bold">
                    <i class="bi bi-calendar-range me-2"></i>Thiết Lập Tiêu Chí Báo Cáo
                </h5>
            </div>
            <?php if (!empty($reports)): ?>
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h2 class="h5">Báo cáo đã tạo</h2>
                        <div class="table-responsive"><table class="table table-hover">
                            <thead><tr><th>Ngày tạo</th><th>Khoảng thời gian</th><th>Nhân viên</th><th>Thẻ mới</th><th></th></tr></thead>
                            <tbody><?php foreach ($reports as $report): ?><tr>
                                <td><?= htmlspecialchars($report['ngay_tao'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($report['tu_ngay'], ENT_QUOTES, 'UTF-8') ?> – <?= htmlspecialchars($report['den_ngay'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($report['staff_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= (int)$report['so_the_moi'] ?></td>
                                <td><a href="<?= BASE_URL ?>/admin/reports/view?id=<?= (int)$report['report_id'] ?>">Xem</a></td>
                            </tr><?php endforeach; ?></tbody>
                        </table></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card-body p-4">
                <form action="<?= BASE_URL ?>/admin/reports/generate" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Từ ngày</label>
                        <input type="date" name="from_date" class="form-control" 
                               value="<?= date('Y-m-01') ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Đến ngày</label>
                        <input type="date" name="to_date" class="form-control" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="bi bi-file-earmark-bar-graph me-1"></i> Kết Xuất Báo Cáo Thống Kê
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>