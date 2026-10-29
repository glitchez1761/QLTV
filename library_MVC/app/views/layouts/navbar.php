<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/"><?= htmlspecialchars(APP_NAME, ENT_QUOTES, 'UTF-8') ?></a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['vai_tro'], ['NHAN_VIEN', 'QUAN_LY'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Quản lý chung</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/sach">Sách</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/nhan-vien">Nhân viên</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/doc-gia">Độc giả</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/phieu-muon">Phiếu mượn</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/vi-pham">Biên bản vi phạm</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/books/search">Tra cứu sách</a></li>

        <?php if (!empty($_SESSION['user']) && $_SESSION['user']['vai_tro'] === 'DOC_GIA'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/packages">Gói mượn</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['vai_tro'], ['NHAN_VIEN', 'QUAN_LY'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/loan/create">Lập phiếu mượn</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/loans">Phiếu mượn</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/return">Trả sách & Vi phạm</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/cards">Thẻ độc giả</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/reminders">Nhắc nhở</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['vai_tro'] === 'QUAN_LY'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/books">Kho sách</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/staff">Quản lý nhân viên</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/reports">Báo cáo & Doanh thu</a></li>
        <?php endif; ?>
      </ul>

      <div class="d-flex align-items-center text-white">
        <?php if (isset($_SESSION['user'])): ?>
          <span class="me-3">Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars($_SESSION['user']['vai_tro'], ENT_QUOTES, 'UTF-8') ?>)</span>
          <a href="<?= BASE_URL ?>/auth/profile" class="btn btn-outline-light btn-sm me-2">Hồ sơ</a>
          <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-outline-light btn-sm">Đăng xuất</a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/auth/login" class="btn btn-light btn-sm me-2">Đăng nhập</a>
          <a href="<?= BASE_URL ?>/auth/register" class="btn btn-warning btn-sm">Đăng ký thẻ</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
