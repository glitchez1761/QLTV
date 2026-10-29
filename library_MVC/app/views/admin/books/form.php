<?php $book = $book ?? []; $editing = !empty($book['book_id']); ?>
<div class="row justify-content-center"><div class="col-lg-8">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h3"><?= $editing ? 'Cập nhật đầu sách' : 'Thêm đầu sách' ?></h1>
        <form method="post" action="<?= BASE_URL ?>/admin/books/save" data-validate-form>
            <?php if ($editing): ?><input type="hidden" name="book_id" value="<?= (int)$book['book_id'] ?>"><?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="code">Mã sách</label><input id="code" name="ma_sach" class="form-control" required maxlength="30" value="<?= htmlspecialchars($book['ma_sach'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-6"><label class="form-label" for="title">Tên sách</label><input id="title" name="ten_sach" class="form-control" required maxlength="255" value="<?= htmlspecialchars($book['ten_sach'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-6"><label class="form-label" for="author">Tác giả</label><input id="author" name="tac_gia" class="form-control" maxlength="150" value="<?= htmlspecialchars($book['tac_gia'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-6"><label class="form-label" for="genre">Thể loại</label><input id="genre" name="the_loai" class="form-control" maxlength="100" value="<?= htmlspecialchars($book['the_loai'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-6"><label class="form-label" for="publisher">Nhà xuất bản</label><input id="publisher" name="nha_xuat_ban" class="form-control" maxlength="150" value="<?= htmlspecialchars($book['nha_xuat_ban'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-3"><label class="form-label" for="year">Năm xuất bản</label><input id="year" name="nam_xuat_ban" type="number" min="0" max="<?= date('Y') + 1 ?>" class="form-control" value="<?= htmlspecialchars((string)($book['nam_xuat_ban'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-3"><label class="form-label" for="price">Giá nhập (đ)</label><input id="price" name="gia_nhap" type="number" min="0" step="1000" class="form-control" required value="<?= htmlspecialchars((string)($book['gia_nhap'] ?? '0'), ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-6"><label class="form-label" for="isbn">ISBN</label><input id="isbn" name="isbn" class="form-control" maxlength="20" value="<?= htmlspecialchars($book['isbn'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>
                <div class="col-md-6"><label class="form-label" for="location">Vị trí lưu trữ</label><input id="location" name="vi_tri_luu_tru" class="form-control" maxlength="100" value="<?= htmlspecialchars($book['vi_tri_luu_tru'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div>
            </div>
            <div class="mt-4"><button class="btn btn-primary">Lưu đầu sách</button> <a class="btn btn-link" href="<?= BASE_URL ?>/admin/books">Hủy</a></div>
        </form>
    </div></div>
</div></div>
