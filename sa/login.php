<?php
session_start(); // Start the session

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST["username"]; // Changed from "user-id" to "username"
    $password = $_POST["password"];

    // Prepare SQL query to retrieve data based on username
    $sql = "SELECT * FROM admin WHERE username = '$username' AND accessibility != 'disable'"; // Changed from "id" to "username"
    // $sql = "SELECT * FROM admin WHERE username = '$username'"; // Changed from "id" to "username"
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();

        // Verify password
        if ($password === $row["password"]) {
            // Password is correct, log in successful
            // Set the user_id session variable
            $_SESSION['user_id'] = $row["id"]; // Assuming 'id' is the primary key in the admin table
            // Redirect to dashboard or other page
            header("Location: office_dashboard.php"); // Redirect to dashboard.php
            exit(); // Make sure to stop further execution after redirection
        } else {
            // Password is incorrect
            echo "Incorrect password. Please try again.";
        }
    } else {
        // Username not found
        echo "Username not found or user is disabled. Please check your credentials.";
    }
}
?>
