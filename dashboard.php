<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - BlueVerse</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <div class="buttons">
            <a href="create_post.php" class="btn">Create Post</a>
            <a href="view_posts.php" class="btn">View Posts</a>
            <a href="logout.php" class="btn logout">Logout</a>
        </div>
    </div>
</body>
</html>
