<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: AdminLogin.php");
    exit();
}

include 'db.php';

// Fetch user, admin, and facilitator counts
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'user'")->fetch_assoc()["total"];
$admin_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'Admin'")->fetch_assoc()["total"];
$facilitator_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'facilitator'")->fetch_assoc()["total"];
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
    <link rel="stylesheet" href="Dashboard.css"> 
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar">
            <h2>Admin<span class="text-danger">Panel</span></h2>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="Dashboard.php" class="nav-link text-white"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li><a href="Users.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Users</a></li>
                <li><a href="feedbacks.php" class="nav-link text-white"><i class="fas fa-comment-alt me-2"></i> Feedback <span class="badge bg-danger ms-2">13</span></a></li>
                <li><a href="AdminLogin.php" class="nav-link text-white"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="margin-left: 260px;">
            <div class="top-bar">
                <h1 class="mt-3">Dashboard</h1>
                <div class="profile">
                    <span><?php echo $_SESSION["admin"]; ?></span>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user me-2"></i> Students</h5>
                            <p class="card-text"><?php echo $user_count; ?> total</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-shield me-2"></i> Admins</h5>
                            <p class="card-text"><?php echo $admin_count; ?> total</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-chalkboard-teacher me-2"></i> Facilitators</h5>
                            <p class="card-text"><?php echo $facilitator_count; ?> total</p>
                        </div>
                    </div>
                </div>
            </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendarPopup = document.getElementById('calendar-popup');
            var calendarToggle = document.getElementById('calendar-toggle');
            var calendar;

            function initializeCalendar() {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'en-gb',
                    height: 'auto',
                    contentHeight: 400,
                    events: [
                        { title: 'Meeting', start: '2024-02-15' },
                        { title: 'Webinar', start: '2024-02-20' },
                        { title: 'Team Outing', start: '2024-02-25', end: '2024-02-26' }
                    ]
                });
                calendar.render();
            }

            calendarToggle.addEventListener('click', function () {
                if (calendarPopup.style.display === 'none' || calendarPopup.style.display === '') {
                    calendarPopup.style.display = 'block';
                    if (!calendar) {
                        initializeCalendar();
                    } else {
                        calendar.render();
                    }
                } else {
                    calendarPopup.style.display = 'none';
                }
            });

            document.addEventListener('click', function (event) {
                if (!calendarPopup.contains(event.target) && event.target !== calendarToggle) {
                    calendarPopup.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>