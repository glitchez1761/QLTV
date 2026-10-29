<?php
include_once('connect.php');
if (isset($_REQUEST['id']) and $_REQUEST['id'] != "") {
    $id = $_GET["id"];
    $sql = "DELETE FROM member WHERE id='$id'";
    if ($conn ->query($sql) === TRUE) {
        echo "Delete success!";
    } else {
        echo "Error updating record: ". $conn ->error;
    }
    $conn->close();
}
?>