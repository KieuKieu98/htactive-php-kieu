
<?php
require_once "..connect/db.php";
if($_GET['id']){
    $id = $_GET['id'];
    $sql = "DELETE FROM chooses WHERE id = {$id}" ;
    $result = mysqli_query($connect, $sql);

};
?>