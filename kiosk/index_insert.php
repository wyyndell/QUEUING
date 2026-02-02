<?php
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "kiosk";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Extracting data sent via POST request
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $clientnumber = $_POST['clientnumber'];
    $office = $_POST['office'];
    $purpose = $_POST['purpose'];
    $clienttype = $_POST['clienttype'];

    // Server-side validation
    if (empty($fname) || empty($gender) || empty($clientnumber)) {
        throw new Exception("All fields are required.");
    }

    // Prepare SQL statement to insert data into client_info table
    $stmt = $conn->prepare("INSERT INTO client_info (fname, gender, clientnumber, office, purpose, clienttype, status) VALUES (?, ?, ?, ?, ?, ?, 'waiting')");
    $stmt->bind_param("ssssss", $fname, $gender, $clientnumber, $office, $purpose, $clienttype);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Successfully inserted into database

        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Redirect to index.html with a query parameter to indicate success
        header("Location: index.html?status=success");
        exit(); // Ensure script stops here to prevent further execution
    } else {
        throw new Exception("Error: " . $stmt->error);
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
