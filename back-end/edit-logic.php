<?php
include "../config/config.php";
if(isset($_POST['update'])) {
    $title = $_POST['title'];
    $importance = $_POST['note_color'];
    $body = $_POST['body'];
    $note_id = $_POST['note_id'];

    $sql = "UPDATE notes 
            SET title = '$title', 
                body = '$body', 
                importance = '$importance', 
                updated_at = CURRENT_TIMESTAMP
            WHERE id = $note_id";

    $result = mysqli_query($connection, $sql);

    if ($result) {
        $_SESSION['success'] = "Note updated successfully!";
        header("Location: ../front-end/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update note.";
        header("Location: ../front-end/edit.php?id=$note_id");
        exit();
    }
}
?>