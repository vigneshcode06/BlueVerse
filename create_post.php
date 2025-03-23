<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $image = "";
    if (!empty($_FILES["image"]["name"])) {
        $image = "uploads/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $image);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Post Created!'); window.location='view_posts.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Create a New Post</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Post Title" required><br>
            <textarea name="content" placeholder="Write your post..." required></textarea><br>
            <input type="file" name="image"><br>
            <button type="submit" name="submit">Publish</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
