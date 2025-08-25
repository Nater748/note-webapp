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

    <main class="main-content">
        <h1 class="page-title">Trash</h1>
        <h3 class="section-title">Deleted Notes</h3>
    
    <?php
        // --- Pagination setup ---
        $limit = 5; // number of notes per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // Build SQL with or without search
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $search = $_GET['q'];
            $sql = "SELECT * FROM trash 
                    WHERE user_id = {$_SESSION['login']} 
                    AND (title LIKE '%$search%' OR body LIKE '%$search%') 
                    ORDER BY created_at DESC 
                    LIMIT $limit OFFSET $offset";

            $count_sql = "SELECT COUNT(*) AS total FROM trash 
                          WHERE user_id = {$_SESSION['login']} 
                          AND (title LIKE '%$search%' OR body LIKE '%$search%')";
        } else {
            $sql = "SELECT * FROM trash 
                    WHERE user_id = {$_SESSION['login']} 
                    ORDER BY deleted_at DESC 
                    LIMIT $limit OFFSET $offset";

            $count_sql = "SELECT COUNT(*) AS total FROM trash 
                          WHERE user_id = {$_SESSION['login']}";
        }

        // Run queries
        $result = mysqli_query($connection, $sql);
        $count_result = mysqli_query($connection, $count_sql);
        $total_row = mysqli_fetch_assoc($count_result)['total'];
        $total_pages = ceil($total_row / $limit);
    ?>

    <?php while ($row = mysqli_fetch_assoc($result)){?>
        <div class="note-item">
            <div class="note-info">
                <div class="note-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M88,96a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H96A8,8,0,0,1,88,96Zm8,40h64a8,8,0,0,0,0-16H96a8,8,0,0,0,0,16Zm32,16H96a8,8,0,0,0,0,16h32a8,8,0,0,0,0-16ZM224,48V156.69A15.86,15.86,0,0,1,219.31,168L168,219.31A15.86,15.86,0,0,1,156.69,224H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32H208A16,16,0,0,1,224,48Z"></path>
                    </svg>
                </div>
                <div>
                    <a href="view.php?id=<?php echo $row['id']?>" class="note-details"><p class="note-title"><?php echo $row['title']?></p></a>
                    <p class="note-date"><?php echo $row['deleted_at']?></p>
                </div>
            </div>
            <input type="hidden" name="trash_id" value="">
            <div class="btn-grid">
                <a href="../back-end/restore-logic.php?id=<?php echo $row['id']?>" class="btn-restore">Restore</a>
                <a href="../back-end/pdelete-logic.php?id=<?php echo $row['id']?>" class="btn-permanent">Delete</a>
            </div>
        </div>
    <?php } ?>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php if($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo isset($search) ? '&q=' . $search : ''; ?>">Previous</a>
            <?php endif; ?>

            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo isset($search) ? '&q=' . $search : ''; ?>" 
                   class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                   <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo isset($search) ? '&q=' . $search : ''; ?>">Next</a>
            <?php endif; ?>
        </div>

        <div class="trash-actions">
            <a href="../back-end/empty-logic.php?id=<?php echo $_SESSION['login']?>" class="btn-empty">Empty Trash</a>
        </div>
        
    </main>
</body>
</html>
