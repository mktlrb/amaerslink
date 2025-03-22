<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usn = trim($_POST['USN']);
    $password = trim($_POST['password']);

    // Validate USN
    if (!preg_match('/^\d{1,12}$/', $usn)) {
        die("Invalid USN format.");
    }

    $sql = "SELECT id, password FROM users WHERE usn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['usn'] = $usn;
            echo "success";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "USN not found.";
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
    <title>AMAERS Login</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <img class="logo" src="logo.png" alt="AMA Logo">
        <p class="welcomeamaers">WELCOME AMAERS!</p>
        <p class="logintoaccesstheplatform">LOG IN TO ACCESS THE PLATFORM</p>
        <p class="text-center small text-secondary" style="font-weight: bold; font-size: 12px;">
            THIS IS AMAER’S LINK. EXCLUSIVELY FOR AMA COMPUTER COLLEGE LIPA CAMPUS ONLY.
        </p>

        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger"> <?php echo $error_message; ?> </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3 inputfield">
                <label for="USN" class="form-label">USN</label>
                <input type="text" class="form-control" name="USN" id="USN" placeholder="Enter your USN" required>
            </div>

            <div class="mb-3 inputfield">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <div class="buttongroup">
                <button type="submit" class="btn btn-primary">Sign In</button>
                <div class="textlink">
                    <a href="forgot.html">Forgot password?</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>