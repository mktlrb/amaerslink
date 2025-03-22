<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete User Logic
if (isset($_POST['delete_user'])) {
    $usn = $_POST['usn'];
    $sql = "DELETE FROM users WHERE usn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_panel.php");
    exit();
}

// Fetch Users from Database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
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
    <div class="container mt-5">
        <h1>Admin Panel - Users</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>USN</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['usn']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="usn" value="<?php echo $row['usn']; ?>">
                                <button type="submit" name="delete_user" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
