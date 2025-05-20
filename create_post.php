<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        echo "<script>alert('Post Created Successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error creating post.');</script>";
    }

    $stmt->close();
}
?>

<textarea id="postContent" name="content" placeholder="Write your post..." required></textarea>
<p>Word Count: <span id="wordCount">0</span></p>

<script>
    const postContent = document.getElementById("postContent");

    // Load saved draft
    postContent.value = localStorage.getItem("draft") || "";

    // Save draft automatically
    postContent.addEventListener("input", function () {
        localStorage.setItem("draft", postContent.value);
        
        let words = this.value.trim().split(/\s+/).filter(word => word.length > 0);
        document.getElementById("wordCount").innerText = words.length;
    });
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post | BlueVerse</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Create a New Post</h2>
        <form action="" method="POST">
            <input type="text" name="title" placeholder="Post Title" required>
            <textarea id="postContent" name="content" placeholder="Write your post..." required></textarea>
            <p>Word Count: <span id="wordCount">0</span></p>
            <button type="submit">Post</button>
        </form>
    </div>

    <script>
        document.getElementById("postContent").addEventListener("input", function () {
            let words = this.value.trim().split(/\s+/).filter(word => word.length > 0);
            document.getElementById("wordCount").innerText = words.length;
        });
    </script>
</body>
</html>
