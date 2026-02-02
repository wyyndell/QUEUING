<?php
// office_share.php

// Start session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiosk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Check if office is set in session
if (!isset($_SESSION['office'])) {
    die(json_encode(["error" => "Office not set in session"]));
}

// Get office from session
$office = $_SESSION['office'];

// Check if client_id and office are provided via POST
if (!isset($_POST['client_id']) || !isset($_POST['office'])) {
    echo json_encode(['error' => 'Client ID and office are required']);
    exit;
}

// Sanitize inputs
$client_id = intval($_POST['client_id']); // Assuming client_id is integer
$new_office = $_POST['office'];

// Fetch client's information based on client_id
$query = "SELECT * FROM client_info WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt === false) {
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $client_id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    $result_set = mysqli_stmt_get_result($stmt);
    $client_info = mysqli_fetch_assoc($result_set);

    // Check if client was found
    if (!$client_info) {
        echo json_encode(['error' => 'Client not found with ID: ' . $client_id]);
        exit;
    }

    // Insert a new record with the same client's information but updated office
    $insert_query = "INSERT INTO client_info (fname, mname, lname, clientnumber, purpose, office, gender, address, email, contactnumber, status, arrive, ended, filter, transferred)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_insert = mysqli_prepare($conn, $insert_query);

    if ($stmt_insert === false) {
        echo json_encode(['error' => 'Failed to prepare insert statement']);
        exit;
    }

    // Set status as "waiting" for the new record
    $status = "waiting";

    mysqli_stmt_bind_param($stmt_insert, 'sssssssssssssss', 
        $client_info['fname'], 
        $client_info['mname'], 
        $client_info['lname'], 
        $client_info['clientnumber'], 
        $client_info['purpose'], 
        $new_office, // Update office with new value
        $client_info['gender'], 
        $client_info['address'], 
        $client_info['email'], 
        $client_info['contactnumber'], 
        $status, // Set status as "waiting"
        $client_info['arrive'], 
        $client_info['ended'], 
        $client_info['filter'],
        $office // Store the original office in the transferred column
    );

    $insert_result = mysqli_stmt_execute($stmt_insert);

    if ($insert_result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error inserting client with new office: ' . mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt_insert);
} else {
    echo json_encode(['error' => 'Error fetching client information: ' . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
