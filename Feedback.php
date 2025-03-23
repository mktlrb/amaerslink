<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: AdminLogin.php");
    exit();
}

include 'db.php';

// Securely fetch feedback count
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM feedbacks");
$stmt->execute();
$result = $stmt->get_result();
$feedback_count = $result->fetch_assoc()["total"];
$stmt->close();

// Pagination setup
$limit = 10; // Feedbacks per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1
$offset = ($page - 1) * $limit;

// Securely fetch feedbacks with pagination
$stmt = $conn->prepare("SELECT * FROM feedbacks ORDER BY created_at DESC LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$feedbacks = $stmt->get_result();
$stmt->close();

// Calculate total pages
$total_pages = ceil($feedback_count / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Feedback.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar text-white">
            <h2>Admin<span class="text-danger">Panel</span></h2>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="Dashboard.php" class="nav-link text-white"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li><a href="Addusers.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Users</a></li>
                <li><a href="Feedback.php" class="nav-link active bg-danger"><i class="fas fa-comment-alt me-2"></i> Feedback <span class="badge bg-light text-dark ms-2"><?php echo $feedback_count; ?></span></a></li>
                <li><a href="AdminLogin.php" class="nav-link text-white"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="margin-left: 260px;">
            <div class="top-bar d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                <h1 class="mt-3">Feedbacks</h1>
                <div class="profile">
                    <span><?php echo htmlspecialchars($_SESSION["admin"]); ?></span>
                </div>
            </div>

            <!-- Feedback List -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                            <h5 class="m-0"><i class="fas fa-comments me-2"></i> User Feedbacks</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead class="table-dark">
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
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($page < $total_pages): ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
