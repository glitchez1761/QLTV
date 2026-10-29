<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    </head>
    <body>
        <div class="container">
            <h3 class="text-center text-uppercase text-success mt-3 mb-3">Quản lý mặt hàng</h3>
            <a href="?controller=addPatient" class="btn btn-success">Thêm mặt hàng mới</a>
            <table class="table mt-3">
            <thead>
                <tr>
                <th scope="col">Mã hàng</th>
                <th scope="col">Tên hàng</th>
                <th scope="col">Loại hàng</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Sửa</th>
                <th scope="col">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($products as $product) {
                ?>        
                    <tr>
                        <th scope="row"><?= $product->getId();?></th>
                        <td><?= $product->getFullName();?></td>
                        <td><?= $patient->getGender();?></td>
                        <td>
                            <a href="?controller=editPatient&id=<?= $patient->getId() ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>
                            <a href="?controller=deletePatient&id=<?= $patient->getId() ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>