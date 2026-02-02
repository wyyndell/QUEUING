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

// Fetch name and office of the currently logged-in user
$user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in a session variable
$sql = "SELECT id, fname, office FROM admin WHERE id = '$user_id'";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Fetch the data of the currently logged-in user
    $row = $result->fetch_assoc();
    $name = $row["fname"];
    $id = $row["id"];
    $office = $row["office"];

    // Set office value in session
    $_SESSION['office'] = $office;

    // Output the welcome message and office
    echo "<span>Welcome Back, Admin $name</span>";
    echo "<p>$office's Office</p>";
    echo "<p style='display: none;'>$id</p>";
} else {
    // Handle case when user data is not found
    echo "User data not found.";
}

// Close database connection
$conn->close();
?>
