<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        form{
            width: 30%;
            margin: auto;
        }
        button{
            margin-top: 10px;
            width: 100%;
        }
    </style>
    <title>Thêm bệnh nhân</title>
</head>
<body>
    <div class="container mt-5">

    <h3 class="text-center
                text-uppercase
                text-success
                mt-3 mb-3">
        Thêm bênh nhân
    </h3>

    <form  action="?controller=addPatient" method="post">

        <div class="mb-3">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gender" id="gender" class="form-select">
                <option value="">-- Chọn giới tính --</option>
                <option value="0">0</option>
                <option value="1">1</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="btn_create">Thêm</button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
        crossorigin="anonymous"></script>
    <script>
        document.querySelector('form').addEventListener('submit',function (e){
            if(document.querySelector('#gender').value === ''){
                e.preventDefault();
                alert('Vui lòng chọn giới tính');
            }
        });
    </script>

</body>
</html>