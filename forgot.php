<?php
session_start();
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";

    if (!preg_match($emailPattern, $email)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Placeholder: Check if email exists in the database
        // Connect to database (update with actual credentials)
        $conn = new mysqli("localhost", "root", "", "amaers_login");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['reset_email'] = $email;
            header("Location: verification.php"); // Redirect to verification page
            exit();
        } else {
            $error_message = "Email not found. Please enter a registered email.";
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="forgot.css">
    <style>
        .error { color: red; font-size: 0.9em; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="forgotpassword">
        <img src="Key.png" alt="Key Icon" class="key">
        <div class="forgot">
            <p>FORGOT PASSWORD?</p>
        </div>
        <div class="enter">
            ENTER YOUR REGISTERED EMAIL TO SEND VERIFICATION
        </div>

        <div class="formforgotpassword">
            <form action="" method="POST">
                <div class="inputfield">
                    <label for="email" class="label">Email</label>
                    <input type="email" name="email" id="email" class="input2" placeholder="Enter your email" required>
                    <p class="error"> <?php echo $error_message; ?> </p>
                </div>
                <div class="buttongroup">
                    <a href="index.php">
                        <button type="button" class="button2">Cancel</button>
                    </a>
                    <button type="submit" class="button4">Verify</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
