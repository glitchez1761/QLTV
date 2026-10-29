<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3">Kích hoạt tài khoản</h1>
                <p class="text-secondary">Xác thực thẻ và ngày sinh, sau đó tạo mật khẩu mới.</p>
                <form method="post" action="<?= BASE_URL ?>/auth/handleFirstChangePassword" data-validate-form>
                    <div class="mb-3"><label class="form-label" for="card_number"><?= in_array($role ?? '', ['NHAN_VIEN', 'QUAN_LY'], true) ? 'Mã nhân viên' : 'Mã thẻ độc giả' ?></label><input id="card_number" name="card_number" class="form-control" required maxlength="30"></div>
                    <?php if (!in_array($role ?? '', ['NHAN_VIEN', 'QUAN_LY'], true)): ?><div class="mb-3"><label class="form-label" for="dob">Ngày sinh</label><input id="dob" name="dob" type="date" class="form-control" required></div><?php endif; ?>
                    <div class="mb-3"><label class="form-label" for="new_password">Mật khẩu mới</label><input id="new_password" name="new_password" type="password" class="form-control" required minlength="8" autocomplete="new-password"></div>
                    <div class="mb-4"><label class="form-label" for="confirm_password">Nhập lại mật khẩu</label><input id="confirm_password" name="confirm_password" type="password" class="form-control" required minlength="8" autocomplete="new-password"></div>
                    <button class="btn btn-primary w-100" type="submit">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
