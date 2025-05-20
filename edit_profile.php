<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT full_name, username, bio, profile_picture FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $username, $bio, $profile_picture);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $bio = $_POST['bio'];
    $new_profile_picture = $profile_picture;

    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_dir = "uploads/";
        $new_profile_picture = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $new_profile_picture);
    }

    $stmt = $conn->prepare("UPDATE users SET full_name=?, bio=?, profile_picture=? WHERE id=?");
    $stmt->bind_param("sssi", $full_name, $bio, $new_profile_picture, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile | BlueVerse</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="full_name" value="<?php echo $full_name; ?>" required>
            <textarea name="bio" placeholder="Your Bio"><?php echo $bio; ?></textarea>

            <label>Profile Picture</label>
            <input type="file" id="profilePicInput" name="profile_picture" accept="image/*">
            <img id="profilePicPreview" src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-pic">

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <script>
        document.getElementById("profilePicInput").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById("profilePicPreview").src = URL.createObjectURL(file);
            }
        });
    </script>
</body>
</html>
