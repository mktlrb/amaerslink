<?php
session_start();
require 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT name, email, birthdate, education_level, student_id FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $birthdate, $education_level, $student_id);
$stmt->fetch();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand ms-3" href="#">
                <img src="images/logo.png" alt="Logo" height="40">
            </a>
            <div class="d-flex align-items-center navbar-icons d-none d-md-flex">
                <a href="notif.php"><img src="images/Bell.png" height="30" alt="Notifications"></a>
                <a href="homepage.php" class="btn"><img src="images/Home.png" height="30" alt="Home"></a>
                <a href="profile.php"><img src="images/Generic_avatar.png" class="rounded-circle" height="40" alt="Avatar"></a>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <button class="nav-link text-dark"><img src="images/Generic_avatar.png" height="30"> Profile</button>
                </li>
                <li class="nav-item mb-2">
                    <a href="homepage.php" class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="notif.php" class="nav-link text-dark"><img src="images/Bell.png" height="30"> Notifications</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="sched.php" class="nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger"><img src="images/Log_out.png" height="30"> Log Out</a>
                </li>
            </ul>
        </nav>
        <main id="main-container" class="container mt-5 pt-4">
            <div class="card p-3 mb-4 bg-white text-dark profile-section">
                <div class="d-flex align-items-center p-4 profile-header">
                    <img src="images/Generic_avatar.png" class="rounded-circle me-3 profile-avatar" height="80" alt="Avatar">
                    <div class="header-name">
                        <h4 class="profile-name"><?php echo htmlspecialchars($name); ?></h4>
                        <p class="mb-1 profile-year"><?php echo htmlspecialchars($education_level); ?></p>
                        <p class="mb-0 profile-id">Student ID: <?php echo htmlspecialchars($student_id); ?></p>
                    </div>
                </div>
            </div>
            <h4 class="fw-bold section-title">User Information</h4>
            <form action="update_profile.php" method="POST">
                <div class="row mb-4 g-2">
                    <div class="col-md-6">
                        <div class="card p-3 user-info-card h-100">
                            <h6 class="info-title">Email</h6>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 user-info-card h-100">
                            <h6 class="info-title">Birth date</h6>
                            <p class="info-text"><?php echo htmlspecialchars($birthdate); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <button type="reset" class="btn btn-outline mb-2 cancel-btn">Cancel</button>
                    <button type="submit" class="btn btn-dark save-btn">Save Changes</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
