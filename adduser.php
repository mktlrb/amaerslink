<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $generated_password = substr(md5(time()), 0, 8); // Generate random 8-character password
    $hashed_password = password_hash($generated_password, PASSWORD_DEFAULT);

    if ($role === 'student') {
        $usn = trim($_POST['usn']);
        $student_type = $_POST['student_type'];

        $stmt = $conn->prepare("INSERT INTO users (usn, name, email, password, role, student_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $usn, $name, $email, $hashed_password, $role, $student_type);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
    }

    if ($stmt->execute()) {
        // Send email only for students
        if ($role === 'student') {
            $to = $email;
            $subject = "Your Account Credentials";
            $message = "Hello $name,\n\nYour account has been created.\n\nEmail: $email\nPassword: $generated_password\n\nPlease change your password after login.";
            $headers = "From: admin@yourdomain.com";

            mail($to, $subject, $message, $headers);
        }

        $_SESSION['message'] = "User added successfully!";
    } else {
        $_SESSION['error'] = "Error adding user.";
    }

    header("Location: Addusers.php");
    exit();
}
?>
