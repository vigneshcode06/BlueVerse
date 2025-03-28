<?php
include 'config.php';

if (isset($_POST['add_comment'])) {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (post_id, comment) VALUES (?, ?)");
    $stmt->bind_param("is", $post_id, $comment);

    if ($stmt->execute()) {
        echo "<script>alert('Comment added!'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <link rel="icon"  href="tab.png"> </title>
</head>
<body>
    
</body>
</html>