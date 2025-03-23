<?php
session_start();
if (!isset($_SESSION["users"])) {
    header("Location: AdminLogin.php");
    exit();
}

include 'db.php';

// Fetch user, admin, and facilitator counts
<<<<<<< HEAD:Users.php
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'student'")->fetch_assoc()["total"];
$admin_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'admin'")->fetch_assoc()["total"];
=======
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'users'")->fetch_assoc()["total"];
$admin_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'users'")->fetch_assoc()["total"];
>>>>>>> 152abee31f8cb26c62e08f5c85278c135b05c352:Addusers.php
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
                <li><a href="Addusers.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Students</a></li>
                <li><a href="Feedback.php" class="nav-link text-white"><i class="fas fa-comment-alt me-2"></i> Feedback</a></li>
                <li><a href="AdminLogin.php" class="nav-link text-white"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="margin-left: 260px;">
            <div class="top-bar">
                <h1>Users Management</h1>
                <div class="profile">
                    <span><?php echo $_SESSION["users"]; ?></span>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center my-3">
                <input type="text" class="form-control w-25" placeholder="Search User" id="searchInput">
                <div class="d-flex">
                    <button class="btn btn-outline-primary me-2" onclick="openRoleSelectionModal()">+ Add User</button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Sort
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="sortUsers('usn')">Sort by USN</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortUsers('name')">Sort by User Name</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Role Modal -->
    <div class="modal fade" id="roleSelectionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary w-100 mb-2" onclick="openAddUserModal('admin')">Admin</button>
                    <button class="btn btn-secondary w-100 mb-2" onclick="openAddUserModal('facilitator')">Facilitator</button>
                    <button class="btn btn-success w-100" onclick="openAddUserModal('student')">Student</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="Addusers.php">
                        <input type="hidden" name="role" id="userRole">

                        <div id="studentFields" style="display: none;">
                            <label>USN:</label>
                            <input type="text" name="usn" class="form-control mb-2">
                            <label>Student Name:</label>
                            <input type="text" name="name" class="form-control mb-2" required>
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control mb-2" required>
                            <label>Student Type:</label>
                            <select name="student_type" class="form-control mb-2">
                                <option value="SHS">SHS</option>
                                <option value="College">College</option>
                            </select>
                        </div>

                        <div id="adminFacilitatorFields" style="display: none;">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control mb-2" required>
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control mb-2" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRoleSelectionModal() {
            var myModal = new bootstrap.Modal(document.getElementById('roleSelectionModal'));
            myModal.show();
        }

        function openAddUserModal(role) {
            document.getElementById('userRole').value = role;
            document.getElementById('studentFields').style.display = role === 'student' ? 'block' : 'none';
            document.getElementById('adminFacilitatorFields').style.display = (role === 'admin' || role === 'facilitator') ? 'block' : 'none';
            var myModal = new bootstrap.Modal(document.getElementById('addUserModal'));
            myModal.show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
