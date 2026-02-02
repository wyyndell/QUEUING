<?php

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

// Retrieve data from serving table
$sql = "SELECT client_number, name, office, transaction, created_at 
        FROM serving 
        WHERE (office, created_at) IN 
              (SELECT office, MAX(created_at) AS max_created_at 
               FROM serving 
               GROUP BY office)";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Fetch all rows
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Send JSON response
echo json_encode($data);

// Close the database connection
$conn->close();
?>
