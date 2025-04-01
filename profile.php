<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, dob, profile_picture FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $dob, $profile_picture);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Profile</h2>
    <img src="uploads/<?php echo $profile_picture ? $profile_picture : 'default.png'; ?>" width="100" height="100" alt="Profile Picture">
    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
    <a href="edit_profile.php">Edit Profile</a>
    <br><br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
