<?php
session_start();
include "database.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email']; // Assuming email is stored in session
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Password validation (Backend)
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        echo "Password must have at least 8 characters, 1 uppercase, 1 lowercase, 1 number, and 1 special character.";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Update password in database
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Password updated successfully!";
        header("Location: login.php"); // Redirect to login page
        exit();
    } else {
        echo "Error updating password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="newpass.css"> <!-- Link to CSS -->
</head>

<body>
    <div id='newpassword' class='newpassword'>
        <form action="reset_password.php" method="POST">
            <div id='inputfield' class='inputfield'>
                <div class='label'>Enter new password</div>
                <input type="password" name="new_password" id='input2' class='input2' placeholder="Enter password"
                    oninput="validatePassword('input2', 'passwordMessage')" required />
                <label>
                    <input type="checkbox" id="showPassword1" onclick="togglePasswordVisibility('input2', 'showPassword1')">
                    Show Password
                </label>
                <div id="passwordMessage" class="password-message"></div>
            </div>

            <div id='inputfield2' class='inputfield2'>
                <div class='label2'>Re-type new password</div>
                <input type="password" name="confirm_password" id='input4' class='input4' placeholder="Re-type password"
                    oninput="validateReTypePassword('input2', 'input4', 'retypePasswordMessage')" required />
                <label>
                    <input type="checkbox" id="showPassword2" onclick="togglePasswordVisibility('input4', 'showPassword2')">
                    Show Password
                </label>
                <div id="retypePasswordMessage" class="password-message"></div>

                <div class='buttongroup'>
                    <div class="cancel">
                        <a href="forgot.php"><button type="button" id='button4' class='button4'>Cancel</button></a>
                    </div>
                    <div class="done">
                        <button type="submit" id='button' class='button'>Done</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function validatePassword(inputId, messageId) {
            const password = document.getElementById(inputId).value;
            const messageElement = document.getElementById(messageId);
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (password === "") {
                messageElement.textContent = "";
            } else if (regex.test(password)) {
                messageElement.textContent = "Password is valid.";
                messageElement.style.color = "green";
            } else {
                messageElement.textContent = "Password must be at least 8 characters, contain 1 uppercase, 1 lowercase, 1 number, and 1 special character.";
                messageElement.style.color = "red";
            }
            messageElement.style.fontSize = "12px";
        }

        function validateReTypePassword(originalInputId, retypeInputId, messageId) {
            const originalPassword = document.getElementById(originalInputId).value;
            const retypePassword = document.getElementById(retypeInputId).value;
            const messageElement = document.getElementById(messageId);

            if (retypePassword === "") {
                messageElement.textContent = "";
            } else if (retypePassword === originalPassword) {
                messageElement.textContent = "";
            } else {
                messageElement.textContent = "Passwords do not match.";
                messageElement.style.color = "red";
            }
            messageElement.style.fontSize = "12px";
        }

        function togglePasswordVisibility(inputId, checkboxId) {
            const inputField = document.getElementById(inputId);
            const checkbox = document.getElementById(checkboxId);
            inputField.type = checkbox.checked ? "text" : "password";
        }
    </script>
</body>
</html>
