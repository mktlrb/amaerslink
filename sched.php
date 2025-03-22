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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['publicAppointmentForm'])) {
        // Insert public event
        $stmt = $pdo->prepare("INSERT INTO events (title, start_date, description, category) VALUES (?, ?, ?, 'public')");
        $stmt->execute([$_POST['publicTitle'], $_POST['publicDate'], $_POST['publicDescription']]);
    } elseif (isset($_POST['personalAppointmentForm'])) {
        // Insert personal appointment
        $stmt = $pdo->prepare("INSERT INTO events (title, start_date, description, category) VALUES (?, ?, ?, 'personal')");
        $stmt->execute([$_POST['personalName'], $_POST['personalDate'] . ' ' . $_POST['personalTime'], $_POST['personalReason']]);
    } elseif (isset($_POST['equipmentRequestForm'])) {
        // Insert equipment request
        $stmt = $pdo->prepare("INSERT INTO events (title, start_date, description, category) VALUES (?, ?, ?, 'equipment')");
        $stmt->execute(['Equipment Request: ' . $_POST['requestedItem'], $_POST['requestDate'], $_POST['requestPurpose']]);
    }
}

// Fetch events for the calendar
$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules & Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <link rel="stylesheet" href="sched.css">
    <style>
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
                <a href="notif.html"><img src="images/Bell.png" height="30" alt="Notifications"></a>
                <a href="homepage.html" class="btn">
                    <img src="images/Home.png" height="30" alt="Home">
                </a>
                <a href="profile.html"><img src="images/Generic avatar.png" class="rounded-circle" height="40" alt="Avatar"></a>
            </div>
        </div>
    </nav>

 <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="profile.html" class="nav-link text-dark">
                        <img src="images/Generic avatar.png" height="30" alt="Profile Icon"> Profile
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="homepage.html" class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="notif.html" class="nav-link text-dark"><img src="images/Bell.png" height="30"> Notification</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="sched.php" class="nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</a>
                </li>
                <li class="nav-item">
                    <a href="index.html" class="nav-link text-danger"><img src="images/Log out.png" height="30"> Log Out</a>
                </li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main id="main-container" class="container mt-3 pt-4">
            <div class="container-fluid" style="margin-top: 50px;">
                <div class="row">
                    <!-- Calendar Section -->
                    <div class="col-12 col-lg-8" style="height: 500px; margin: auto;">
                        <div class="card p-1 mb-3" style="height: 100%; border: none;">
                            <h3 class="text-center mt-5"><strong>EVENT CALENDAR</strong></h3>
                            <div id="calendar-container" style="overflow: hidden; padding: 10px; font-size: 12px;">
                                <div id="calendar" style="height: 100%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Schedules -->
                    <div class="col-12 col-lg-4 d-flex flex-column" style="height: auto;">
                        <div class="card p-3 mb-3 mt-3">
                            <h6>Upcoming Schedules and Events</h6>
                            <div class="list-group" id="upcomingSchedulesList">
                                <?php foreach ($events as $event): ?>
                                    <div class="list-group-item small" data-event-id="<?= $event['id'] ?>" data-event-date="<?= $event['start_date'] ?>">
                                        <?= htmlspecialchars($event['title']) ?> - <?= htmlspecialchars($event['start_date']) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="btn btn-outline-dark mt-3 w-100" data-bs-toggle="modal" data-bs-target="#setPublicAppointmentModal" style="font-size: 13px;">
                                Create Event
                            </button>
                        </div>

                        <!-- Appointments -->
                        <div class="card p-3">
                            <h6>Appointments</h6>
                            <div class="list-group" id="appointmentsList"></div>
                            <button class="btn btn-outline-dark mt-3 w-100" data-bs-toggle="modal" data-bs-target="#setPersonalAppointmentModal" style="font-size: 13px;">
                                Set Appointment
                            </button>
                        </div>

                        <!-- Request for Equipment and Facility -->
                        <div class="card p-3 mt-2">
                            <h6>Request for Equipment and Facility</h6>
                            <div class="list-group" id="equipmentRequestsList"></div>
                            <button class="btn btn-outline-dark mt-3 w-100" data-bs-toggle="modal" data-bs-target="#requestEquipmentModal" style="font-size: 13px;">
                                Set Request
                            </button>
                        </div>
                    </div> <!-- End of Right Column -->
                </div> <!-- End of Row -->
            </div> <!-- End of Container Fluid -->
        </main>
    </div> <!-- End of Main Layout -->

    <!-- Modals -->
    <div class="modal fade" id="setPublicAppointmentModal" tabindex="-1" aria-labelledby="setPublicAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPublicAppointmentModalLabel">Create Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="publicAppointmentForm" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Event Title</label>
                            <input type="text" class="form-control" name="publicTitle" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="publicDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="publicDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="publicCategory" required>
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

    <div class="modal fade" id="setPersonalAppointmentModal" tabindex="-1" aria-labelledby="setPersonalAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPersonalAppointmentModalLabel">Set Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="personalAppointmentForm" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="personalName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="personalDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" name="personalTime" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason for Consultation</label>
                            <input type="text" class="form-control" name="personalReason" required>
                        </div>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="requestEquipmentModal" tabindex="-1" aria-labelledby="requestEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestEquipmentModalLabel">Request Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="equipmentRequestForm" method="POST">
                        <div class="mb-3">
                            <label for="requestorName" class="form-label">Requestor Name</label>
                            <input type="text" class="form-control" name="requestorName" required>
                        </div>
                        <div class="mb-3">
                            <label for="requestDate" class="form-label">Request Date</label>
                            <input type="date" class="form-control" name="requestDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="requestedItem" class="form-label">Requested Item</label>
                            <input type="text" class="form-control" name="requestedItem" required>
                        </div>
                        <div class="mb-3">
                            <label for="requestPurpose" class="form-label">Purpose</label>
                            <textarea class="form-control" name="requestPurpose" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle .min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const calendarEl = document.getElementById('calendar');
            const events = <?= json_encode($events) ?>;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events.map(event => ({
                    id: event.id,
                    title: event.title,
                    start: event.start_date,
                    extendedProps: {
                        description: event.description,
                        category: event.category
                    }
                })),
                eventClick: function (info) {
                    // Handle event click to show details
                    alert(`Event: ${info.event.title}\nDescription: ${info.event.extendedProps.description}`);
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>