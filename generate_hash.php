<?php
$password = 'admin123';  // Original password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password
echo "Hashed Password: " . $hashed_password;  // Display the hashed password
?>
