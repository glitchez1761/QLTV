<!DOCTYPE html>
<html lang="vi">
<body>
    <?php
        function giaiThua($n) {
            if (!is_int($n) || $n < 0) {
                return false;
            }
            
            $result = 1;
            for ($i = 2; $i <= $n; $i++) {
                $result *= $i;
            }
            return $result;
        }

        $n = 10;
        $ketqua = giaiThua($n);

        if ($ketqua !== false) {
            echo "<p>{$n}! = {$ketqua}</p>";
        } else {
            echo "<p>Giá trị {$n} không hợp lệ để tính giai thừa!</p>";
        }
    ?>
</body>
</html>