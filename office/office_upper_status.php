<?php
// Database connection parameters
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "kiosk"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve client_id and transform_type from POST data
$client_id = $_POST['client_id'];
$transform_type = $_POST['transform_type'];

// Fetch the existing status for the given client_id
$sql = "SELECT status FROM client_info WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

// Apply the transformation
switch ($transform_type) {
    case 'uppercase':
        $status_transformed = strtoupper($status);
        break;
    case 'lowercase':
        $status_transformed = strtolower($status);
        break;
    case 'sentence':
        $status_transformed = ucfirst(strtolower($status));
        break;
    default:
        $status_transformed = $status; // No transformation
}

// Prepare and execute SQL update statement to update the status with the transformed value
$sql = "UPDATE client_info SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status_transformed, $client_id);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
