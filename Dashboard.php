<?php
session_start();

$servername = "127.0.0.1"; // Change from 'localhost' to '127.0.0.1'
$username = "root";
$password = "";
$database = "admin_panel";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user counts with error handling
function getCount($conn, $query) {
    $result = $conn->query($query);
    return ($result && $row = $result->fetch_assoc()) ? $row[array_keys($row)[0]] : 0;
}

$users_online = getCount($conn, "SELECT COUNT(*) AS user_count FROM users WHERE status = 'online'");
$admins_online = getCount($conn, "SELECT COUNT(*) AS admin_count FROM users WHERE role = 'admin' AND status = 'online'");
$facilitators_online = getCount($conn, "SELECT COUNT(*) AS facilitator_count FROM users WHERE role = 'facilitator' AND status = 'online'");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" />
    <link rel="stylesheet" href="usercss.css">
</head>
<body>
    <div class="d-flex">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar">
            <h2>Admin<span class="text-danger">Panel</span></h2>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link text-white">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="user.php" class="nav-link text-white">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                </li>
                <li>
                    <a href="feedbacks.php" class="nav-link text-white">
                        <i class="fas fa-comment-alt me-2"></i> Feedback <span class="badge bg-danger ms-2">13</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="nav-link text-white">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <div class="container-fluid" style="margin-left: 260px;">
            <div class="top-bar">
                <h1 class="mt-3">Dashboard</h1>
                <div class="profile">
                    <span>Avin Ace Villafuerte</span>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text"><?php echo $users_online; ?> online</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Admins</h5>
                            <p class="card-text"><?php echo $admins_online; ?> online</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Facilitators</h5>
                            <p class="card-text"><?php echo $facilitators_online; ?> online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
