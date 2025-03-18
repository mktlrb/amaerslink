<?php
// Database connection
$host = 'localhost';
$db = 'your_database_name';
$user = 'your_username';
$pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Fetch user data (for demonstration purposes, fetching the first user)
$stmt = $pdo->query("SELECT * FROM users LIMIT 1");
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="homepage.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add Bootstrap Icons in the <head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <!-- Sidebar & Navbar Toggle Button -->
            <button class="btn btn-outline-dark d-lg-none" id="menuToggle">☰</button>

            <a class="navbar-brand ms-3" href="#">
                <img src="images/logo  1.png" alt="Logo" height="40">
            </a>

            <!-- Search Bar (Hidden on Small Screens) -->
            <form class="d-none d-md-flex me-auto">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            </form>

            <!-- Navbar Icons as Buttons -->
            <div class="d-flex align-items-center navbar-icons d-none d-md-flex">
                <button><img src="images/Bell.png" height="30" alt="Bell"></button>
                <button><img src="images/Home.png" height="30" alt="Home"></button>
                <button><img src="<?= htmlspecialchars($user['profile_picture']) ?>" class="rounded-circle" height="40" alt="Avatar"></button>
            </div>
        </div>
    </nav>
    

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <button class="nav-link text-dark"><img src="images/Generic avatar.png" height="30">
                        Profile</button>
                </li>
                <li class="nav-item mb-2">
                    <button class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</button>
                </li>
                <li class="nav-item mb-2">
                    <button class="nav-link text-dark"><img src="images/gmail_groups.png" height="30">
                        Organization</button>
                </li>
                <li class="nav-item mb-2">
                    <button class="nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link text-danger"><img src="images/Log out.png" height="30"> Log Out</button>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main id="main-container" class="container mt -3 pt-4">
            <h1>Welcome, <?= htmlspecialchars($user['username']) ?></h1>
            <p>Your email: <?= htmlspecialchars($user['email']) ?></p>
            <div id="commentSection">
                <h2>Comments</h2>
                <input type="text" id="commentInput" placeholder="Add a comment" />
                <button onclick="addComment()">Submit</button>
                <div id="commentList"></div>
            </div>
        </main>
    </div>

    <!-- Custom Script for Sidebar and Navbar Toggle -->
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

        function addComment() {
            let input = document.getElementById('commentInput');
            let commentText = input.value.trim();
            if (commentText) {
                let commentList = document.getElementById('commentList');
                let div = document.createElement('div');
                div.className = 'comment-item';
                div.innerHTML = `<span>${commentText}</span> 
                    <button class="delete-comment" onclick="this.parentElement.remove()">X</button>`;
                commentList.appendChild(div);
                input.value = '';
            }
        }
    </script>

</body>

</html>