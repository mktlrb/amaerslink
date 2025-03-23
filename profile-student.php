<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change as needed
$password = ""; // Change as needed
$dbname = "your_database_name"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user profile data
$userId = 1; // Example user ID, change as needed
$sql = "SELECT * FROM users WHERE id = $userId";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="homepage.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-dark d-lg-none" id="menuToggle" aria-expanded="false">☰</button>
            <a class="navbar-brand ms-3" href="#">
                <img src="images/logo  1.png" alt="Logo" height="40">
            </a>
            <form class="d-none d-md-flex me-auto">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            </form>
            <div class="d-flex align-items-center navbar-icons d-none d-md-flex">
                <a href="notif-student.php"><img src="images/Bell.png" height="30" alt="Notifications"></a>
                <a href="homepage-student.php" class="btn">
                    <img src="images/Home.png" height="30" alt="Home">
                </a>
                <a href="profile.php"><img src="images/Generic avatar.png" class="rounded-circle" height="40" alt="Avatar"></a>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <button class="nav-link text-dark"><img src="images/Generic avatar.png" height="30"> Profile</button>
                </li>
                <li class="nav-item mb-2">
                    <a href="homepage-student.php" class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="notif-student.php" class="nav-link text-dark"><img src="images/Bell.png" height="30"> Notification</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="student-sched.php" class="nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-danger"><img src="images/Log out.png" height="30"> Log Out</a>
                </li>
            </ul>
        </nav>

        <main id="main-container" class="container mt-5 pt-4">
            <!-- User Profile Section -->
            <div class="card p-3 mb-4 bg-white text-dark profile-section">
                <div class="d-flex align-items-center p-4 profile-header">
                    <img src="images/Generic avatar.png" class="rounded-circle me-3 profile-avatar" height="80" alt="Avatar">
                    <div class="header-name">
                        <h4 class="profile-name"><?php echo htmlspecialchars($user['name']); ?></h4>
                        <p class="mb-1 profile-year"><?php echo htmlspecialchars($user['educational_level']); ?></p>
                        <p class="mb-0 profile-id "><?php echo htmlspecialchars($user['student_id']); ?></p>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <h4 class="fw-bold section-title">User  Information</h4>
            <div class="row mb-4 g-2">
                <div class="col-md-6">
                    <div class="card p-3 user-info-card h-100">
                        <h6 class="info-title">Email</h6>
                        <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card p-3 user-info-card h-100">
                        <h6 class="info-title">Birth date</h6>
                        <p class="info-text"><?php echo htmlspecialchars($user['birth_date']); ?></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card p-3 user-info-card h-100">
                        <h6 class="info-title">Educational Level</h6>
                        <p class="info-text"><?php echo htmlspecialchars($user['educational_level']); ?></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card p-3 user-info-card h-100">
                        <h6 class="info-title">Student ID</h6>
                        <p class="info-text"><?php echo htmlspecialchars($user['student_id']); ?></p>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <button class="btn btn-outline mb-2 cancel-btn">Cancel</button>
                <button class="btn btn-dark save-btn">Save Changes</button>
            </div>
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

<?php
$conn->close(); // Close the database connection
?>