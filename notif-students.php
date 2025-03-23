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

// Fetch notifications from the database
$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="homepage-student.html">

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
                <a href="notif.php"><img src="images/Bell.png" height="30" alt="Notifications"></a>
                <a href="homepage-student.php" class="btn">
                    <img src="images/Home.png" height="30" alt="Home">
                </a>
                <a href="profile-student.php"><img src="images/Generic avatar.png" class="rounded-circle" height="40" alt="Avatar"></a>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="profile-student.php" class="nav-link text-dark"><img src="images/Generic avatar.png" height="30"> Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="homepage-student.php" class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</a>
                </li>
                <li class="nav-item mb-2">
                    <button class="nav-link text-dark"><img src="images/Bell.png" height="30"> Notifications</button>
                </li>
                <li class="nav-item mb-2">
                    <a href="student-sched.php" class="nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-danger"><img src="images/Log out.png" height="30"> Log Out</a>
                </li>
            </ul>
        </nav>

        <!-- Main Content - Notifications -->
        <main id="main-container" class="container mt-5 pt-4">
            <h4 class="fw-bold mb-4">Notifications</h4>

            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card mb-2" style="min-height: 40px;">
                    <div class="card-body d-flex align-items-center p-1">
                        <img src="images/Generic avatar.png" class="rounded-circle me-2" height="30" alt="User ">
                        <div>
                            <p class="mb-1 small"><strong><?php echo htmlspecialchars($row['user_name']); ?></strong> <?php echo htmlspecialchars($row['message']); ?></p>
                            <small class="text-muted"><?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></small>
                        </div>
                    </div </div>
            <?php endwhile; ?>
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