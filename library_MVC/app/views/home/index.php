<section class="hero-panel p-4 p-md-5 rounded-4 mb-4">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <p class="text-uppercase small fw-semibold mb-2">Không gian tri thức dành cho mọi người</p>
            <h1 class="display-5 fw-bold">Chào mừng đến với thư viện</h1>
            <p class="lead mb-4">Tra cứu sách, xem tình trạng bản sao và quản lý hoạt động thư viện trên cùng một hệ thống.</p>
            <a class="btn btn-light btn-lg" href="<?= BASE_URL ?>/books/search">Tra cứu sách</a>
        </div>
        <div class="col-lg-4">
            <div class="hero-stat">
                <span class="fs-2 fw-bold"><?= (int)($bookCount ?? 0) ?></span>
                <span>đầu sách trong danh mục</span>
            </div>
        </div>
    </div>
</section>
<div class="row g-3">
    <div class="col-md-4"><div class="card h-100"><div class="card-body"><h2 class="h5">Độc giả</h2><p class="text-secondary">Đăng ký hồ sơ và tìm hiểu các gói mượn phù hợp.</p><a href="<?= BASE_URL ?>/auth/register">Đăng ký thẻ</a></div></div></div>
    <div class="col-md-4"><div class="card h-100"><div class="card-body"><h2 class="h5">Tra cứu</h2><p class="text-secondary">Tìm sách theo tên, tác giả, thể loại hoặc mã sách.</p><a href="<?= BASE_URL ?>/books/search">Mở danh mục sách</a></div></div></div>
    <div class="col-md-4"><div class="card h-100"><div class="card-body"><h2 class="h5">Hỗ trợ tại quầy</h2><p class="text-secondary">Nhân viên thư viện hỗ trợ mượn, trả và gia hạn thẻ.</p><a href="<?= BASE_URL ?>/auth/login">Đăng nhập nhân viên</a></div></div></div>
</div>
