<?php
include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        echo "<script>alert('Post added successfully!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Failed to add post. Try again!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="C:\xampp\htdocs\web\BlueVerse\assets\tab.png">
    <title>Add Post</title>
</head>
<body>
    <h2>Add a Blog Post</h2>
    <form action="" method="POST">
        <input type="text" name="title" placeholder="Post Title" required><br>
        <textarea name="content" placeholder="Write your post here..." required></textarea><br>
        <button type="submit" name="add_post">Publish</button>
    </form>
</body>
</html>
