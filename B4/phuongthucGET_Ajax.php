<html>
    <head>
        <meta charset="utf-8">
        <title>OpenStreetMap &amp; OpenLayers - Market Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <form action= "<?php $_PHP_SELF ?>" method="GET">
            Tên: <input type="text" id="Ten" name="Ten" />
            Tuổi: <input type="text" id="Tuoi" name="Tuoi" />
            <input type="button" value="Click me" onclick="showMessage()"/>
        </form>
        <script>
            function showMessage() {
                alert('Sự kiện click xảy ra!');
                var ten = document.getElementById('Ten').value;
                var tuoi = document.getElementById('Tuoi').value;
                alert(ten);
                alert(tuoi);

                $.ajax ({
                    type: "POST",
                    url: "xulyPhuongThucGET_Ajax.php",

                    data: {functionname: 'testAjax', name: ten, age: tuoi},
                    success: function (result, status, error) {
                        alert(result);
                    },
                    error: function (req, status, error) {
                        alert(req + " " + status + " " + error);
                    }
                })
            }
        </script>
    </body>
</html>