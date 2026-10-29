<?php
session_start();
//tiến hành kiểm tra là người dùng đẵ đăng nhập hay chưa, nếu chưa -> chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
    header('location: loginCSDL.php');
}
?>
<html>
    <head>
        <title>Trang chủ</title>
        <meta charset="utf-8">
    </head>
    <body>
        Chúc mừng bạn có username là <?php echo $_SESSION['username']; ?> đã đăng nhập thành công!
    </body>
</html>