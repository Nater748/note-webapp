<?php include "../config/config.php"?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>NoteIt</title>
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
        $id = $_GET['id'];
        $sql1 = "SELECT * FROM notes WHERE users_id = {$_SESSION['login']} AND id = $id";
        $result1 = mysqli_query($connection, $sql1);
        $row1 = mysqli_fetch_assoc($result1);

        $sql2 = "SELECT * FROM trash WHERE user_id = {$_SESSION['login']} AND id = $id";
        $result2 = mysqli_query($connection, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        // Determine which record to use
        $note = $row1 ? $row1 : $row2;
    ?>

    <?php if($note){ ?>
        <div class="set">
            <h4><?= $note['title']?></h4>

            <!-- Color Picker (display only) -->
            <div class="color-picker">
                <input type="radio" name="note_color" id="color1" value="high"
                    <?php if ($note['importance'] == 'high') echo 'checked'; ?> disabled hidden>
                <label for="color1" class="color-circle" style="background-color: tomato;"></label>

                <input type="radio" name="note_color" id="color2" value="medium"
                    <?php if ($note['importance'] == 'medium') echo 'checked'; ?> disabled hidden>
                <label for="color2" class="color-circle" style="background-color: lightsalmon;"></label>

                <input type="radio" name="note_color" id="color3" value="low"
                    <?php if ($note['importance'] == 'low') echo 'checked'; ?> disabled hidden>
                <label for="color3" class="color-circle" style="background-color: lightyellow;"></label>
            </div>

            <br><br>
            <p><?= $note['body']?></p>
        </div>
    <?php } ?>
</body>
</html>
