<?php
include "../config/config.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM trash WHERE id =$id AND user_id = $user_id";
    $result = mysqli_query($connection, $sql);

    if($result == TRUE){
        $_SESSION['success'] = "Deleted Successfully";
        header("Location: ../front-end/trash.php");
    }else{
        $_SESSION['error'] = "Failed to delete";
        header("Location: ../front-end/trash.php");
    }
}