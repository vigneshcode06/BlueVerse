<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// If ?user=username is passed, show that user's profile
if (isset($_GET['user']) && !empty($_GET['user'])) {
    $usernameParam = $_GET['user'];

    $stmt = $conn->prepare("SELECT username, dob, profile_picture FROM users WHERE username = ?");
    $stmt->bind_param("s", $usernameParam);
    $stmt->execute();
    $stmt->bind_result($username, $dob, $profile_picture);
    if (!$stmt->fetch()) {
        echo "<h3>User not found.</h3>";
        exit();
    }
    $stmt->close();
} else {
    // No ?user=... passed — show logged-in user's profile
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, dob, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $dob, $profile_picture);
    $stmt->fetch();
    $stmt->close();
}

// Handle default profile picture
if (!$profile_picture || !file_exists($profile_picture)) {
    $profile_picture = "uploads/default.png"; // Ensure this file exists
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($username); ?>'s Profile</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2><?php echo htmlspecialchars($username); ?>'s Profile</h2>
    <img src="<?php echo htmlspecialchars($profile_picture); ?>" width="100" height="100" alt="Profile Picture">
    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></p>

    <?php if (!isset($_GET['user']) || $_GET['user'] === $_SESSION['username']) { ?>
        <!-- Only show "Edit Profile" for your own profile -->
        <a href="edit_profile.php">Edit Profile</a><br><br>
    <?php } ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
