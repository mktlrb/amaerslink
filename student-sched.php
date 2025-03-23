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

// Fetch events and appointments from the database
$sqlEvents = "SELECT * FROM events ORDER BY start_date ASC";
$sqlAppointments = "SELECT * FROM appointments ORDER BY appointment_date ASC";
$eventsResult = $conn->query($sqlEvents);
$appointmentsResult = $conn->query($sqlAppointments);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules & Events</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="sched.css">

    <style>
        /* Ensure the calendar has a height */
        #calendar {
            height: 100%;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-dark d-lg-none" id="toggleSidebar">☰</button>
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
                <a href="profile-student.php"><img src="images/Generic avatar.png" class="rounded-circle" height="40" alt="Avatar"></a>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="profile-student.php" class="nav-link text-dark">
                        <img src="images/Generic avatar.png" height="30" alt="Profile Icon"> Profile
                    </a>
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

        <!-- Main Content Area -->
        <main id="main-container" class="container mt-3 pt-4">
            <div class="container-fluid" style="margin-top: 50px;">
                <div class="row">
                    <!-- Calendar Section -->
                    <div class="col- 12 col-lg-8" style="height: 500px; margin: auto;">
                        <div class="card p-1 mb-3" style="height: 100%; border: none;">
                            <h3 class="text-center mt-5"> <strong>EVENT CALENDAR</strong></h3>
                            <div id="calendar-container" style="overflow: hidden; padding: 10px; font-size: 12px;">
                                <div id="calendar" style="height: 100%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-12 col-lg-4 d-flex flex-column" style="height: auto;">

                        <!-- Appointments -->
                        <div class="card p-3">
                            <h6>Appointments</h6>
                            <div class="list-group" id="appointmentsList">
                                <?php while ($appointment = $appointmentsResult->fetch_assoc()): ?>
                                    <div class="list-group-item small">
                                        <?php echo htmlspecialchars($appointment['name']); ?> - <?php echo htmlspecialchars($appointment['appointment_date']); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <button class="btn btn-outline-dark mt-3 w-100" data-bs-toggle="modal"
                                data-bs-target="#setPersonalAppointmentModal" style="font-size: 13px;">
                                Set Appointment
                            </button>
                        </div>

                        <!-- Request for Equipment and Facility -->
                        <div class="card p-3 mt-2">
                            <h6>Request for Equipment and Facility</h6>
                            <div class="list-group" id="equipmentRequestsList"></div>
                            <button class="btn btn-outline-dark mt-3 w-100" data-bs-toggle="modal"
                                data-bs-target="#requestEquipmentModal" style="font-size: 13px;">
                                Set Request
                            </button>
                        </div>
                    </div> <!-- End of Right Column -->
                </div> <!-- End of Row -->
            </div> <!-- End of Container Fluid -->
        </main>
    </div> <!-- End of Main Layout -->

    <!-- Modals -->
    <div class="modal fade" id="setPublicAppointmentModal" tabindex="-1"
        aria-labelledby="setPublicAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPublicAppointmentModalLabel">Create Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="publicAppointmentForm">
                        <div class="mb-3">
                            <label class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="publicTitle" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="publicDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="publicDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="publicCategory" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="general">General</option>
                                <option value="shs">SHS</option>
                                <option value="college">College</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="setPersonalAppointmentModal" tabindex="-1"
        aria-labelledby="setPersonalAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPersonalAppointmentModalLabel">Set Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="personalAppointmentForm">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="personalName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="personalDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" id="personalTime" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason for Consultation</label>
                            <input type="text" class="form-control" id="personalReason" required>
                        </div>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="requestEquipmentModal" tabindex="-1" aria-labelledby="requestEquipmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestEquipmentModalLabel">Request Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="equipmentRequestForm">
                        <div class="mb-3">
                            <label for="requestorName" class="form-label">Requestor Name</label>
                            <input type="text" class="form-control" id="requestorName" required>
                        </div>
                        <div class="mb-3">
                            <label for="requestDate" class="form-label">Request Date</label>
                            <input type="date" class="form-control" id="requestDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="requestedItem" class="form-label">Requested Item</label>
                            <input type="text" class="form-control" id="requestedItem" required>
                        </div>
                        <div class="mb-3">
                            <label for="requestPurpose" class="form-label">Purpose</label>
                            <textarea class="form-control" id="requestPurpose" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const menuToggle = document.getElementById("toggleSidebar");

            function handleSidebar() {
                sidebar.classList.toggle("collapsed", window.innerWidth < 1900);
                menuToggle.style.display = window.innerWidth < 1900 ? "block" : "none";
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

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?php
                    $events = [];
                    while ($event = $eventsResult->fetch_assoc()) {
                        $events[] = [
                            'title' => $event['title'],
                            'start' => $event['start_date'],
                            'description' => $event['description'],
                            'extendedProps' => [
                                'category' => $event['category']
                            ]
                        ];
                    }
                    echo json_encode($events);
                ?>
            });

            calendar.render();
        });
    </script>
</body>

</html>

<?php
$conn->close(); // Close the database connection
?>