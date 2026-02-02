<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "kiosk"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the office value from session
$office = $_SESSION['office'];

// Query to retrieve pending clients based on the office value
$sql = "SELECT * FROM client_info WHERE office IN ('$office') AND status NOT IN ('done', 'DONE', 'Done') ORDER BY filter";
$result = $conn->query($sql);

$pending_clients = [];

if ($result->num_rows > 0) {
    // Fetch and store pending clients' data
    while($row = $result->fetch_assoc()) {
        $pending_clients[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($pending_clients);
?>
