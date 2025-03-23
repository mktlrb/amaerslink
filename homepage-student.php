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

// Fetch announcements from the database
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

// Handle post submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postContent'])) {
    $postContent = $conn->real_escape_string($_POST['postContent']);
    $sql = "INSERT INTO announcements (content, created_at) VALUES ('$postContent', NOW())";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
    exit();
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['commentContent'])) {
    $commentContent = $conn->real_escape_string($_POST['commentContent']);
    $announcementId = $_POST['announcementId'];
    $sql = "INSERT INTO comments (announcement_id, content, created_at) VALUES ('$announcementId', '$commentContent', NOW())";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
                <input type="text" id="searchInput" class="form-control" placeholder="Search">
            </form>
            <div class="d-flex align-items-center navbar-icons d-none d-md-flex">
                <a href="notif.html"><img src="images/Bell.png" height="30" alt="Notifications"></a>
                <a href="homepage.php" class="btn">
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
                    <button class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</button>
                </li>
                <li class="nav-item mb-2">
                    <a href="notif.html" class="nav-link text-dark"><img src="images/Bell.png" height="30"> Notification</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="sched.html" class=" nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</a>
                </li>
                <li class="nav-item">
                    <a href="index.html" class="nav-link text-danger"><img src="images/Log out.png" height="30"> Log Out</a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main id="main-container" class="container mt-5 pt-4">
            <div class="card p-3 mb-2 bg-white text-dark">
                <div class="d-flex align-items-center">
                    <img src="images/Generic avatar.png" class="rounded-circle me-2" height="40" alt="Avatar">
                    <div class="position-relative w-100">
                        <form method="POST" action="">
                            <textarea name="postContent" class="form-control text-dark" placeholder="Hello, what's up?" rows="1" style="font-size: 15px;" required></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Post</button>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-around">
                    <button class="btn btn-white text-success">
                        <img src="images/gallery.png" height="20" class="me-1"> Photo/Video</button>
                    <button class="btn btn-white text-success">
                        <img src="images/Folder.png" height="20" class="me-1"> Files</button>
                </div>
            </div>

            <!-- Announcements -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card p-3 mb-2">
                    <div class="d-flex align-items-center">
                        <img src="images/Generic avatar.png" class="rounded-circle me-2" height="40" alt="Avatar">
                        <div>
                            <strong>SSG</strong> <span class="text-muted">/Facilitator</span><br>
                            <small class="text-muted"><?php echo date('M d, Y \a\t h:i A', strtotime($row['created_at'])); ?></small>
                        </div>
                    </div>
                    <p class="mt-2"><?php echo htmlspecialchars($row['content']); ?></p>
                    <div class="d-flex">
                        <label class="ui-bookmark">
                            <input type="checkbox" />
                            <div class="bookmark" style="top: 5px; left: 5px;">
                                <svg viewBox="0 0 16 16" style="margin-top:4px" class="bi bi-heart-fill" height="25" width="25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" fill-rule="evenodd"></path>
                                </svg>
                            </div>
                        </label>
                        <button class="chatbox" data-bs-toggle="modal" data-bs-target="#commentModal<?php echo $row['id']; ?>">
                            <i class="bi bi-chat-dots" style="font-size: 1.5rem; cursor: pointer; left: 10px;"></i>
                        </button>
                    </div>
                </div>

                <!-- Comment Modal -->
                <div class="modal fade" id="commentModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentModalLabel">Add a Comment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
                                    <textarea name="commentContent" class="form-control" rows="3" placeholder="Write your comment here..." required></textarea>
                                    <input type="hidden" name="announcementId" value="<?php echo $row['id']; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Comment</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
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
?> ```php
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

// Fetch announcements from the database
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

// Handle post submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postContent'])) {
    $postContent = $conn->real_escape_string($_POST['postContent']);
    $sql = "INSERT INTO announcements (content, created_at) VALUES ('$postContent', NOW())";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
    exit();
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['commentContent'])) {
    $commentContent = $conn->real_escape_string($_POST['commentContent']);
    $announcementId = $_POST['announcementId'];
    $sql = "INSERT INTO comments (announcement_id, content, created_at) VALUES ('$announcementId', '$commentContent', NOW())";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
    exit();
}
?>
