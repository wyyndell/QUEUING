<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit();
}

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

// Check if the office of the logged-in user is set in the session
if (isset($_SESSION['office'])) {
    $logged_in_office = $_SESSION['office'];

    // Fetch data from the admin table excluding the office of the logged-in user
    $sql = "SELECT DISTINCT office FROM admin WHERE office != ? AND accessibility !='disable'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $logged_in_office);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        // Initialize an empty array to store the offices
        $offices = array();

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $offices[] = $row["office"];
        }

        // Encode the array as JSON and output it
        echo json_encode($offices);
    } else {
        // No offices found
        echo json_encode(array("message" => "No offices found"));
    }
} else {
    // Office of logged-in user is not set in the session
    echo json_encode(array("message" => "Office of logged-in user not set"));
}

// Close database connection
$conn->close();
?>
