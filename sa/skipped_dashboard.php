<?php

// Start session
session_start();

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

// Retrieve the office value from session
$office = $_SESSION['office'];


// Get the client number from the AJAX request
$clientNumber = $_POST['client_number'];

// Update the status of the client to "served" in the database
$sql = "UPDATE review_data SET transaction = 'skipped' WHERE client_number = '$clientNumber' AND office IN ('$office')";

if ($conn->query($sql) === TRUE) {
    // Send a success response back to the client-side JavaScript
    echo "Status updated successfully.";
} else {
    // Send an error response back to the client-side JavaScript
    echo "Error updating status: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
