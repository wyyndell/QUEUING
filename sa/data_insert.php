<?php
// Establish database connection (replace these with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "queuewee";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS review_data (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    number VARCHAR(15) NOT NULL,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    client_number INT(10) NOT NULL,
    request TEXT,
    occupation VARCHAR(255) NOT NULL,
    time_arrive TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    office VARCHAR(255) NOT NULL,
    transaction VARCHAR(255) DEFAULT 'waiting'
)";

if ($conn->query($sql_create_table) !== TRUE) {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = $_POST["uname"];
    $gender = $_POST["gender"];
    $number = $_POST["number"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $clientNumber = $_POST["client_number"];
    $request = isset($_POST["services"]) ? implode(",", $_POST["services"]) : "";
    $occupation = implode(",", $_POST["usertype"]);
    $office = $_POST["selected_office"];

    // Insert the data into the database
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO review_data (name, gender, number, address, email, client_number, request, occupation, office) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $gender, $number, $address, $email, $clientNumber, $request, $occupation, $office);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Redirect to client_index.php
        header("Location: index.php");
        exit(); // Ensure script stops execution after redirection
    } else {
        echo "Error: " . $conn->error . "<br>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
