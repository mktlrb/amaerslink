<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: AdminLogin.php");
    exit();
}

include 'db.php';

// Fetch feedback count
$feedback_count = $conn->query("SELECT COUNT(*) AS total FROM feedbacks")->fetch_assoc()["total"];
$feedbacks = $conn->query("SELECT * FROM feedbacks ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="Feedback.css"> 
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar">
            <h2>Admin<span class="text-danger">Panel</span></h2>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="Dashboard.php" class="nav-link text-white"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li><a href="Addusers.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Users</a></li>
                <li><a href="Feedbacks.php" class="nav-link active bg-danger"><i class="fas fa-comment-alt me-2"></i> Feedback <span class="badge bg-light text-dark ms-2"><?php echo $feedback_count; ?></span></a></li>
                <li><a href="AdminLogin.php" class="nav-link text-white"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="margin-left: 260px;">
            <div class="top-bar">
                <h1 class="mt-3">Feedbacks</h1>
                <div class="profile">
                    <span><?php echo $_SESSION["admin"]; ?></span>
                </div>
            </div>

            <!-- Feedback List -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5><i class="fas fa-comments me-2"></i> User Feedbacks</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Feedback</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $feedbacks->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['user_name']; ?></td>
                                        <td><?php echo $row['message']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
