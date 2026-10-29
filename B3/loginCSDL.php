<html>
    <head>
        <tilte>Trang đăng nhập</tilte>
        <!--<meta charset="utf-8>-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form method="POST" action="loginCSDL.php" class="form">
            <fieldset>
                <legend>Đăng nhập</legend>
                    <table>
                        <tr>
                            <td>Username</td>
                            <td><input type="text" name="username" size="30"></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type="text" name="password" size="30"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"> <input type="submit" name="btn_submit" value="Đăng nhập"></td>
                            <?php require 'loginprocessCSDL.php';?>
                        </tr>
                    </table>
            </fieldset>
        </form>
    </body>
</html>