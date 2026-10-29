<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Hospital Management</title>
</head>
<body>
    <div class="container">
        <h3 class="text-center text-uppercase text-success mt-3 mb-3">Quản lý bệnh nhân</h3>
        <a href="?controller=addPatient" class="btn btn-success">Thêm bệnh nhân mới</a>
        <table class="table mt-3">
    <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Full Name</th>
        <th scope="col">Gender</th>
        <th scope="col">Sửa</th>
        <th scope="col">Xóa</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($patients as $patient){
        ?>
            <tr>
                <th scope="row"><?= $patient->getID(); ?></th>
                <td><?= $patient->getFullName(); ?></td>
                <td><?= $patient->getGender(); ?></td>
                <td>
                    <a href="?controller=editPatient&id=<?=  $patient->getId() ?>">
                    <i class="bi bi-pencil-square"></i>
                </td>
                <td>
                    <a href="<?=  DOMAIN.'app/views/patient/delete.php?id='.$patient->getID() ?>">
                    <i class="bi bi-trash3"></i>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>