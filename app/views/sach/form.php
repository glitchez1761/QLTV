<?php
$pageTitle = 'Đăng nhập';
$breadcrumbs = [
    ['label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['label' => 'Đăng nhập', 'url' => null],
];
require __DIR__ . '/../layouts/header.php';
?>
<div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 140px);">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <h3 class="text-center mb-4 fw-bold">Đăng nhập</h3>
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
                <?php endif; ?>
                <form method="POST" action="<?= BASE_URL ?>/public/index.php?controller=auth&action=authenticate">
                    <div class="mb-3">
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
