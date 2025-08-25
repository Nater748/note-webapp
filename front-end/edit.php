<?php include "../config/config.php"; ?>
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
        if (isset($_SESSION['error'])) {
            echo "<p style='color: green;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']); 
        }
      ?>
      <main class="container">
        <?php
        if(isset($_GET['id'])){
          $note_id = $_GET['id'];
          $sql = "SELECT * FROM notes WHERE id = '$note_id'";
          $result = mysqli_query($connection, $sql);
          $row = mysqli_fetch_assoc($result);
          $count = mysqli_num_rows($result);
          if($count > 0){
            $title = $row['title'];
            $body = $row['body'];
            $importance = $row['importance'];
          } else {
            echo "<p>No note found.</p>";
          }
        }else{
          header("Location: index.php");
        }
        ?>
        <form class="form-body" method="POST" action="../back-end/edit-logic.php">
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>" required>
          </div>
          <div class="form-group">
            <label>Note</label>
            <textarea name="body" ><?php echo $row['body']?></textarea>
          </div>
            <div class="color-picker">
                <input type="radio" name="note_color" id="color1" value="high"<?php if ($importance == 'high') echo 'checked'; ?> hidden>
                <label for="color1" class="color-circle" style="background-color: tomato;"></label>

                <input type="radio" name="note_color" id="color2" value="medium" <?php if ($importance == 'medium') echo 'checked'; ?> hidden>
                <label for="color2" class="color-circle" style="background-color: lightsalmon;"></label>

                <input type="radio" name="note_color" id="color3" value="low" <?php if ($importance == 'low') echo 'checked'; ?> hidden>
                <label for="color3" class="color-circle" style="background-color: lightyellow;"></label>
            </div>
          <input type="hidden" name="note_id" value="<?php echo isset($note_id) ? $note_id : ''; ?>">
          <div class="form-actions">
            <button type="submit" class="btn-save" name="update">Save Changes</button>
          </div>
        </form>
      </main>
</body>
</html>