<div class="row justify-content-center"><div class="col-lg-7">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h3">Thêm nhân viên</h1>
        <p class="text-secondary">Tên đăng nhập là email. Mật khẩu ban đầu được hiển thị sau khi tạo.</p>
        <form method="post" action="<?= BASE_URL ?>/admin/staff/store" data-validate-form>
            <div class="mb-3"><label class="form-label" for="name">Họ và tên</label><input id="name" name="full_name" class="form-control" required maxlength="100"></div>
            <div class="mb-3"><label class="form-label" for="email">Email đăng nhập</label><input id="email" name="email" type="email" class="form-control" required maxlength="100"></div>
            <div class="mb-3"><label class="form-label" for="phone">Số điện thoại</label><input id="phone" name="phone" type="tel" class="form-control" maxlength="15"></div>
            <div class="mb-4"><label class="form-label" for="role">Vai trò</label><select id="role" name="role" class="form-select"><option value="NHAN_VIEN">Nhân viên</option><option value="QUAN_LY">Quản lý</option></select></div>
            <button class="btn btn-primary">Tạo tài khoản</button> <a class="btn btn-link" href="<?= BASE_URL ?>/admin/staff">Hủy</a>
        </form>
    </div></div>
</div></div>
