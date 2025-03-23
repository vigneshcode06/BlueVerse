<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

// Fetch current user data
$stmt = $conn->prepare("SELECT username, email, dob, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $dob, $profile_picture);
$stmt->fetch();
$stmt->close();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_dob = $_POST['dob'];

    // Handle profile picture upload
    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_dir = "uploads/";
        
        // Create directory if not exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = basename($_FILES["profile_picture"]["name"]);
            } else {
                $msg = "Error uploading file!";
            }
        } else {
            $msg = "Invalid file type! Only JPG, JPEG, PNG & GIF allowed.";
        }
    }

    // Update user data in the database
    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, dob=?, profile_picture=? WHERE id=?");
    $stmt->bind_param("ssssi", $new_username, $new_email, $new_dob, $profile_picture, $user_id);

    if ($stmt->execute()) {
        $msg = "Profile updated successfully!";
    } else {
        $msg = "Error updating profile.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    <p style="color:red;"><?php echo $msg; ?></p>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required><br>

        <label>Profile Picture:</label>
        <input type="file" name="profile_picture"><br>
        <?php if ($profile_picture) : ?>
            <img src="uploads/<?php echo $profile_picture; ?>" width="100"><br>
        <?php endif; ?>

        <button type="submit">Update Profile</button>
    </form>
    
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
