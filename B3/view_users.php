<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form method="get" action="view_users.php" class="form">
            <h2>Danh sách thành viên</h2>
            <table border="1">
                <tr>
                    <td>ID</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Phone</td>
                </tr>
                <?php
                    $conn = mysqli_connect('localhost', 'root', '', 'testdb');
                    $query = mysqli_query($conn,"select * from member ");
                    while ($row=mysqli_fetch_array($query)) {
                ?>  
                        <tr>
                            <td><?php echo $row['id']?></td>
                            <td><?php echo $row['username']?></td>
                            <td><?php echo $row['email']?></td>
                            <td><?php echo $row['phone']?></td>
                            <td><a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                            <td><a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        </form>
    </body>
</html>