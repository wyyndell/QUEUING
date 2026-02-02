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

$office = $_GET['office'];

$sql = "SELECT services FROM services WHERE office = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $office);
$stmt->execute();
$result = $stmt->get_result();

$services = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $services[] = $row['services'];
    }
}

$stmt->close();
$conn->close();

echo json_encode($services);
?>
