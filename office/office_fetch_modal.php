<?php
header('Content-Type: application/json; charset=UTF-8');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Start session
session_start();

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

// Check if 'office' is set in session
if (!isset($_SESSION['office'])) {
    die(json_encode(["error" => "Office not set in session"]));
}

// Prepare SQL query with a parameterized statement
$sql = "SELECT fname, mname, lname, office, image FROM admin WHERE office != ? AND accessibility != 'disable'";
// $sql = "SELECT fname, mname, lname, office, image FROM admin WHERE office != ? AND accessibility != 'disable'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['office']);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
    // Output all admins' data
    $admins = array();
    while ($row = $result->fetch_assoc()) {
        $imageData = $row['image'];
        $imageBase64 = base64_encode($imageData);
        $admins[] = array(
            'fname' => $row['fname'],
            'name' => $row['mname'],
            'lname' => $row['lname'],
            'office' => $row['office'],
            'image' => 'data:image/jpeg;base64,'. $imageBase64
        );
    }
    echo json_encode($admins); // Encode all admins' data into JSON format
} else {
    echo json_encode(["error" => "No results found"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
