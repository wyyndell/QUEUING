<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "queuewee"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update status column in admin table for the logged-out user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Assuming 'user_id' is the session variable storing the user ID
    $sql_update_status = "UPDATE admin SET status = '' WHERE ID = $user_id";
    if ($conn->query($sql_update_status) === TRUE) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

// Destroy all session data
session_destroy();

// Redirect to the login page
header("Location: admin_login.php");
exit(); // Make sure to stop further execution after redirection
?>
