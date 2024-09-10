<!-- navbar.php -->
<?php
function navbar() {
    echo '
    <div class="navbar">
        <h1>Dispatch System</h1>
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="submit_letter.php">Submit Letter</a>
            <a href="settings.php">Settings</a>
            <a href="help.php">Help</a>
            <form method="POST" action="logout.php" style="display: inline;">
                <button class="logout-button" name="logout">Logout</button>
            </form>
        </div>
    </div>
    <style>
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
    </style>
    ';
}
?>
