<?php
session_start();
include 'db.php'; // Include the database connection

// Check if the user is already logged in
if (isset($_SESSION["adminuser"])) {
    header("Location: Dashboard.php"); // Redirect to Dashboard if logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim inputs to avoid XSS and extra spaces
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = $_POST["password"];

    // Validate that username and password are not empty
    if (empty($username) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {
        // Prepare the SQL query to fetch the admin by username
        $sql = "SELECT * FROM admin WHERE username = ?";  // Correct table name 'admin'

        if ($stmt = $conn->prepare($sql)) {
            // Bind the username parameter to the prepared statement
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if an admin with that username exists
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verify the password using password_verify()
                if (password_verify($password, $row['admin_password'])) { // Correct column name 'admin_password'
                    // Start the session and store admin info
                    $_SESSION["adminuser"] = $username;
                    $_SESSION["role"] = $row['admin_role']; // Correct column name 'admin_role'

                    // Regenerate session ID to avoid session fixation attacks
                    session_regenerate_id(true);

                    // Redirect to the dashboard based on the role
                    if ($_SESSION["role"] == 'superadminuser') {
                        header("Location: Dashboard.php"); // Redirect to SuperAdmin dashboard
                    } else {
                        header("Location: Dashboard.php"); // Redirect to Admin dashboard
                    }
                    exit();
                } else {
                    // Incorrect password
                    $error_message = "Invalid password. Please try again.";
                }
            } else {
                // Username doesn't exist
                $error_message = "Invalid username. Please try again.";
            }
        } else {
            // Handle the case if the query preparation fails
            $error_message = "An error occurred while processing your request.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="AdminLogin.css">
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>

        <!-- Display error message if login failed -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>
    </div>

    <!-- Optional: Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
