<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h1 class="h3 mb-1">Danh mục đầu sách</h1><p class="text-secondary mb-0">Quản lý đầu sách và số lượng bản sao.</p></div>
    <a class="btn btn-primary" href="<?= BASE_URL ?>/admin/books/create">Thêm đầu sách</a>
</div>
<form method="get" action="<?= BASE_URL ?>/admin/books" class="row g-2 mb-3">
    <div class="col-sm-9"><label class="visually-hidden" for="book-keyword">Tìm sách</label><input id="book-keyword" class="form-control" name="keyword" value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Mã sách, tên, tác giả, thể loại hoặc ISBN"></div>
    <div class="col-sm-3 d-grid"><button class="btn btn-outline-primary">Tìm kiếm</button></div>
</form>
<div class="table-responsive"><table class="table table-hover align-middle">
    <thead><tr><th>Mã</th><th>Tên sách</th><th>Tác giả</th><th>Thể loại</th><th>Còn trong kho</th><th>Thao tác</th></tr></thead>
    <tbody><?php foreach (($books ?? []) as $book): ?><tr>
        <td><?= htmlspecialchars($book['ma_sach'], ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($book['ten_sach'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($book['tac_gia'] ?? '', ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($book['the_loai'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= (int)$book['available_copies'] ?> / <?= (int)$book['total_copies'] ?></td>
        <td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/admin/books/edit?id=<?= (int)$book['book_id'] ?>">Sửa</a> <a class="btn btn-sm btn-outline-secondary" href="<?= BASE_URL ?>/admin/books/inventory?id=<?= (int)$book['book_id'] ?>">Bản sao</a></td>
    </tr><?php endforeach; ?>
    <?php if (empty($books)): ?><tr><td colspan="6" class="text-center text-secondary py-4">Danh mục chưa có đầu sách phù hợp.</td></tr><?php endif; ?></tbody>
</table></div>
