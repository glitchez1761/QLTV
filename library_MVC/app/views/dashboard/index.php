<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Dashboard quản lý thư viện</h2>
        <p class="text-muted mb-0">Tổng quan 5 module CRUD chính</p>
    </div>
    <a href="<?= BASE_URL ?>/sach/create" class="btn btn-primary">+ Thêm mới</a>
</div>

<div class="row g-4">
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-primary fw-semibold">Sách</span>
                    <span class="badge bg-primary-subtle text-primary rounded-pill">Module</span>
                </div>
                <h3 class="mb-0"><?= number_format((int)($counts['sach'] ?? 0), 0, ',', '.') ?></h3>
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/sach" class="btn btn-sm btn-outline-primary me-2">Xem danh sách</a>
                    <a href="<?= BASE_URL ?>/sach/create" class="btn btn-sm btn-primary">Thêm mới</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-success fw-semibold">Nhân viên</span>
                    <span class="badge bg-success-subtle text-success rounded-pill">Module</span>
                </div>
                <h3 class="mb-0"><?= number_format((int)($counts['nhan_vien'] ?? 0), 0, ',', '.') ?></h3>
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/nhan-vien" class="btn btn-sm btn-outline-success me-2">Xem danh sách</a>
                    <a href="<?= BASE_URL ?>/nhan-vien/create" class="btn btn-sm btn-success">Thêm mới</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-warning fw-semibold">Độc giả</span>
                    <span class="badge bg-warning-subtle text-warning rounded-pill">Module</span>
                </div>
                <h3 class="mb-0"><?= number_format((int)($counts['doc_gia'] ?? 0), 0, ',', '.') ?></h3>
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/doc-gia" class="btn btn-sm btn-outline-warning me-2">Xem danh sách</a>
                    <a href="<?= BASE_URL ?>/doc-gia/create" class="btn btn-sm btn-warning">Thêm mới</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-info fw-semibold">Phiếu mượn</span>
                    <span class="badge bg-info-subtle text-info rounded-pill">Module</span>
                </div>
                <h3 class="mb-0"><?= number_format((int)($counts['phieu_muon'] ?? 0), 0, ',', '.') ?></h3>
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/phieu-muon" class="btn btn-sm btn-outline-info me-2">Xem danh sách</a>
                    <a href="<?= BASE_URL ?>/phieu-muon/create" class="btn btn-sm btn-info">Thêm mới</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-danger fw-semibold">Vi phạm</span>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">Module</span>
                </div>
                <h3 class="mb-0"><?= number_format((int)($counts['vi_pham'] ?? 0), 0, ',', '.') ?></h3>
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/vi-pham" class="btn btn-sm btn-outline-danger me-2">Xem danh sách</a>
                    <a href="<?= BASE_URL ?>/vi-pham/create" class="btn btn-sm btn-danger">Thêm mới</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body">
        <h5 class="mb-3">Tác vụ nhanh</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= BASE_URL ?>/sach/create" class="btn btn-primary">Thêm sách</a>
            <a href="<?= BASE_URL ?>/nhan-vien/create" class="btn btn-success">Thêm nhân viên</a>
            <a href="<?= BASE_URL ?>/doc-gia/create" class="btn btn-warning">Thêm độc giả</a>
            <a href="<?= BASE_URL ?>/phieu-muon/create" class="btn btn-info">Lập phiếu mượn</a>
            <a href="<?= BASE_URL ?>/vi-pham/create" class="btn btn-danger">Tạo biên bản vi phạm</a>
        </div>
    </div>
</div>
