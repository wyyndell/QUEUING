<?php
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection parameters
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "kiosk"; // Replace with your MySQL database name

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Extracting data sent via POST request
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $clientnumber = $_POST['clientnumber'];
    $purpose = $_POST['purpose'];

    // Server-side validation
    if (empty($fname) || empty($lname) || empty($clientnumber) || empty($purpose)) {
        throw new Exception("All fields except Middle Name are required.");
    }

    // Prepare SQL statement to insert data into client_info table
    $stmt = $conn->prepare("INSERT INTO client_info (fname, mname, lname, clientnumber, purpose, status) VALUES (?, ?, ?, ?, ?,'waiting')");
    $stmt->bind_param("sssis", $fname, $mname, $lname, $clientnumber, $purpose);

    if ($stmt->execute() === TRUE) {
        // Return HTML for modal
        echo "
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' integrity='sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==' crossorigin='anonymous' referrerpolicy='no-referrer' />
        <link rel='stylesheet' href='css/style.css'>
        <div id='successModal' class='modal'>
            <div class='modal-content'>
                <i class='fa-solid fa-circle-check' style='color: #B197FC; font-size: 60px;'></i>
                <p>Successfully Added!</p>
            </div>
        </div>
        <script>
            var modal = document.getElementById('successModal');
            modal.style.display = 'block';
            setTimeout(function() {
                modal.style.display = 'none';
                window.location.href = 'index.html';
            }, 2000);
        </script>
        ";
    } else {
        throw new Exception("Error: " . $stmt->error); // Return error message if insertion fails
    }
    

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
