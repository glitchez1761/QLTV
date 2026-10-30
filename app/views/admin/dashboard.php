<?php $pageTitle = 'Lập phiếu mượn'; require __DIR__ . '/../layouts/header.php'; ?>
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 text-primary fw-bold">Lập Phiếu Mượn Tài Liệu</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= BASE_URL ?>/public/index.php?controller=loan&action=store" method="POST" id="loanForm">
                    <div class="mb-3">
                        <label for="card_code" class="form-label fw-bold">Mã thẻ độc giả <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="card_code" name="card_code" placeholder="Ví dụ: THE2026001" required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold d-flex justify-content-between align-items-center">
                            <span>Danh sách mã cuốn sách <span class="text-danger">*</span></span>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddBookRow">+ Thêm sách</button>
                        </label>
                        <div id="bookInputsContainer">
                            <div class="input-group mb-2 book-input-row">
                                <span class="input-group-text bg-light text-muted">#1</span>
                                <input type="text" class="form-control book-code-input" name="copy_codes[]" placeholder="Nhập mã tài liệu (VD: CS-00012)" required>
                                <button type="button" class="btn btn-outline-danger btn-remove-row" style="display: none;">Xóa</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"><label class="form-label text-muted">Ngày mượn</label><input type="text" class="form-control bg-light" value="<?= date('d/m/Y') ?>" readonly></div>
                        <div class="col-md-6"><label class="form-label text-muted">Hạn trả dự kiến</label><input type="text" class="form-control bg-light" value="<?= date('d/m/Y', strtotime('+30 days')) ?>" readonly></div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="reset" class="btn btn-light px-4">Đặt lại</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Xác nhận & lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm border-0 mb-4 border-start border-primary border-4">
            <div class="card-body">
                <h6 class="fw-bold text-dark mb-3">Quy định mượn tài liệu về nhà</h6>
                <ul class="list-unstyled text-muted small mb-0">
                    <li class="mb-2">• Thời hạn giữ sách tối đa: <strong>30 ngày / lần mượn</strong>.</li>
                    <li class="mb-2">• Sách mượn phải ở trạng thái <code>Còn trong kho</code>.</li>
                    <li class="mb-2">• Độc giả phải có gói dịch vụ còn hiệu lực.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('bookInputsContainer');
    const btnAdd = document.getElementById('btnAddBookRow');
    function updateRemoveButtons() {
        const rows = container.querySelectorAll('.book-input-row');
        rows.forEach((row, index) => {
            row.querySelector('.input-group-text').textContent = '#' + (index + 1);
            const removeBtn = row.querySelector('.btn-remove-row');
            removeBtn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }
    btnAdd.addEventListener('click', function () {
        const rows = container.querySelectorAll('.book-input-row');
        if (rows.length >= 5) {
            alert('Một phiếu mượn tối đa chỉ chứa 5 cuốn sách.');
            return;
        }
        const newRow = rows[0].cloneNode(true);
        newRow.querySelector('input').value = '';
        container.appendChild(newRow);
        updateRemoveButtons();
    });
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-row')) {
            e.target.closest('.book-input-row').remove();
            updateRemoveButtons();
        }
    });
});
</script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
