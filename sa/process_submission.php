<?php
// Database connection parameters
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "queuewee"; // Replace with your MySQL database name

// Extracting data sent via POST request
$client_number = $_POST['client_number'];
$client_name = $_POST['client_name'];
$client_request = $_POST['client_request'];
$client_time_arrive = $_POST['client_time_arrive'];
$client_gender = $_POST['client_gender'];
$client_number_info = $_POST['client_number_info'];
$client_address = $_POST['client_address'];
$client_occupation = $_POST['client_occupation'];
$client_office = $_POST['client_office'];

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to insert data into review_data table
$sql = "INSERT INTO review_data (client_number, client_name, client_request, client_time_arrive, client_gender, client_number_info, client_address, client_occupation, client_office)
        VALUES ('$client_number', '$client_name', '$client_request', '$client_time_arrive', '$client_gender', '$client_number_info', '$client_address', '$client_occupation', '$client_office')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully"; // Return success message to client-side JavaScript
} else {
    echo "Error: " . $sql . "<br>" . $conn->error; // Return error message if insertion fails
}

// Close the database connection
$conn->close();
?>
