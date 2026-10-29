<div class="mb-3"><a href="<?= BASE_URL ?>/admin/books" class="text-decoration-none">&larr; Danh mục đầu sách</a></div>
<div class="d-flex justify-content-between align-items-center mb-3"><div><h1 class="h3 mb-1">Quản lý bản sao</h1><p class="text-secondary mb-0"><?= htmlspecialchars($book['ten_sach'] ?? '', ENT_QUOTES, 'UTF-8') ?></p></div></div>
<?php if (!empty($book)): ?>
    <form method="post" action="<?= BASE_URL ?>/admin/books/copies/add" class="row g-2 mb-4">
        <input type="hidden" name="book_id" value="<?= (int)$book['book_id'] ?>">
        <div class="col-md-8"><label for="copy_code" class="visually-hidden">Mã tài liệu</label><input id="copy_code" name="ma_tai_lieu" class="form-control" placeholder="Mã tài liệu/bản sao mới" maxlength="30" required></div>
        <div class="col-md-4 d-grid"><button class="btn btn-primary">Thêm bản sao</button></div>
    </form>
    <div class="table-responsive"><table class="table table-hover"><thead><tr><th>Mã tài liệu</th><th>Tình trạng</th><th>Giá bồi thường</th></tr></thead><tbody>
    <?php foreach (($copies ?? []) as $copy): ?><tr><td><?= htmlspecialchars($copy['ma_tai_lieu'], ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($copy['trang_thai'], ENT_QUOTES, 'UTF-8') ?></td><td><?= number_format((float)$copy['gia_boi_thuong'], 0, ',', '.') ?>đ</td></tr><?php endforeach; ?>
    <?php if (empty($copies)): ?><tr><td colspan="3" class="text-center text-secondary">Chưa có bản sao.</td></tr><?php endif; ?>
    </tbody></table></div>
<?php else: ?><div class="alert alert-warning">Không tìm thấy đầu sách.</div><?php endif; ?>
