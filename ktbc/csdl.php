<!DOCTYPE html>
<html>
    <body>
        <h1>Lập trình CSDL với PHP</h1>
        <?php
            echo "Câu lệnh Insert:" . "<br/>";
            $connection = mysqli_connect('localhost', 'root', '', 'testdb') or die ("Lỗi kết nôi");
            mysqli_set_charset($connection, "utf8");
            $sqlInsert = "INSERT INTO sv (ID, NAME, CLASS, FACILITY) VALUES ('1', 'Hùng', '66HTTT2', 'CNTT')";
            $IsInsertTable = mysqli_query($connection, $sqlInsert);
            if ($IsInsertTable) {
                echo "Insert dữ liệu thành công";
            } 
            else {
                echo "Insert dữ liệu thất bại";
            }
            mysqli_close($connection);
        ?>
        <?php
            echo "Câu lệnh Update:" . "<br/>";
            $connection = mysqli_connect('localhost', 'root', '', 'testdb') or die ("Lỗi kết nôi");
            mysqli_set_charset($connection, "utf8");
            $sqlUpdate = "UPDATE member SET CLASS = '64KTPM1' WHERE id = 1";
            $IsUpdateTable = mysqli_query($connection, $sqlUpdate);
            if ($IsUpdateTable) {
                echo "Update dữ liệu thành công";
            }
            else {
                echo "Update dữ liệu thất bại";
            }
            mysqli_close($connection);
        ?>
        <?php
            const DB_DSN = 'mysql:host=localhost;dbname=testdb';
            const DB_USERNAME = 'root';
            const DB_PASSWORD = '';
        ?>
        <?php
            echo "<br/>"."Câu lệnh Insert PDO:"."<br/>";
            try {
                $connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $sqlInsert = "INSERT INTO member (ID, NAME, CLASS, FACILITY) VALUES (?, ?, ?, ?)";
                $queryInsert = $connection->prepare($sqlInsert);
                $queryInsert->bindParam(1, $id);
                $queryInsert->bindParam(2, $name);
                $queryInsert->bindParam(3, $class);
                $queryInsert->bindParam(4, $facility);   
                //gan giá trị
                $username = "annv_PDO";
                $password = "123456";
                $phone = "0989731248";
                $email = "hd28373@gmail.com";
                //thực thi
                $isInsert = $queryInsert->execute();
                echo "Thêm dữ liệu thành công";
            }
            catch (PDOException $e){
                echo "Connection failed: ". $e->getMessage();
            }
            $connection = null;
        ?>
        <?php
            echo "<br/>"."Câu lệnh Update PDO:"."<br/>";
            try {
                $connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $sqlUpdate = "UPDATE member SET username = ? WHERE id = ?";
                $queryUpdate = $connection->prepare($sqlUpdate);
                $queryUpdate->bindParam(1, $username);
                $queryUpdate->bindParam(2, $id);
                //gán giá trị
                $username = "annv_PDO_1";
                $id = "5";
                //thực thi
                $isUpdate = $queryUpdate->execute();
                echo "Sửa dữ liệu thành công";
            }
            catch (PDOException $e) {
                echo "Connection failed: ". $e->getMessage();
            }
            $connection = null;
        ?>
    </body>
</html>