<?php
session_start();
include 'config.php';

$result = $conn->query("SELECT posts.id, posts.title, posts.content, users.username 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        ORDER BY posts.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Posts</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>All Posts</h2>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['content']); ?></p>
                <p>By 
                    <a href="profile.php?user=<?php echo urlencode($row['username']); ?>">
                        <?php echo htmlspecialchars($row['username']); ?>
                    </a>
                </p>
            </div>
        <?php } ?>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
