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

// Get the letter ID from the URL
$id = $_GET['id'];

// Delete letter
try {
    $deleteStmt = $pdo->prepare("DELETE FROM letters WHERE id = ?");
    $deleteStmt->execute([$id]);

    header("Location: dashboard.php?success=2");
    exit();
} catch (PDOException $e) {
    echo "Error deleting letter: " . $e->getMessage();
}
?>
