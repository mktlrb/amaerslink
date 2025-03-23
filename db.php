<?php
$servername = "localhost"; // XAMPP default
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (empty)
$dbname = "admin_db"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
