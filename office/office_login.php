<?php
session_start();

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiosk";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a SQL statement to prevent SQL injection
    $sql = "SELECT username, fname, mname, lname, office, shareto, password, image FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given username exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the provided password against the stored hash
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session and store user info
            $_SESSION['admin'] = $user['username'];
            $_SESSION['full_name'] = $user['fname'] . ' ' . $user['mname'] . ' ' . $user['lname'];
            $_SESSION['office'] = $user['office'];
            $_SESSION['shareto'] = $user['shareto'];
            // Convert image to base64
            $_SESSION['image'] = base64_encode($user['image']);

            // Update user status to "online"
            $update_sql = "UPDATE admin SET status = 'online' WHERE username = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param('s', $username);
            $update_stmt->execute();
            $update_stmt->close();

            // Redirect to office page
            header("Location: office.php");
            exit;
        } else {
            // Incorrect password
            echo "Invalid username or password.";
        }
    } else {
        // Username not found
        echo "Invalid username or password.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
