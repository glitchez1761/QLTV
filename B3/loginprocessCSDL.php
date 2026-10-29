<?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'testdb');
    //Kiểm tra nếu người dùng đã ấn nút đăng nhập thì mới xử lý
    if (isset($_POST["btn_submit"])) {
        //Lấy thông tin người dùng
        $username = $_POST["username"];
        $password = $_POST["password"];
        //Làm sạch thông tin, xóa bỏ các tag html, kí tự đặc biệt mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
        $username = strip_tags($username);
        $username = addslashes($username);
        $password = strip_tags($password);
        $password = addslashes($password);
        if ($username == "" || $password == "") {
            echo "username or password is not empty";
        } else {
            $sql = "select * from member where username = '$username' and password = '$password' ";
            $query = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($query);
            if ($num_rows == 0) {
                echo "username or password is not true !";
            } else {
                //tiến hành lưu tên đăng nhập vào session để tiện xử lý sau này
                $_SESSION["username"] = $username;
                //Thực thi hành động sau khi lưu thông tin vào session, ở đây mình tiến hành chuyển hướng tới 1 trang web gọi là index.php
                header('location: index.php');
            }
        }
    }
?>