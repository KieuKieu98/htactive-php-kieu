
<?php
require_once "../connect.php";
if($_GET['id']){
    $id = $_GET['id'];
    $sql = "DELETE FROM service WHERE id = {$id}" ;
    $result = mysqli_query($connect, $sql);
    if(isset($result)){
        // Records created successfully. Redirect to landing page
        header("location: service.php");
        exit();
    } else{
        echo "Something went wrong. Please try again later.";
    }
};
?>