<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How May We Help You?</title>
    <style>
        /* Import Google font - Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
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

        /* Container for the page content */
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 20px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            color: #4a90e2;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            font-size: 24px;
            color: White; 
            margin-bottom: 9px;
        }
        p.intro {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-bottom: 50px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease-in-out;
            text-align: center;
        }

        .card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .card h2 {
            color: #4a90e2;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .card p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .card a {
            text-decoration: none;
            color: #fff;
            background-color: #4a90e2;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #357abd;
        }

        /* Grid layout for the cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            color: #666;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar a, .navbar button {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <h2>Dispatch System</h2>
        <div>
            <a href="./user_dashboard.php">Dashboard</a>
            <a href="submit_letter.php">Submit Letter</a>
            <a href="settings.php">Settings</a>
            <a href="help.php">Help</a>
            <button class="logout-button" onclick="window.location.href='logout.php';">Logout</button>
        </div>
    </div>

    <div class="container">
        <h1>How May We Help You?</h1>
        <p class="intro">We are here to assist with your queries and concerns. Explore the options below for help or get in touch with us directly.</p>
        
        <div class="grid">
            <div class="card">
                <h2>Account Issues</h2>
                <p>Having trouble accessing your account? Click here to find out how we can assist you.</p>
                <a href="./learn_more_page.php">Learn More</a>
            </div>
            <div class="card">
                <h2>Technical Support</h2>
                <p>Encountering bugs or technical issues? Our support team is here to help you resolve them.</p>
                <a href="./get_help_page.php">Get Help</a>
            </div>
            <div class="card">
                <h2>General Inquiries</h2>
                <p>Have a general question? Let us guide you to the information you need.</p>
                <a href="./contact_us.php">Contact Us</a>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2024 Your Company | All Rights Reserved</p>
        </div>
    </div>

</body>
</html>
