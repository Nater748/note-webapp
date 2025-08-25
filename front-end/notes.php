<?php include "../config/config.php";?>

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
        </nav>

        <div class="search-profile">
            <div class="search-box">
                <form method="GET" action="notes.php">
                    <input type="text" name="q" placeholder="Search" value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">
                </form>
            </div>
            <a href="logout.php">Log-Out</a>    
        </div>
        </header>
        <main class="main-content">
        <h1 class="page-title">My Notes</h1>
        <br> <br>

        <?php
        //  PAGINATION LOGIC 
        $results_per_page = 5; // notes per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $results_per_page;

        // Count total rows
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $search = $_GET['q'];
            $count_sql = "SELECT COUNT(*) AS total FROM notes 
                          WHERE users_id = {$_SESSION['login']} 
                          AND (title LIKE '%$search%' OR body LIKE '%$search%')";
        } else {
            $count_sql = "SELECT COUNT(*) AS total FROM notes WHERE users_id = {$_SESSION['login']}";
        }
        $count_result = mysqli_query($connection, $count_sql);
        $total_rows = mysqli_fetch_assoc($count_result)['total'];
        $total_pages = ceil($total_rows / $results_per_page);

        // Fetch notes with LIMIT + OFFSET
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $search = $_GET['q'];
            $sql = "SELECT * FROM notes WHERE users_id = {$_SESSION['login']} 
                    AND (title LIKE '%$search%' OR body LIKE '%$search%') 
                    ORDER BY created_at DESC 
                    LIMIT $results_per_page OFFSET $offset";
        } else {
            $sql = "SELECT * FROM notes WHERE users_id = {$_SESSION['login']} 
                    ORDER BY created_at DESC 
                    LIMIT $results_per_page OFFSET $offset";
        }
        $result = mysqli_query($connection, $sql);
        // ---------------------------------------------------
        ?>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="note-item">
            <div class="note-info">
                <div class="note-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M88,96a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H96A8,8,0,0,1,88,96Zm8,40h64a8,8,0,0,0,0-16H96a8,8,0,0,0,0,16Zm32,16H96a8,8,0,0,0,0,16h32a8,8,0,0,0,0-16ZM224,48V156.69A15.86,15.86,0,0,1,219.31,168L168,219.31A15.86,15.86,0,0,1,156.69,224H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32H208A16,16,0,0,1,224,48Z"></path>
                    </svg>
                </div>
                <div>
                    <a href="view.php?id=<?php echo $row['id']?>"class="note-details"><p class="note-title"><?php echo $row['title']?>.</p></a>
                    <p class="note-date"><?php echo $row['created_at']?>.</p>
                    <p class="note-date"><?php echo substr($row['body'], 0, 90) . '...'; ?></p>
                </div>
            </div>
            <div class="btn-group">
              <a href="../back-end/delete-logic.php?id=<?php echo $row['id']?>" class="btn-delete">Delete</a>
              <a href="../front-end/edit.php?id=<?php echo $row['id']?>" class="btn-edit">Edit</a>
            </div>
        </div>
        <?php } ?>

        <!-- Pagination links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="notes.php?page=<?php echo $page - 1; ?><?php echo isset($_GET['q']) ? '&q='.urlencode($_GET['q']) : ''; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="notes.php?page=<?php echo $i; ?><?php echo isset($_GET['q']) ? '&q='.urlencode($_GET['q']) : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="notes.php?page=<?php echo $page + 1; ?><?php echo isset($_GET['q']) ? '&q='.urlencode($_GET['q']) : ''; ?>">Next</a>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>
