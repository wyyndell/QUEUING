<?php
session_start();

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiosk";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION['admin'])) {
    // Get the username from the session
    $username = $_SESSION['admin'];

    // Update user status to "offline"
    $update_sql = "UPDATE admin SET status = 'offline' WHERE username = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('s', $username);
    $update_stmt->execute();
    $update_stmt->close();
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Close the database connection
$conn->close();

// Redirect to the login form
header("Location: office_login_form.html");
exit();
?>
