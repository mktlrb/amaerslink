<?php
session_start();
require 'db_connect.php'; // Ensure you have a database connection file

// Fetch users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addUser'])) {
        $usn = $_POST['usn'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $student_level = $_POST['student_level'] ?? NULL;

        $stmt = $conn->prepare("INSERT INTO users (usn, name, email, password, role, student_level) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $usn, $name, $email, $password, $role, $student_level);
        $stmt->execute();
        header("Location: admin_panel.php");
        exit();
    }
    
    if (isset($_POST['deleteUser'])) {
        $user_id = $_POST['user_id'];
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        header("Location: admin_panel.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Users Management</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add User</button>
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>USN</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['usn']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="deleteUser" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
                    <form method="POST">
                        <label>USN:</label>
                        <input type="text" name="usn" class="form-control mb-2" required>

                        <label>Name:</label>
                        <input type="text" name="name" class="form-control mb-2" required>

                        <label>Email:</label>
                        <input type="email" name="email" class="form-control mb-2" required>

                        <label>Password:</label>
                        <input type="password" name="password" class="form-control mb-2" required>

                        <label>Role:</label>
                        <select name="role" class="form-control mb-2">
                            <option value="Admin">Admin</option>
                            <option value="Facilitator">Facilitator</option>
                            <option value="Student">Student</option>
                        </select>

                        <label>Student Level (if applicable):</label>
                        <select name="student_level" class="form-control mb-2">
                            <option value="">None</option>
                            <option value="SHS">SHS</option>
                            <option value="College">College</option>
                        </select>
                        
                        <button type="submit" name="addUser" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
