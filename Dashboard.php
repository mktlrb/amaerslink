<?php
session_start();
if (!isset($_SESSION["users"])) {
    header("Location: AdminLogin.php");
    exit();
}

include 'db.php';
session_regenerate_id(true); // Prevent session fixation attacks

// Secure queries using prepared statements
function getUserCount($role, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = ?");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()["total"] ?? 0;
}

$user_count = getUserCount('students', $conn);
$admin_count = getUserCount('admin', $conn);
$facilitator_count = getUserCount('facilitator', $conn);
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
    <link rel="stylesheet" href="Dashboard.css">
</head>
<body>
<<<<<<< HEAD
<<<<<<< HEAD
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar">
=======
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
>>>>>>> 152abee31f8cb26c62e08f5c85278c135b05c352
            <h2>Admin<span class="text-danger">Panel</span></h2>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="Dashboard.php" class="nav-link text-white"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
<<<<<<< HEAD
                <li><a href="Users.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Users</a></li>
                <li><a href="feedbacks.php" class="nav-link text-white"><i class="fas fa-comment-alt me-2"></i> Feedback <span class="badge bg-danger ms-2">13</span></a></li>
<<<<<<< HEAD
=======
=======
                <li><a href="Addusers.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Students</a></li>
                <li><a href="Feedback.php" class="nav-link text-white"><i class="fas fa-comment-alt me-2"></i> Feedback</a></li>
>>>>>>> d6359cfc957ee8e675dba48add4fd1bc41d7789f
>>>>>>> 68d0decf812e762e96c6f5166f8480b4504bf096
                <li><a href="AdminLogin.php" class="nav-link text-white"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>
=======
    <div class="login-container">
        <h2>Admin Login</h2>
>>>>>>> 2a6a2c42d68577ee6a28184e73df12bf6cd132eb
=======
                <li><a href="Addusers.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Students</a></li>
                <li><a href="Feedback.php" class="nav-link text-white"><i class="fas fa-comment-alt me-2"></i> Feedback</a></li>
                <li><a href="AdminLogin.php" class="nav-link text-white"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>
>>>>>>> 152abee31f8cb26c62e08f5c85278c135b05c352

        <!-- Main Content -->
        <div class="container-fluid" style="margin-left: 260px;">
            <div class="top-bar d-flex justify-content-between align-items-center p-3 bg-light">
                <h1>Dashboard</h1>
                <div class="profile">
                    <span><?php echo htmlspecialchars($_SESSION["admin"] ?? 'Admin'); ?></span>
                </div>
            </div>

<<<<<<< HEAD
<<<<<<< HEAD
            <!-- Dashboard Cards -->
            <div class="row mt-4">
                <div class="col-md-4">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 68d0decf812e762e96c6f5166f8480b4504bf096
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user me-2"></i> Students</h5>
                            <p class="card-text"><?php echo $user_count; ?> total</p>
=======
<<<<<<< HEAD
            <!-- Dashboard Cards -->
            <div class="row mt-5 g-4">
                <div class="col-md-4">
=======
>>>>>>> 68d0decf812e762e96c6f5166f8480b4504bf096
                    <div class="card text-white bg-primary h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h5 class="card-title">Students</h5>
                            <p class="card-text">Total: <?php echo $user_count; ?></p>
<<<<<<< HEAD
>>>>>>> 152abee31f8cb26c62e08f5c85278c135b05c352
=======
>>>>>>> d6359cfc957ee8e675dba48add4fd1bc41d7789f
>>>>>>> 68d0decf812e762e96c6f5166f8480b4504bf096
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
<<<<<<< HEAD
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-shield me-2"></i> Admins</h5>
                            <p class="card-text"><?php echo $admin_count; ?> total</p>
=======
                    <div class="card text-white bg-success h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h5 class="card-title">Admins</h5>
                            <p class="card-text">Total: <?php echo $admin_count; ?></p>
>>>>>>> 152abee31f8cb26c62e08f5c85278c135b05c352
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
<<<<<<< HEAD
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-chalkboard-teacher me-2"></i> Facilitators</h5>
                            <p class="card-text"><?php echo $facilitator_count; ?> total</p>
                        </div>
                    </div>
                </div>
=======
        <!-- Login Form -->
        <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
>>>>>>> 2a6a2c42d68577ee6a28184e73df12bf6cd132eb
=======
                    <div class="card text-white bg-warning h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h5 class="card-title">Facilitators</h5>
                            <p class="card-text">Total: <?php echo $facilitator_count; ?></p>
                        </div>
                    </div>
                </div>
>>>>>>> 152abee31f8cb26c62e08f5c85278c135b05c352
            </div>



    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
