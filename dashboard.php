<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link rel="icon"  href="tab.png">
    <style>
        body {
            background-color: #0a0f1f;
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .navbar {
            background-color: #001f3f;
            padding: 15px;
            display: flex;
            justify-content: space-around;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
        }
        .navbar a:hover {
            background-color: #0074cc;
            border-radius: 5px;
        }
        .container {
            margin-top: 50px;
        }
        .welcome {
            font-size: 22px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">🏠 Home</a>
        <a href="create_post.php">📝 Create Post</a>
        <a href="view_posts.php">📜 View Posts</a>
        <a href="profile.php">👤 Profile</a>
        <a href="logout.php" style="color: red;">🚪 Logout</a>
    </div>

    <div class="container">
        <h2 class="welcome">Welcome, <span style="color: #0074cc;"><?php echo htmlspecialchars($username); ?></span>🙋‍♂️</h2>
        <p> I built a test site to learn and exploit authentication flaws like session fixation, broken session management, and cache-based authentication bypass etc  🚀</p>
        <p> This is a test site for educational purposes only, not a real platform</p>
    </div>
</body>
</html>
<a href="create_post.php">Create Post</a>
<a href="view_posts.php">View Posts</a>

