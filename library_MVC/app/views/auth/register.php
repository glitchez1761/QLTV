<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3">Đăng ký hồ sơ thẻ độc giả</h1>
                <p class="text-secondary">Hồ sơ sẽ được thư viện tiếp nhận và xét duyệt trước khi cấp thẻ.</p>
                <form method="post" action="<?= BASE_URL ?>/auth/handleRegister" data-validate-form>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="full_name">Họ và tên</label><input id="full_name" name="ho_ten" class="form-control" required maxlength="100"></div>
                        <div class="col-md-6"><label class="form-label" for="dob">Ngày sinh</label><input id="dob" name="ngay_sinh" type="date" class="form-control" required max="<?= date('Y-m-d') ?>"></div>
                        <div class="col-md-6"><label class="form-label" for="applicant_type">Đối tượng đăng ký</label><select id="applicant_type" name="doi_tuong_dang_ky" class="form-select" required><option value="NGUOI_LON">Người lớn</option><option value="TRE_EM">Trẻ em</option></select></div>
                        <div class="col-md-6"><label class="form-label" for="gender">Giới tính</label><select id="gender" name="gioi_tinh" class="form-select"><option value="">Không khai báo</option><option>Nam</option><option>Nữ</option><option>Khác</option></select></div>
                        <div class="col-md-6"><label class="form-label" for="identity">CCCD / Hộ chiếu</label><input id="identity" name="cccd_passport" class="form-control" maxlength="30"></div>
                        <div class="col-md-6"><label class="form-label" for="email">Email</label><input id="email" name="email" type="email" class="form-control" maxlength="100"></div>
                        <div class="col-md-6"><label class="form-label" for="phone">Số điện thoại</label><input id="phone" name="so_dien_thoai" type="tel" class="form-control" maxlength="15"></div>
                        <div class="col-12"><label class="form-label" for="address">Địa chỉ</label><input id="address" name="dia_chi_hien_tai" class="form-control" maxlength="255"></div>
                    </div>
                    <fieldset class="border rounded-3 p-3 mt-4" data-guardian-fields hidden>
                        <legend class="float-none w-auto px-2 fs-6">Thông tin người giám hộ (bắt buộc với trẻ em)</legend>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="guardian_name">Họ tên người giám hộ</label><input id="guardian_name" name="guardian_name" class="form-control" maxlength="100"></div>
                            <div class="col-md-6"><label class="form-label" for="guardian_phone">Điện thoại người giám hộ</label><input id="guardian_phone" name="guardian_phone" type="tel" class="form-control" maxlength="15"></div>
                        </div>
                    </fieldset>
                    <button class="btn btn-primary mt-4" type="submit">Gửi hồ sơ đăng ký</button>
                </form>
            </div>
        </div>
    </div>
</div>
