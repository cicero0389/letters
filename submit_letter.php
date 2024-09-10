<?php 
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

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_of_dispatched = $_POST['date_of_dispatched'];
    $registry_number = $_POST['registry_number'];
    $to_whom_received = $_POST['to_whom_received'];
    $date_of_letter = $_POST['date_of_letter'];
    $number_of_letter = $_POST['number_of_letter'];
    $subject = $_POST['subject'];
    $remarks = $_POST['remarks'];
    $department_email = $_POST['department_email'];

    try {
        $stmt = $pdo->prepare("INSERT INTO letters (date_of_dispatched, registry_number, to_whom_received, date_of_letter, number_of_letter, subject, remarks, department_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$date_of_dispatched, $registry_number, $to_whom_received, $date_of_letter, $number_of_letter, $subject, $remarks, $department_email]);

        $successMessage = "Letter submitted successfully!";
    } catch (PDOException $e) {
        $errorMessage = "Error submitting letter: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Letter</title>
    <style>
        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 0;
        }

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

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 0 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .navbar a:hover {
            background-color: #357abd;
        }

        .navbar .logout-button {
            background-color: #d9534f;
            border: none;
            color: #fff;
            padding: 10px;
            margin: 0 5px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .navbar .logout-button:hover {
            background-color: #c9302c;
        }

        .container {
            position: relative;
            max-width: 700px;
            width: 100%;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .container header {
            font-size: 1.5rem;
            color: #333;
            font-weight: 500;
            text-align: center;
        }

        .form {
            margin-top: 30px;
        }

        .input-box {
            width: 100%;
            margin-top: 20px;
        }

        .input-box label {
            color: #333;
        }

        .input-box input, .input-box textarea {
            position: relative;
            height: 50px;
            width: 100%;
            outline: none;
            font-size: 1rem;
            color: #707070;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0 15px;
        }

        .input-box textarea {
            height: auto;
            padding: 10px;
        }

        .input-box input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        button {
            height: 55px;
            width: 100%;
            color: #fff;
            font-size: 1rem;
            font-weight: 400;
            margin-top: 30px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            background: rgb(130, 106, 251);
        }

        button:hover {
            background: rgb(88, 56, 250);
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive */
        @media screen and (max-width: 500px) {
            .input-box {
                margin-top: 15px;
            }
        }
    </style>
    <script>
        function showAlert(message, type) {
            var alertDiv = document.createElement('div');
            alertDiv.className = 'message ' + type;
            alertDiv.textContent = message;
            document.querySelector('.container').prepend(alertDiv);

            setTimeout(function() {
                window.location.href = 'dashboard.php'; // Redirect to the dashboard
            }, 2000); // Redirect after 2 seconds
        }

        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($successMessage): ?>
                showAlert("<?php echo addslashes($successMessage); ?>", "success-message");
            <?php elseif ($errorMessage): ?>
                showAlert("<?php echo addslashes($errorMessage); ?>", "error-message");
            <?php endif; ?>
        });
    </script>
</head>
<body>
    <div class="navbar">
        <h1>Dispatch System</h1>
        <div>
            <a href="./user_dashboard.php">Home</a>
            <a href="./user_dashboard.php">View Letters</a>
             <a href="help.php">Help</a>
            <button class="logout-button" onclick="window.location.href='logout.php';">Logout</button>
        </div>
    </div>
    <div class="container">
        <header>Submit Letter</header>
        <form method="POST" class="form">
            <div class="input-box">
                <label for="date_of_dispatched">Date of Dispatched:</label>
                <input type="date" id="date_of_dispatched" name="date_of_dispatched" required>
            </div>
            <div class="input-box">
                <label for="registry_number">Registry Number:</label>
                <input type="text" id="registry_number" name="registry_number" required>
            </div>
            <div class="input-box">
                <label for="to_whom_received">To Whom Received:</label>
                <input type="text" id="to_whom_received" name="to_whom_received" required>
            </div>
            <div class="input-box">
                <label for="date_of_letter">Date of Letter:</label>
                <input type="date" id="date_of_letter" name="date_of_letter" required>
            </div>
            <div class="input-box">
                <label for="number_of_letter">Number of Letter:</label>
                <input type="text" id="number_of_letter" name="number_of_letter" required>
            </div>
            <div class="input-box">
                <label for="subject">Subject:</label>
                <textarea id="subject" name="subject" rows="4" required></textarea>
            </div>
            <div class="input-box">
                <label for="remarks">Remarks:</label>
                <textarea id="remarks" name="remarks" rows="4" required></textarea>
            </div>
            <div class="input-box">
                <label for="department_email">Department Email:</label>
                <input type="email" id="department_email" name="department_email" required>
            </div>
            <button type="submit">Submit Letter</button>
        </form>
    </div>
</body>
</html>
