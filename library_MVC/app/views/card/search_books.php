<div class="row">
    <!-- Cột trái: Bộ lọc tra cứu đa tiêu chí (UC16) -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 text-primary fw-bold">
                    <i class="bi bi-search me-2"></i>Tra Cứu Tài Liệu
                </h5>
            </div>
            <div class="card-body p-3">
                <form action="<?= BASE_URL ?>/books/search" method="GET">
                    <!-- Từ khóa chung -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Từ khóa chung (Keyword)</label>
                        <input type="text" name="keyword" class="form-control form-control-sm" 
                               value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" 
                               placeholder="Tìm theo tên, tác giả, ISBN...">
                    </div>

                    <!-- Nhan đề / Tên sách -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nhan đề sách</label>
                        <input type="text" name="ten_sach" class="form-control form-control-sm" 
                               value="<?= htmlspecialchars($_GET['ten_sach'] ?? '') ?>" 
                               placeholder="Ví dụ: Nhập môn CSDL...">
                    </div>

                    <!-- Tác giả -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tác giả</label>
                        <input type="text" name="tac_gia" class="form-control form-control-sm" 
                               value="<?= htmlspecialchars($_GET['tac_gia'] ?? '') ?>" 
                               placeholder="Ví dụ: Nguyễn Văn A...">
                    </div>

                    <!-- Chủ đề / Thể loại -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Chủ đề / Thể loại</label>
                        <select name="the_loai" class="form-select form-select-sm">
                            <option value="">-- Tất cả chủ đề --</option>
                            <option value="Công nghệ thông tin" <?= (($_GET['the_loai'] ?? '') === 'Công nghệ thông tin') ? 'selected' : '' ?>>Công nghệ thông tin</option>
                            <option value="Kinh tế" <?= (($_GET['the_loai'] ?? '') === 'Kinh tế') ? 'selected' : '' ?>>Kinh tế</option>
                            <option value="Khoa học kỹ thuật" <?= (($_GET['the_loai'] ?? '') === 'Khoa học kỹ thuật') ? 'selected' : '' ?>>Khoa học kỹ thuật</option>
                            <option value="Văn học" <?= (($_GET['the_loai'] ?? '') === 'Văn học') ? 'selected' : '' ?>>Văn học</option>
                        </select>
                    </div>

                    <!-- Nhà xuất bản & Năm XB -->
                    <div class="row g-2 mb-3">
                        <div class="col-7">
                            <label class="form-label fw-bold small">Nhà xuất bản</label>
                            <input type="text" name="nha_xuat_ban" class="form-control form-control-sm" 
                                   value="<?= htmlspecialchars($_GET['nha_xuat_ban'] ?? '') ?>" 
                                   placeholder="Ví dụ: NXB Trẻ">
                        </div>
                        <div class="col-5">
                            <label class="form-label fw-bold small">Năm XB</label>
                            <input type="number" name="nam_xuat_ban" class="form-control form-control-sm" 
                                   value="<?= htmlspecialchars($_GET['nam_xuat_ban'] ?? '') ?>" 
                                   placeholder="2026">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm fw-bold">
                            <i class="bi bi-funnel me-1"></i> Tìm Kiếm
                        </button>
                        <a href="<?= BASE_URL ?>/books/search" class="btn btn-outline-secondary btn-sm">
                            Xóa bộ lọc
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cột phải: Danh sách kết quả tài liệu (UC16) -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0 fw-bold">
                    Kết Quả Tra Cứu (<?= count($books ?? []) ?> đầu sách)
                </h6>
                <span class="badge bg-light text-dark border">Hệ thống tra cứu OPAC</span>
            </div>
            <div class="card-body p-0">
                <?php if (empty($books)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-journal-x display-4 text-muted"></i>
                        <p class="text-muted mt-2">Không tìm thấy tài liệu nào phù hợp với điều kiện tra cứu.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th>Mã sách</th>
                                    <th>Thông tin tài liệu</th>
                                    <th>Chủ đề</th>
                                    <th>Vị trí kệ</th>
                                    <th>Tình trạng kho</th>
                                    <th class="text-center">Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $b): ?>
                                    <tr>
                                        <td class="fw-bold text-secondary small"><?= htmlspecialchars($b['ma_sach']) ?></td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($b['ten_sach']) ?></div>
                                            <div class="small text-muted">
                                                Tác giả: <span class="text-dark"><?= htmlspecialchars($b['tac_gia'] ?? 'Chưa rõ') ?></span> | 
                                                NXB: <?= htmlspecialchars($b['nha_xuat_ban'] ?? '-') ?> (<?= $b['nam_xuat_ban'] ?? '-' ?>)
                                            </div>
                                        </td>
                                        <td><span class="badge bg-info-subtle text-info border"><?= htmlspecialchars($b['the_loai'] ?? 'Khác') ?></span></td>
                                        <td class="small text-muted"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($b['vi_tri_luu_tru'] ?? 'Khu A') ?></td>
                                        <td>
                                            <?php if (($b['available_copies'] ?? 0) > 0): ?>
                                                <span class="badge bg-success">Còn sẵn (<?= $b['available_copies'] ?>/<?= $b['total_copies'] ?>)</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Hết sách (0/<?= $b['total_copies'] ?? 0 ?>)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#bookDetailModal_<?= $b['book_id'] ?>">
                                                Xem
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Chi tiết tài liệu (UC16) -->
                                    <div class="modal fade" id="bookDetailModal_<?= $b['book_id'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title fw-bold text-primary"><?= htmlspecialchars($b['ten_sach']) ?></h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body small">
                                                    <ul class="list-group list-group-flush mb-3">
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="text-muted">Mã đầu sách:</span>
                                                            <span class="fw-bold"><?= htmlspecialchars($b['ma_sach']) ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="text-muted">Mã chuẩn ISBN:</span>
                                                            <span><?= htmlspecialchars($b['isbn'] ?? 'Không có') ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="text-muted">Tác giả:</span>
                                                            <span class="fw-bold"><?= htmlspecialchars($b['tac_gia'] ?? '-') ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="text-muted">Nhà xuất bản:</span>
                                                            <span><?= htmlspecialchars($b['nha_xuat_ban'] ?? '-') ?> (Năm <?= $b['nam_xuat_ban'] ?? '-' ?>)</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="text-muted">Vị trí lưu trữ giá kệ:</span>
                                                            <span class="badge bg-secondary"><?= htmlspecialchars($b['vi_tri_luu_tru'] ?? '-') ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span class="text-muted">Giá trị tài liệu (Định giá):</span>
                                                            <span class="fw-bold text-danger"><?= number_format($b['gia_nhap'] ?? 0) ?> VNĐ</span>
                                                        </li>
                                                    </ul>
                                                    <div class="alert alert-info py-2 mb-0">
                                                        <i class="bi bi-info-circle me-1"></i> Số bản còn trong kho: <strong><?= $b['available_copies'] ?? 0 ?></strong> / <strong><?= $b['total_copies'] ?? 0 ?></strong> cuốn
                                                    </div>
                                                </div>
                                                <div class="modal-footer py-2">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>