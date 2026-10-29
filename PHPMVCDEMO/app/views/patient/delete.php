<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
        <title>Xóa thông tin bệnh nhân</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <style>
            form {
                width: 50%;
                margin: auto;
            }
            button {
                margin-top: 10px;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h3 class="text-center text-uppercase text-success mt-3 mb-3">Xóa thông tin bệnh nhân</h3>
            <form action="?controller=deletePatient&id=<?= $patient->getId() ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="name" value="<?= $patient->getFullName(); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Giới tính</label>
                    <input type="text" class="form-control" id="gender" value="<?= $patient->getGender(); ?>" readonly>
                </div>
                <!-- Nút Submit gửi name btn_delete đi -->
                <button type="submit" class="btn btn-danger" name="btn_delete">Xóa</button>
            </form>
        </div>
    </body>
</html>