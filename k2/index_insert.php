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
    $clienttype = $_POST['clienttype'];

    // Server-side validation
    if (empty($fname) || empty($gender) || empty($clientnumber)) {
        throw new Exception("All fields are required.");
    }

    // Prepare SQL statement to insert data into client_info table
    $stmt = $conn->prepare("INSERT INTO client_info (fname, gender, clientnumber, office, clienttype, status) VALUES (?, ?, ?, ?, ?, 'waiting')");
    $stmt->bind_param("sssss", $fname, $gender, $clientnumber, $office, $clienttype);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Successfully inserted into database

        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Echo JavaScript alert
        echo "<script>alert('Submitted successfully. Proceed to waiting area.'); window.location.href = 'index.html';</script>";
    } else {
        throw new Exception("Error: " . $stmt->error);
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
