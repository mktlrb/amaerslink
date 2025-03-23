<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Prepare and execute query
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true); // Prevent session fixation attacks
            $_SESSION["users"] = $user['username']; // Store username in session
            header("Location: Dashboard.php");
            exit();
        }
    }

    $_SESSION["error"] = "Incorrect username or password!";
    header("Location: AdminLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="AdminLogin.css">
</head>
<body>
    <div class="login-container">
        <h2><i class="fas fa-user-shield"></i> Admin Login</h2>

        <?php if (isset($_SESSION["error"])): ?>
            <div class="alert alert-danger">
                <?php 
                echo htmlspecialchars($_SESSION["error"]); 
                unset($_SESSION["error"]);
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="AdminLogin.php" autocomplete="off">
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required oninput="validateUsername()" autocomplete="off">
        </div>
        <small id="usernameError" class="text-danger"></small> <!-- Error message -->

        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    </div>

    <script>
    // Automatically remove error message after 3 seconds
    setTimeout(function() {
        let alertBox = document.querySelector(".alert");
        if (alertBox) {
            alertBox.style.transition = "opacity 0.1s";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 100);
        }
    }, 1000);

    function validateUsername() {
        let usernameInput = document.getElementById("username");
        let errorMessage = document.getElementById("usernameError");
        let usernameValue = usernameInput.value;

        // Regular expression to check if username contains any number
        if (/\d/.test(usernameValue)) {
            errorMessage.textContent = "Username should not contain numbers!";
            usernameInput.classList.add("is-invalid"); // Bootstrap red border
        } else {
            errorMessage.textContent = "";
            usernameInput.classList.remove("is-invalid");
        }
    }

    // Auto-hide error message after 3 seconds
    setTimeout(function() {
        let alertBox = document.querySelector(".alert");
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);

        // Clear input fields when page loads
        window.onload = function() {
        document.getElementById("username").value = "";
        document.getElementById("password").value = "";
    };

    window.onload = function() {
        // Gumamit ng timeout para ma-reset ang fields matapos ma-load ang page
        setTimeout(() => {
            document.getElementById("username").value = "";
            document.getElementById("password").value = "";
        }, 100); // Delay para hindi agad mapalitan ng auto-fill ng browser

        // Subukan din burahin ang auto-fill ng browser
        document.getElementById("username").setAttribute("autocomplete", "new-username");
        document.getElementById("password").setAttribute("autocomplete", "new-password");
    };
</script>

</body>
</html>
