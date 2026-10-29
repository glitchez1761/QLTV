<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <h1 class="h3 mb-1">Đăng nhập</h1>
                <p class="text-secondary mb-4">Sử dụng tài khoản thư viện của bạn.</p>
                <form method="post" action="<?= BASE_URL ?>/auth/handleLogin" data-validate-form>
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input id="username" name="username" class="form-control" autocomplete="username" required maxlength="50">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input id="password" name="password" type="password" class="form-control" autocomplete="current-password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
                </form>
                <p class="mt-4 mb-0 text-center">Chưa có thẻ? <a href="<?= BASE_URL ?>/auth/register">Đăng ký hồ sơ</a></p>
            </div>
        </div>
    </div>
</div>
