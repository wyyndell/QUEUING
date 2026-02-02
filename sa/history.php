<?php
// Start session
session_start();

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

// Query to retrieve clients based on the office value, and calculate time difference in minutes and hours
$sql = "SELECT name, address, email, request, occupation,
               time_arrive, end,
               TIMESTAMPDIFF(MINUTE, time_arrive, end) AS time_difference_minutes,
               TIMESTAMPDIFF(HOUR, time_arrive, end) AS time_difference_hours
        FROM review_data
        WHERE office = '$office' AND transaction = 'served'";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {

        echo '<h1 style="color: white;">' . htmlspecialchars($office, ENT_QUOTES, 'UTF-8') . "'s Clients' History</h1>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="timeline-item">';
        echo '    <div class="timeline-dot"></div>';
        echo '    <div class="timeline-date">';
        echo '        Time taken: ' . $row['time_difference_hours'] . ' hour(s) and ';
        echo '        ' . $row['time_difference_minutes'] . ' minutes';
        echo '    </div>';
        echo '    <div class="timeline-content">';
        echo '        <h3>' . $row['name'] . '</h3>';
        echo '        <p>Address: ' . $row['address'] . '</p>';
        echo '        <p>Email: ' . $row['email'] . '</p>';
        echo '        <p>Request: ' . $row['request'] . '</p>';
        echo '        <p>Client Type: ' . $row['occupation'] . '</p>';
        echo '        <p>Time Started: ' . $row['time_arrive'] . '</p>';
        echo '        <p>Time Ended: ' . $row['end'] . '</p>';
        echo '    </div>';
        echo '</div>';
    }

} else {
    // No records found
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>
