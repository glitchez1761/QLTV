<!DOCTYPE html>
<html>
    <body>
        <h1>Học lập trình PHP</h1>
        <?PHP
            echo "<hr>";
        ?>
        <p>Tài liệu học HTML</p>
        <p>Tài liệu học CSS</p>
        <?PHP
            echo "<h2>Tài liệu học PHP</h2>";
            echo "<h2>Tài liệu học MySQL</h2>";
            echo "<h2>Tài liệu học JaaScript</h2>";
        ?>
        <br>
        <?PHP
            $test = "Từ cơ bản " . " đến nâng cao";
            echo $test;
        ?>
        <br>
        <?PHP
            $text = " ở Hà Nội";
            echo "Tôi là " . " Nguyễn Văn A, " . " sinh năm " . 1990 . " làm việc " . $text;
        ?>
        <br>
        <?PHP
            $name = "Nguyễn Văn A";
            $year = 2000;
            echo "<p>Họ và tên: $name";
            echo "<p>Giới tính của $name là nam</p>";
            $new_year = $year + 7;
            echo "<p>Năm sinh của $name là $new_year";
            echo var_dump($year);
            echo var_dump($new_year);
            $len = strlen($name);
            echo "<p>Độ dài của chuỗi: $name là $len</p>";

            $a = str_word_count("HTML");
            $b = str_word_count("HTML CSS");
            echo "<p>Số từ của chuỗi HTML là $a</p>";
            echo "<p>Số từ của chuỗi HTML CSS là $b</p>";
            $c = str_word_count($name);
            echo "<p>Số từ của chuỗi $name là $c</p>";
            print_r(str_word_count($name, 1));
            print_r(str_word_count($name, 1, 'êăâ'));
        ?>
        <?PHP
            $number = 60;
            if($number > 50) {
                echo "<p>Tài liệu học HTML</p>";
                echo "<p>Tài liệu học CSS</p>";
            }
            else {
                echo "<p>Tài liệu học JavaScript</p>";
            }
        ?>
        <?PHP
            $day = getdate() ["wday"];
            if($day == 0){
                echo "Hôm nay là Chủ Nhật";
            }elseif($day == 1){
                echo "Hôm nay là Thứ Hai";
            }elseif($day == 2){
                echo "Hôm nay là Thứ Ba";
            }elseif($day == 3){
                echo "Hôm nay là Thứ Tư";
            }elseif($day == 4){
                echo "Hôm nay là Thứ Năm";
            }elseif($day == 5){
                echo "Hôm nay là Thứ Sáu";
            }else{
                echo "Hôm nay là Thứ Bảy";
            }
        ?>
        <br>
        <?PHP
            $money = 10000;
            switch ($money) {
                case 2000:
                    echo "Trà đá";
                    break;
                case 5000:
                    echo "Sting dâu";
                    break;
                case 10000:
                    echo "Cà phê đá";
                    break;
                case 12000:
                    echo "Cà phê sữa";
                    break;
            }
        ?>
        <?php
            $season = "hạ";
            switch ($season) {
                case "xuân":
                    echo "<p>Mùa xuân</p>";
                    break;
                case "hạ":
                    echo "<p>Mùa hạ</p>";
                    break;
                case "thu":
                    echo "<p>Mùa thu</p>";
                    break;
                case "đông":
                    echo "<p>Mùa đông</p>";
                    break;
            }
        ?>
        <?php
            for ($i = 1; $i <= 5; $i++){
                echo "<p>Lập trình $i</p>";
            }
        ?>
        <?php
            for($i = 0; $i < 5; $i++){
                echo "Số: " . ($i+1) . "<br>";
            }
        ?>
        <style>
            .square{
                height: 20px;
                width: 20px;
                float: left;
                border: 1px solid gray;
                margin-left: 5px;
                margin-bottom: 5px;
            }
        </style>
        <?php
            for($i = 0; $i < 5; $i++) {
                for($j = 0; $j < 10; $j++) {
                    echo "<div class='square'></div>";
                }
            }
            echo "<div style='clear:both'></div>";
        ?>
        <?php
            $mobile = array("HTC", "Nokia", "Samsung", "LG", "Apple");
            for($i = 0; $i < count($mobile); $i++){
                echo $mobile[$i]."<br/>";
            }
        ?>
        <?php
            $data = array("HTML", "CSS", "JavaScript", "MySQL", "PHP");
            foreach($data as $value){
                echo $value."<hr>";
            }
        ?>
        <?php
            $i = 1;
            echo "<hr>";
            while($i < 10) {
                echo "<p>" . $i . "</p>";
                //echo " " . $i . " ";
                $i++;
            }
        ?>
        <?php
            echo "<hr>";
            $i = 9;
            do{
               //echo "<p>" . $i . "</p>";
               echo "-" . $i . "-";
               $i--;
            }while($i > 0);
        ?>
        <?php
            echo "<hr>";
            $mobile = array("HTC", "Nokia", "Samsung", "LG", "Apple", "Lenovo");
            $i = 0;
            while($i < count($mobile)){
                echo " " . $mobile[$i] . " ";
                $i++;
            }
        ?>
        <?php
            $salaries = ['A' => 1000, 'B' => 2000, 'C' => 3000, 'D' => 4000];
            echo "<br/> salaries['B'] = " . $salaries['B'];
        ?>
        <?php
            function GioiThieuBanThan(){
                $name = "Nguyễn Văn An";
                $year = 1993;
                echo "<p>Tôi tên là $name sinh năm $year</p>";
            }
            GioiThieuBanThan();
        ?>
        <?php
            function GioiThieuBanThanCoBien($name, $year){
                echo "<p>Tôi tên là $name sinh năm $year</p>";
            }
            GioiThieuBanThanCoBien("Trình Giáo Kim", 1993);
            GioiThieuBanThanCoBien("La Thành", 1989);
            GioiThieuBanThanCoBien("Tấn Thúc Bảo", 1985);
        ?>
        <?php
            function number($a, $b){
                    return pow($a+$b,2);
            }
            $a = 5;
            $b = 2;
            $result = number($a,$b);
            echo "<p>Tổng bình phương của $a và $b là $result</p>";
        ?>
    </body>
</html>