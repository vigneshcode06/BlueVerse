<?php
include 'config.php';

if (isset($_POST['register'])) {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $password = $_POST['password'];

    // Validate password (at least 8 chars, 1 letter, 1 number)
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{8,}$/", $password)) {
        die("<script>alert('Password must be at least 8 characters long and include at least one letter and one number.'); window.history.back();</script>");
    }

    // Hash password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo "<script>alert('Username or Email already exists!'); window.history.back();</script>";
    } else {
        // Insert new user into database
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, dob, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $username, $email, $dob, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed! Try again.'); window.history.back();</script>";
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
