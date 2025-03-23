<?php
session_start();
include 'config.php';

$result = $conn->query("SELECT posts.id, posts.title, posts.content, posts.image, users.username 
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
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['content']; ?></p>
                <?php if (!empty($row['image'])) { ?>
                    <img src="<?php echo $row['image']; ?>" alt="Post Image" style="max-width:100%; height:auto;">
                <?php } ?>
                <p>By <a href="profile.php?user=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a></p>
            </div>
        <?php } ?>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
