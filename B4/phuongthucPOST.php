<html>
    <body>
        <form action= "<?php $_PHP_SELF ?>" method="POST">
            Tên: <input type="text" name="Ten" />
            Tuổi: <input type="text" name="Tuoi" />
            <input type="submit" name="btn_submit" value="submit"/>
        </form>

        <?php
            if (isset($_POST['btn_submit'])) {
                $Ten = $_POST['Ten'];
                $Tuoi = $_POST['Tuoi'];
                echo $Ten."".$Tuoi.'';
            }
        ?>
    </body>
</html>