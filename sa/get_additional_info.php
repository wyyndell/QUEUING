<?php

// Start session
session_start();


// get_additional_info.php
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


// Fetch additional information based on the client number
$client_number = $_GET['client_number'];

$sql = "SELECT gender, number, address, occupation, office, email FROM review_data WHERE client_number = $client_number AND office IN ('$office')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the first (and should be the only) row
    $row = $result->fetch_assoc();

    // Encode the information as JSON and echo it
    echo json_encode($row);
} else {
    // If no matching client number found, return an empty JSON object
    echo json_encode((object)array());
}

// Close the database connection
$conn->close();
?>
