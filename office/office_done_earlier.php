<?php
// Set the default time zone to Philippines
date_default_timezone_set('Asia/Manila');

// Start session
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiosk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Check if office is set in session
if (!isset($_SESSION['office'])) {
    die(json_encode(["error" => "Office not set in session"]));
}

// Get office from session
$office = $_SESSION['office'];

// Prepare SQL query to fetch a single client where status is "done"
$sql = $conn->prepare("SELECT fname, mname, lname, purpose, arrive, ended 
                       FROM client_info 
                       WHERE status = 'done' AND office = ? 
                       ORDER BY ended DESC 
                       LIMIT 1");

$sql->bind_param("s", $office);

// Execute the query
$sql->execute();

// Get the result
$result = $sql->get_result();

$client = null;

if ($result) {
    if ($row = $result->fetch_assoc()) {
        $client = [
            'name' => $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'],
            'purpose' => $row['purpose'],
            'arrive' => $row['arrive'],
            'ended' => $row['ended']
        ];
    }
} else {
    die(json_encode(["error" => "Error fetching done client: " . $conn->error]));
}

// Close the prepared statement
$sql->close();

// Close connection
$conn->close();

echo json_encode([
    'client' => $client
]);
?>
