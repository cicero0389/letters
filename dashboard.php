<?php
// Database connection
$host = 'localhost';
$db = 'dispatch';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialize variables
$search = '';
$sortColumn = 'date_of_dispatched';
$sortOrder = 'ASC';

// Allowed sort columns
$allowedSortColumns = ['date_of_dispatched', 'registry_number', 'to_whom_received', 'subject', 'date_of_letter', 'number_of_letter', 'remarks', 'department_email'];

// Check if user is logged in
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

// Handle search
if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
}

// Handle sorting
if (isset($_GET['sort_column']) && in_array($_GET['sort_column'], $allowedSortColumns)) {
    $sortColumn = $_GET['sort_column'];
}
if (isset($_GET['sort_order']) && ($_GET['sort_order'] === 'ASC' || $_GET['sort_order'] === 'DESC')) {
    $sortOrder = $_GET['sort_order'];
}

// Fetch all letters with search and sorting
$sql = "SELECT * FROM letters WHERE 
        date_of_dispatched LIKE :search OR 
        registry_number LIKE :search OR 
        to_whom_received LIKE :search OR 
        subject LIKE :search 
        ORDER BY $sortColumn $sortOrder";
$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => "%$search%"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        .navbar {
            background-color: #343a40;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 0 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #495057;
        }

        .navbar .logout-button {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .navbar .logout-button:hover {
            background-color: #c82333;
        }

        .content {
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Admin Dashboard</h1>
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="submit_letter.php">Add Letter</a>
            <a href="users.php">Users</a>
            <a href="add_user.php">Add Users</a>
            <form method="POST" style="display: inline;">
                <button class="logout-button" name="logout">Logout</button>
            </form>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <h1>Admin Dashboard</h1>
            <!-- Letters Table -->
            <table id="lettersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date Dispatched</th>
                        <th>Registry Number</th>
                        <th>To Whom Received</th>
                        <th>Date of Letter</th>
                        <th>Number of Letter</th>
                        <th>Subject</th>
                        <th>Remarks</th>
                        <th>Department Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['date_of_dispatched']); ?></td>
                            <td><?= htmlspecialchars($row['registry_number']); ?></td>
                            <td><?= htmlspecialchars($row['to_whom_received']); ?></td>
                            <td><?= htmlspecialchars($row['date_of_letter']); ?></td>
                            <td><?= htmlspecialchars($row['number_of_letter']); ?></td>
                            <td><?= htmlspecialchars($row['subject']); ?></td>
                            <td><?= htmlspecialchars($row['remarks']); ?></td>
                            <td><?= htmlspecialchars($row['department_email']); ?></td>
                            <td>
                                <a class="action-links" href="edit_letter.php?id=<?= htmlspecialchars($row['id']); ?>">Edit</a>
                                <a class="action-links" href="delete_letter.php?id=<?= htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this letter?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            $('#lettersTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>
</body>
</html>
