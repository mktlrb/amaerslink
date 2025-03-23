<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $role = $_POST['role'];
        $name = trim($_POST['name']);
        $email = strtolower(trim($_POST['email'])); // Convert to lowercase to avoid duplicates
        $generated_password = substr(md5(time()), 0, 8); // Generate random 8-character password
        $hashed_password = password_hash($generated_password, PASSWORD_DEFAULT);

        // Check if email already exists
        $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_email->store_result();
        if ($check_email->num_rows > 0) {
            $_SESSION['error'] = "Email already exists!";
            header("Location: addusers.php");
            exit();
        }
        $check_email->close();

        if ($role === 'student') {
            $usn = trim($_POST['usn']);
            $student_type = $_POST['student_type'];

            // Check if USN already exists
            $check_usn = $conn->prepare("SELECT id FROM users WHERE usn = ?");
            $check_usn->bind_param("s", $usn);
            $check_usn->execute();
            $check_usn->store_result();
            if ($check_usn->num_rows > 0) {
                $_SESSION['error'] = "USN already exists!";
                header("Location: Addusers.php");
                exit();
            }
            $check_usn->close();

            // Insert new student user
            $stmt = $conn->prepare("INSERT INTO users (usn, name, email, password, role, student_type) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $usn, $name, $email, $hashed_password, $role, $student_type);
        } else {
            // Insert new admin or facilitator
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
        }

        if ($stmt->execute()) {
            // Send email only for students
            if ($role === 'student') {
                $to = $email;
                $subject = "Your Account Credentials";
                $message = "Hello $name,\n\nYour account has been created.\n\nEmail: $email\nPassword: $generated_password\n\nPlease change your password after login.";
                $headers = "From: admin@yourdomain.com\r\n";
                $headers .= "Reply-To: admin@yourdomain.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8";

                mail($to, $subject, $message, $headers);
            }

            $_SESSION['message'] = "User added successfully!";
        } else {
            $_SESSION['error'] = "Error adding user: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();

        header("Location: Addusers.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: Addusers.php");
        exit();
    }
}
?>
