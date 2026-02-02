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

// Get the client number from the AJAX request
$clientNumber = $_POST['client_number'];

// Check if there are pending clients following the current one
$sqlPending = "SELECT COUNT(*) AS transaction FROM review_data WHERE transaction != 'served'";
$resultPending = $conn->query($sqlPending);

if ($resultPending === FALSE) {
    // Handle query error
    echo "Error checking pending count: " . $conn->error;
    exit();
}

// Fetch pending count
$rowPending = $resultPending->fetch_assoc();
$pendingCount = $rowPending['transaction'];

// Check if there are pending clients
if ($pendingCount == 0) {
    // If there are no pending clients following, insert into serving with an empty value for client_number
    $sqlInsert = "INSERT INTO serving (office, transaction) VALUES ('$office', 'serving')";

    // Perform the insertion
if ($conn->query($sqlInsert) === TRUE) {
    // Update the status of the client to "served" in the review_data table
    $sqlUpdate = "UPDATE review_data
                  SET transaction = 'served', end = NOW()
                  WHERE client_number = '$clientNumber' AND office = '$office'";

    if ($conn->query($sqlUpdate) === TRUE) {
        // Send a success response back to the client-side JavaScript
        echo "Status updated and inserted into serving successfully.";
    } else {
        // Send an error response for update
        echo "Error updating status: " . $conn->error;
    }
} else {
    // Send an error response for insertion
    echo "Error inserting into serving table: " . $conn->error;
}


} else {
    // If there are pending clients following, retrieve client information from review_data table
    $sqlRetrieve = "SELECT client_number, name FROM review_data WHERE client_number = '$clientNumber' AND office = '$office'";
    $resultRetrieve = $conn->query($sqlRetrieve);

    if ($resultRetrieve->num_rows > 0) {
        // Fetch the row
        $row = $resultRetrieve->fetch_assoc();
        
        // Extract client information
        $clientNumber = $row['client_number'];
        $name = $row['name'];

        // Insert client information into the serving table
        $sqlInsert = "INSERT INTO serving (client_number, name, office, transaction) VALUES ('$clientNumber', '$name', '$office', 'serving')";

        // Perform the insertion
        if ($conn->query($sqlInsert) === TRUE) {
            // Update the status of the client to "served" in the review_data table
            $sqlUpdate = "UPDATE review_data SET transaction = 'served' WHERE client_number = '$clientNumber' AND office = '$office'";
            if ($conn->query($sqlUpdate) === TRUE) {
                // Send a success response back to the client-side JavaScript
                echo "Status updated and inserted into serving successfully.";
            } else {
                // Send an error response for update
                echo "Error updating status: " . $conn->error;
            }
        } else {
            // Send an error response for insertion
            echo "Error inserting into serving table: " . $conn->error;
        }
    } else {
        // Send an error response if no matching record found
        echo "No matching record found in review_data.";
        exit(); // Terminate script execution
    }
}

// Close the database connection
$conn->close();
?>
