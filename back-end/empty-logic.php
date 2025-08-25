<?php 
include "../config/config.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    // $user_id = $_SESSION['login'];

    $sql = "DELETE FROM trash WHERE user_id = $id";
    $result = mysqli_query($connection, $sql);

    if($result == TRUE){
        $_SESSION['success'] = "Trash emptied successfully";
        header("Location: ../front-end/trash.php");
    }else{
        $_SESSION['error'] = "Failed to empty trash";
        header("Location: ../front-end/trash.php");
    }

}