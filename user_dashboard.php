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
$allowedSortColumns = ['date_of_dispatched', 'registry_number', 'to_whom_received', 'subject'];

// Check if user is logged in
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
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
    <title>User Dashboard</title>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        /* Nav Bar Styles */
        .navbar {
            background-color: #4a90e2;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 500;
        }

        .navbar a, .navbar button {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 0 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .navbar a:hover, .navbar button:hover {
            background-color: #357abd;
        }

        .navbar .logout-button {
            background-color: #d9534f;
            border: none;
            cursor: pointer;
            padding: 10px 15px;
        }

        /* Page Content */
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
            background-color: #4a90e2;
            color: #fff;
        }

        .search-bar {
            margin: 20px 0;
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
        }

        .search-bar button {
            padding: 10px;
            border: none;
            background-color: #4a90e2;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .search-bar button:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Dispatch System</h1>
        <div>
            <a href="./user_dashboard.php">Dashboard</a>
            <a href="submit_letter.php">Submit Letter</a>
            <a href="settings.php">Settings</a>
            <a href="help.php">Help</a>
            <button class="logout-button" onclick="window.location.href='logout.php';">Logout</button>

        </div>
    </div>
    <div class="content">
        <div class="container">
            <table id="lettersTable">
                <thead>
                    <tr>
                        <th><a href="?sort_column=date_of_dispatched&sort_order=<?php echo ($sortColumn === 'date_of_dispatched' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Date</a></th>
                        <th><a href="?sort_column=registry_number&sort_order=<?php echo ($sortColumn === 'registry_number' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Registry Number</a></th>
                        <th><a href="?sort_column=to_whom_received&sort_order=<?php echo ($sortColumn === 'to_whom_received' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">To Whom Received</a></th>
                        <th><a href="?sort_column=subject&sort_order=<?php echo ($sortColumn === 'subject' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>">Subject</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['date_of_dispatched']); ?></td>
                            <td><?php echo htmlspecialchars($row['registry_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['to_whom_received']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#lettersTable').DataTable();
        });
    </script>
</body>
</html>
