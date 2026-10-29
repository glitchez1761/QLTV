<?php
    if (isset($_POST['functionname'])) {
        $functionname = $_POST['functionname'];

        $aResult = "null";
        if ($functionname == 'testAjax') {
            $Ten = $_POST['name'];
            $Tuoi = $_POST['age'];
            $aResult = $Ten." ".$Tuoi;
        }
        echo $aResult;
    }
?>