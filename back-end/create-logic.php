<?php
include "../config/config.php";
if(isset($_POST['submit'])) {
    $title = $_POST['title'];
    $importance = $_POST['note_color'];
    $body = $_POST['body'];
    $user_id = $_POST['user_id'];

    // echo $title;
    // echo $importance;       
    // echo $body;
    // echo $user_id;
    $sql = "INSERT INTO notes (title, importance, body, users_id) VALUES ('$title', '$importance', '$body', '$user_id')";
    $result = mysqli_query($connection, $sql);
    if($result) {
        header("Location: ../front-end/index.php");
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>