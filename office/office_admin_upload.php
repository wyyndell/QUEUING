<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiosk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 300); // 300 seconds (5 minutes)

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $fname = htmlspecialchars($_POST['fname']);
    $mname = htmlspecialchars($_POST['mname']);
    $lname = htmlspecialchars($_POST['lname']);
    $share = htmlspecialchars($_POST['share']);
    $office = htmlspecialchars($_POST['office']);

    // Handle the image file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = file_get_contents($image);
    } else {
        // If no image is uploaded, set the path to the default image
        $defaultImagePath = 'C:/xampp/htdocs/Q/office/img/plogo.png'; // Absolute path to the default image
        if (file_exists($defaultImagePath)) {
            $imgContent = file_get_contents($defaultImagePath);
        } else {
            die("Default image not found.");
        }
    }

    // Check if the username already exists
    $checkQuery = "SELECT username FROM admin WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('s', $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Error: Username '$username' already taken. Please choose a different username.";
    } else {
        // Insert data into the database
        $insertQuery = "INSERT INTO admin (username, password, fname, mname, lname, office, shareto, image) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('ssssssss', $username, $password, $fname, $mname, $lname, $office, $share, $imgContent);

        if ($stmt->execute()) {
            // Redirect to the login page after successful insertion
            header("Location: office_login_form.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>
