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

// Retrieve client information from review_data table
$sqlRetrieve = "SELECT client_number, name, office FROM review_data WHERE client_number = '$clientNumber' AND office = '$office'";
$result = $conn->query($sqlRetrieve);

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    
    // Extract client information
    $clientNumber = $row['client_number'];
    $name = $row['name'];
    $office = $row['office'];

    // Insert client information into the serving table
    $sqlInsert = "INSERT INTO serving (client_number, name, office, transaction) VALUES ('$clientNumber', '$name', '$office', 'serving')";

    // Perform the insertion
    if ($conn->query($sqlInsert) === TRUE) {
        // Send a success response back to the client-side JavaScript
        echo "Inserted into serving successfully.";
    } else {
        // Send an error response for insertion
        echo "Error inserting into serving table: " . $conn->error;
    }
} else {
    // Send an error response if no matching record found
    echo "No matching record found in review_data.";
}

// Close the database connection
$conn->close();
?>
