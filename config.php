<?php
// Enable strict error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";  // Change if needed
$user = "root";       // Your database username
$pass = "";           // Your database password
$dbname = "blueverse"; // Database name

try {
    // Secure MySQL connection
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8mb4"); // Ensure proper encoding
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>


