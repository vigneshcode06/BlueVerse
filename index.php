<?php
include 'config.php';
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BlueVerse Blog</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>BlueVerse Blog</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="blog-post">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
        </div>
    <?php endwhile; ?>
</body>
</html>

