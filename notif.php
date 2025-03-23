<?php
session_start();
include "config.php"; // Database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch notifications from the database
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
$query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Send email notifications for each notification
    while ($row = $result->fetch_assoc()) {
        // Prepare to send email
        $mail = new PHPMailer(true); // Enable exceptions

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@example.com'; // SMTP username
            $mail->Password = 'your_password'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('from@example.com', 'Your App Name');
            $mail->addAddress('recipient@example.com', 'Recipient Name'); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Notification';
            $mail->Body    = 'You have a new notification: <strong>' . htmlspecialchars($row['message']) . '</strong>';
            $mail->AltBody = 'You have a new notification: ' . htmlspecialchars($row['message']);

            // Send the email
            $mail->send();
            echo 'Notification email has been sent to ' . htmlspecialchars($row['recipient_email']);
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
} else {
    // Handle query preparation error
    echo "Error preparing statement: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-dark d-lg-none" id="menuToggle">☰</button>
            <a class="navbar-brand ms-3" href="#">
                <img src="images/logo 1.png" alt="Logo" height="40">
            </a>
            <form class="d-none d-md-flex me-auto">
                <input class="form-control me-2" type="search" placeholder="Search">
            </form>
            <div class="d-flex align-items-center navbar-icons d-none d-md-flex">
                <a href="notif.php"><img src="images/Bell.png" height="30"></a>
                <a href="homepage.php" class="btn"><img src="images/Home.png" height="30"></a>
                <a href="profile.php"><img src="images/Generic avatar.png" class="rounded-circle" height="40"></a>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="profile.php" class="nav-link text-dark"><img src="images/Generic avatar.png" height="30"> Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="homepage.php" class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</a>
                </li>
                <li class="nav-item mb-2">
                    <button class="nav-link text-dark"><img src="images/Bell.png" height="30"> Notifications</button>
                </li>
                <li class="nav-item mb-2">
                    <a href="sched.php" class="nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-danger"><img src="images/Log out.png" height="30"> Log Out</a>
                </li>
            </ul>
        </nav>

        <main id="main-container" class="container mt-5 pt-4">
            <h4 class="fw-bold mb-4">Notifications</h4>
            
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="card mb-2" style="min-height: 40px;">
                    <div class="card-body d-flex align-items-center p-1">
                        <img src="images/Generic avatar.png" class="rounded-circle me-2" height="30">
                        <div>
                            <p class="mb-1 small"><strong><?php echo htmlspecialchars($row['sender_name']); ?></strong> <?php echo htmlspecialchars($row['message']); ?></p>
                            <small class="text-muted"><?php echo htmlspecialchars($row['created_at']); ?></small>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const menuToggle = document.getElementById("menuToggle");
            function handleSidebar() {
                if (window.innerWidth < 1900) {
                    sidebar.classList.add("collapsed");
                    menuToggle.style.display = "block";
                } else {
                    sidebar.classList.remove("collapsed");
                    menuToggle.style.display = "none";
                }
            }
            handleSidebar();
            window.addEventListener("resize", handleSidebar);
            menuToggle.addEventListener("click", function (event) {
                event.stopPropagation();
                sidebar.classList.toggle("collapsed");
                sidebar.classList.toggle("show");
            });
            document.addEventListener("click", function (event) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove("show");
                }
            });
        });
    </script>
</body>
</html>
