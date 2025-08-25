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
            <h2>NoteIt</h2>
        </div>
    </header>

    <?php 
        if (isset($_SESSION['logs'])) {
            echo "<p style='color: red;'>" . $_SESSION['logs'] . "</p>";
            unset($_SESSION['logs']); 
        }
    ?>

    <main class="container">
        <h2>Create Your Account</h2>
        <form action="../back-end/registration-helper.php" method="post" class="form-body">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="cpassword" placeholder="confirm Password" required>
            <input type="text" name="username" placeholder="Username" required>
            <button type="submit" class="btn primary" name="submit">Register</button>
        </form>
        <p class="enter-link">Already have an account? <a href="login.php">Sign in</a></p>
    </main>
</body>
</html>