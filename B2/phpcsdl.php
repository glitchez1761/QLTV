<!DOCTYPE html>
<html>
    <body>
        <h1>Lập trình CSDL với PHP</h1>
        <?php
            echo "Câu lệnh Select:" . "<br/>";
            $connection = mysqli_connect('localhost', 'root', '', 'testdb') or die ("Lỗi kết nôi");
            mysqli_set_charset($connection, "utf8");
            $querySelect = "SELECT * FROM member";
            $results = mysqli_query($connection, $querySelect);
            if (mysqli_num_rows($results) > 0) {
                $members = mysqli_fetch_all($results, MYSQLI_ASSOC);
                foreach ($members as $member) {
                    echo "username: {$member['username']}"."<br/>";
                    echo "phone: {$member['phone']}"."<br/>";
                    //echo "password: {$member['password']}"."<br/>";
                }
            }
            mysqli_close($connection);
        ?>
        <?php
            /*echo "Câu lệnh Insert:" . "<br/>";
            $connection = mysqli_connect('localhost', 'root', '', 'testdb') or die ("Lỗi kết nôi");
            mysqli_set_charset($connection, "utf8");
            $sqlInsert = "INSERT INTO member (username, password, phone, email) VALUES ('annv', '12345', '0989570230', 'annv@gmail.com')";
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
            $sqlUpdate = "UPDATE member SET phone = '0981567898' WHERE id = 3";
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
            echo "Câu lệnh Delete:" . "<br/>";
            $connection = mysqli_connect('localhost', 'root', '', 'testdb') or die ("Lỗi kết nôi");
            mysqli_set_charset($connection, "utf8");
            $sqlDelete = "DELETE FROM member WHERE id = 2";
            $IsDeleteTable = mysqli_query($connection, $sqlDelete);
            if ($IsDeleteTable) {
                echo "Xóa dữ liệu thành công";
            }
            else {
                echo "Xóa dữ liệu thất bại";
            }
            mysqli_close($connection);*/
        ?>
        <?php
            echo "<br/>"."Câu lệnh Select PDO:"."<br/>";
            const DB_DSN = 'mysql:host=localhost;dbname=testdb';
            const DB_USERNAME = 'root';
            const DB_PASSWORD = ''; 
            try {
                $connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $sqlSelect = "Select * from member WHERE id = ?";
                $querySelect = $connection->prepare($sqlSelect);
                $querySelect->bindParam(1, $id);
                //gán giá trị
                $id = "1";
                //thực thi
                $isSelect = $querySelect->execute();
                $members = $querySelect->fetchAll(PDO::FETCH_ASSOC);
                foreach ($members as $member) {
                    echo "username: {$member['username']}"."<br/>";
                    //echo "password: {$member['password']}"."<br/>";
                }
                echo "Truy vấn dữ liệu thành công";
            }
            catch (PDOException $e) {
                echo "Connection failed: ". $e->getMessage();
            }
            $connection = null;
        ?>
        <?php
            /*echo "<br/>"."Câu lệnh Insert PDO:"."<br/>";
            try {
                $connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $sqlInsert = "INSERT INTO member (username, password, phone, email) VALUES (?, ?, ?, ?)";
                $queryInsert = $connection->prepare($sqlInsert);
                $queryInsert->bindParam(1, $username);
                $queryInsert->bindParam(2, $password);
                $queryInsert->bindParam(3, $phone);
                $queryInsert->bindParam(4, $email);   
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
            $connection = null;*/
        ?>
        <?php
           echo "<br/>"."Câu lệnh Delete PDO:"."<br/>";
           try {
               $connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
               $sqlDelete = "DELETE from member WHERE id = ?";
               $queryDelete = $connection->prepare($sqlDelete);
               $queryDelete->bindParam(1, $id);
               //gán giá trị
               $id = "5";
               //thực thi
               $isDelete = $queryDelete->execute();
               echo "Xóa dữ liệu PDO thành công";
           }
           catch (PDOException $e) {
               echo "Connection failed: ". $e->getMessage();
           }
           $connection = null;
        ?>
    </body>
</html>