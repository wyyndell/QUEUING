<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "queuewee"; // Replace with your MySQL database name

// Start the session
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get office from session
if(isset($_SESSION['office'])) {
    $office = $_SESSION['office'];
} else {
    // Handle case when office data is not found in session
    echo "Office data not found in session.";
    exit; // Exit the script if office data is not found
}

// Insert office into serving table
$sql_insert_serving = "INSERT INTO serving (client_number, office, transaction) VALUES ('','$office', 'serving')";
if ($conn->query($sql_insert_serving) === TRUE) {
    echo "Office inserted into serving table successfully";
} else {
    echo "Error inserting office into serving table: " . $conn->error;
}

// Close database connection
$conn->close();
?>
