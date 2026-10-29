<html>
    <body>
        <form action= "<?php $_PHP_SELF ?>" method="GET">
            Tên: <input type="text" name="Ten" />
            Tuổi: <input type="text" name="Tuoi" />
            <input type="submit" name="btn_submit" value="submit"/>
        </form>

        <?php
            if (isset($_GET['btn_submit'])) {
                $Ten = $_GET['Ten'];
                $Tuoi = $_GET['Tuoi'];
                echo $Ten."".$Tuoi.'';
            }
        ?>
    </body>
</html>