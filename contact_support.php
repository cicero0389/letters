<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate the form data
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Sanitize data
        $name = htmlspecialchars($name);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars($message);

        // Check if the email is valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Send the support request (here you would normally send an email or save to database)
            // For this example, we'll just simulate the process

            // Simulate sending email (you could use mail() function for real emails)
            $to = 'support@yourcompany.com';
            $subject = 'New Support Request from ' . $name;
            $headers = 'From: ' . $email . "\r\n" .
                       'Reply-To: ' . $email . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            $mail_sent = true; // Simulate a successful email send
            
            if ($mail_sent) {
                // Store the success message in session
                $_SESSION['success'] = "Thank you for contacting support. We'll get back to you shortly!";
            } else {
                // Store the error message in session
                $_SESSION['error'] = "There was a problem sending your request. Please try again later.";
            }

            // Redirect back to the Get Help page
            header('Location: get_help.php');
            exit;
        } else {
            // Invalid email format
            $_SESSION['error'] = "Please provide a valid email address.";
        }
    } else {
        // One or more fields are empty
        $_SESSION['error'] = "All fields are required. Please fill in the form completely.";
    }

    // Redirect back to the Get Help page with the error message
    header('Location: get_help.php');
    exit;
}
?>
