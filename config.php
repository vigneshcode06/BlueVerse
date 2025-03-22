<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "blueverse";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed!");
}
?>
 