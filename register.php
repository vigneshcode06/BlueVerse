<?php
include 'config.php';

if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo "<script>alert('Username or Email already exists!');</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, dob, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $username, $email, $dob, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed! Try again.');</script>";
        }
        $stmt->close();
    }
    $checkUser->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | BlueVerse</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Register</h2>
    <form action="" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="date" name="dob" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>

