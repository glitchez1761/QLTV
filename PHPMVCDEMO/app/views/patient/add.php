<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
        <title>Thêm bệnh nhân</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
            <h3 class="text-center text-uppercase text-success mt-3 mb-3">Thêm bệnh nhân</h3>

            <form action="?controller=addPatient" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ tên" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Giới tính</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Chọn giới tính</option>
                        <option>0</option>
                        <option>1</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="btn_create" >Thêm bệnh nhân</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script>
            document.querySelector('form').addEventListener('submit', function(event) {
                if (document.querySelector('#gender').value === '') {
                    event.preventDefault();
                    alert('Vui lòng chọn giới tính.');
               }
            });
        </script>
    </body>
</html>