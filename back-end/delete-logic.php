<?php
include "../config/config.php";

if(isset($_GET['id'])){
    $note_id = $_GET['id'];
    $user_id = $_SESSION['login'];
    $sql = "SELECT * FROM notes WHERE id= $note_id AND users_id= $user_id";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_assoc($result);

    $title = $row['title'];
    $body = $row['body'];
    $importance = $row['importance'];

    $sql2 = "INSERT INTO trash (title, body, importance, user_id) VALUES ('$title', '$body', '$importance', $user_id)";
    $result2 = mysqli_query($connection, $sql2);

    if($result2 == TRUE){
        $sql3 = "DELETE FROM notes WHERE id = $note_id";
        $result3 = mysqli_query($connection, $sql3);

        if($result3 == TRUE){
            $_SESSION['success'] = "Note Moved to trash successfully";
            header("Location: ../front-end/index.php");
        }else{
            $_SESSION['error'] = "Failed to move to trash";
            header("Location: ../front-end/index.php");
        }
    }else{
        $_SESSION['error'] = "Failed to Delete";
        header("Location: ../front-end/index.php");
    }
}