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

// Fetch usernames from the database
$sql = "SELECT office FROM admin WHERE accessibility != 'disable'";
$result = $conn->query($sql);

// Check if any usernames were retrieved
if ($result->num_rows > 0) {
    // Display usernames as options
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["office"] . '">' . $row["office"] . '</option>';
    }
} else {
    // If no usernames found, display a message
    echo '<option disabled selected>No offices found</option>';
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve selected username and services from the form
    $selected_username = $_POST['admin_username'];
    $services = $_POST['services'];

    // Iterate over the submitted services and insert each one separately
    for ($i = 0; $i < count($services); $i++) {
        $service = $services[$i];
        $office = $offices[$i];

        // SQL query to insert data into services table
        $sql = "INSERT INTO services (office, services) VALUES ('$selected_username', '$service')";

        if ($conn->query($sql) !== TRUE) {
            // echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo '<script>alert("Service(s) Added"); window.location = "administration_offices.php";</script>';
}


// Close the database connection
$conn->close();
?>
