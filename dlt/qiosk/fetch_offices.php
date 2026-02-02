<?php
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

$sql = "SELECT DISTINCT office FROM admin";
$result = $conn->query($sql);

$offices = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $offices[] = $row['office'];
    }
}

$conn->close();

echo json_encode($offices);
?>
