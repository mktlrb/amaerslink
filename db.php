<?php
// Database connection settings for XAMPP
$servername = "localhost";  // MySQL server is running on the same machine
$username = "root";         // Default MySQL username in XAMPP
$password = "";             // Default password for MySQL in XAMPP (empty by default)
$dbname = "admin_db";    // Your database name (should match the database where 'admin' table exists)

// Create a connection to MySQL server
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If the connection fails, output the error and stop the script
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can print a message if the connection is successful
// echo "Connected successfully to the database!";
?>
