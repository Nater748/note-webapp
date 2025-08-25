<?php include '../config/config.php'; ?>
<?php
if(!isset($_SESSION['login'])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteIt</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

    <header class="header">
        <div class="logo">
            <h2>NoteIt</h2>
        </div>
        <nav class="nav-links">
            <a href="index.php">Home</a>
            <a href="notes.php">Notes</a>
            <a href="trash.php">Trash</a>
            <a href="logout.php">Log-Out</a>
        </nav>
    </header>
    <?php
        if (isset($_SESSION['success'])) {
            echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']); 
        }
    ?>



    <main class=" containers">
        <form action="../back-end/create-logic.php" method="POST" >
            <h1 class="section-title">Create New Note</h1>

            <div class="form-group">
                <input type="text" name="title" placeholder="Note Title" class="note-input" required />
            </div>

            <div class="form-group">
                <textarea name="body" placeholder="Write your note here..." class="note-textarea" required></textarea>
            </div>

            <div class="color-picker">
                <input type="radio" name="note_color" id="color1" value="high" hidden>
                <label for="color1" class="color-circle" style="background-color: tomato;"></label>

                <input type="radio" name="note_color" id="color2" value="medium" hidden>
                <label for="color2" class="color-circle" style="background-color: lightsalmon;"></label>

                <input type="radio" name="note_color" id="color3" value="low" hidden checked>
                <label for="color3" class="color-circle" style="background-color: lightyellow;"></label>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['login']; ?>">
            <div class="btn-container">
                <button type="submit" class="btn-save" name="submit">Save Note</button>
            </div>
        </form>

         <?php
            $sql = "SELECT * FROM notes WHERE users_id = '" . $_SESSION['login'] . "'LIMIT 3";
            $result = mysqli_query($connection, $sql);
            ?>

            <h2 class="section-title">Your Notes</h2>
            <div class="table-container">
                <table class="note-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Importance</th>
                            <th>Creation Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><a href="view.php?id=<?php echo $row['id']?>" class="tgh"><?php echo $row['title'];?></a></td>
                            <td><span class='badge <?= $row["importance"]?>'><?php echo $row['importance']?></span></td>
                            <td><?php echo $row['created_at']?></td>
                            <td class="action-links">
                                <a href="edit.php?id=<?php echo $row['id']?>" class="btn">Edit</a>
                                <a href="../back-end/delete-logic.php?id=<?php echo $row['id']?>" class="btn">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
