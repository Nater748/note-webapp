<?php
include "../config/config.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $user_id = $_SESSION['login'];

    $sql = "SELECT * FROM trash where id = $id AND user_id = $user_id";
    $result = mysqli_query($connection, $sql);
    $row =  mysqli_fetch_assoc($result);

    $title = $row['title'];
    $body = $row['body'];
    $importance = $row['importance'];

    $sql2 = "INSERT INTO notes (title, body, importance, users_id) VALUES('$title', '$body', '$importance', $user_id)";
    $result2 = mysqli_query($connection, $sql2);

    if($result2 == TRUE){
        $sql3 = "DELETE FROM trash WHERE id = $id";
        $result3 = mysqli_query($connection, $sql3);

        if($result3 == TRUE){
            $_SESSION['success'] = "Note Restored Successfully";
            header("Location: ../front-end/index.php");
        }else{
            $_SESSION['error'] = "Failed to Restore";
            header("Location: ../front-end/trash.php");
        }
    }else{
        $_SESSION['error'] = "Failed to Delete";
        header("Location: ../front-end/trash.php");
    }
}