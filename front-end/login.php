<?php include "../config/config.php";?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>NoteIt</title>
</head>
<body>
    <header class="navbar">
      <div class="log">
        <h1>NoteIt</h1>
      </div>
    </header>

    <?php 
      if (isset($_SESSION['success'])) {
        echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']); 
      }

      if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
      }
      
    ?>

    <main class="container">
      <h2 class="form-title">Log in to NoteIt</h2>

      <form action="../back-end/login-helper.php" method="POST" class="form-body">
         <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-input" placeholder="Enter your username" required />
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required />
          </div>

          <button type="submit" class="btn-primary" name="submit">Login</button>
      </form>

      <p class="enter-link">
        Don't have an account? <a href="register.php" class="link-text">Register</a>
      </p>
    </main>
</body>
</html>

