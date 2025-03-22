<?php
// Database connection
$host = 'localhost';
$db = 'your_database_name';
$user = 'your_username';
$pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verificationCode = trim($_POST['verificationCode']);
    
    // Check if the code is exactly 8 characters long
    if (strlen($verificationCode) === 8) {
        // Here you would typically check the code against the database
        // For example:
        $stmt = $pdo->prepare("SELECT * FROM verification_codes WHERE code = ?");
        $stmt->execute([$verificationCode]);
        
        if ($stmt->rowCount() > 0) {
            // Code is valid, redirect to new password page
            header("Location: newpass.php");
            exit();
        } else {
            $errorMessage = "Invalid verification code.";
        }
    } else {
        $errorMessage = "The verification code must be exactly 8 characters long.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="verification.css"> <!-- Link to your CSS file -->
    <style>
        .error-message {
            color: red;
            margin-top: 10px;
            display: <?= isset($errorMessage) ? 'block' : 'none' ?>;
        }
    </style>
</head>

<body>

    <img src="Check circle.png" alt="checkcircle" class="checkcircle"> <!-- Ensure the image path is correct -->

    <div class="emailverification">
        <div class="sent">
            THE VERIFICATION CODE HAS BEEN SENT.<br> KINDLY CHECK YOUR INBOX.
        </div>

        <form method="POST" action="">
            <div class="inputfield">
                <label for="input2" class="label">Verification Code</label>
                <input type="text" id="input2" name="verificationCode" class="input2" placeholder="Enter code" />
            </div>

            <div class="buttongroup">
                <a href="index.html">
                    <button type="button" class="button3">Cancel</button>
                </a>
                <button type="submit" id="verifyButton" class="button">Verify</button>
            </div>

            <div id="error-message" class="error-message"><?= isset($errorMessage) ? htmlspecialchars($errorMessage) : '' ?></div>
        </form>
    </div>

    <script>
        document.getElementById('verifyButton').addEventListener('click', function (event) {
            const inputField = document.getElementById('input2');
            const errorMessage = document.getElementById('error-message');
            const verificationCode = inputField.value.trim();

            if (verificationCode.length === 8) {
                errorMessage.style.display = 'none'; // Hide error message
            } else {
                errorMessage.style.display = 'block'; // Show error message
            }
        });

        // Live validation while typing
        document.getElementById('input2').addEventListener('input', function () {
            const errorMessage = document.getElementById('error-message');
            if (this.value.length > 8) {
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';
            }
        });
    </script>
</body>

</html> 
