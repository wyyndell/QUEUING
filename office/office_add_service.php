<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiosk";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

// Check if office is set in session
if (!isset($_SESSION['office'])) {
    die(json_encode(["success" => false, "error" => "Office not set in session"]));
}

// Get office from session
$office = $_SESSION['office'];

// Get service to add from POST data
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['service'])) {
    die(json_encode(["success" => false, "error" => "Service not specified"]));
}

$service = $data['service'];

$sql = "INSERT INTO services (office, services) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $office, $service);
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Error adding service: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
