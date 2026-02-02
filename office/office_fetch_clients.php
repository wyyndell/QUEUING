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

// Prepare SQL query to count waiting clients
$count_sql = "SELECT COUNT(*) as total_waiting FROM client_info WHERE status <> 'done' AND office = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param('s', $office);
$count_stmt->execute();
$count_result = $count_stmt->get_result();

if ($count_result) {
    $total_waiting = $count_result->fetch_assoc()['total_waiting'];
} else {
    die(json_encode(["error" => "Error fetching waiting clients count: " . $conn->error]));
}

// Prepare SQL query to fetch waiting clients
$sql = "SELECT id, fname, mname, lname, clientnumber, purpose, email, arrive, filter, transferred 
        FROM client_info 
        WHERE status <> 'done'
        AND office = ?
        ORDER BY filter 
        LIMIT 3";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $office);
$stmt->execute();
$result = $stmt->get_result();

$clients = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Calculate the time difference
        $arrive_time = new DateTime($row['arrive']);
        $current_time = new DateTime();
        $interval = $current_time->diff($arrive_time);

        // Format the time difference
        if ($interval->i < 1) {
            $time_difference = 'Just Now';
        } elseif ($interval->i == 1) {
            $time_difference = '1 min';
        } else {
            $time_difference = $interval->i . ' mins';
        }

        $clients[] = [
            'clientnumber' => $row['clientnumber'],
            'id' => $row['id'],
            'name' => $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'],
            'purpose' => $row['purpose'],
            'email' => $row['email'],
            'arrive' => $row['arrive'],
            'time_difference' => $time_difference,
            'transferred' => $row['transferred']
        ];
    }
} else {
    die(json_encode(["error" => "Error fetching waiting clients: " . $conn->error]));
}

// Close statement and connection
$stmt->close();
$conn->close();

echo json_encode([
    'total_waiting' => $total_waiting,
    'clients' => $clients
]);
?>
