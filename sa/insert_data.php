<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $number = $_POST['client_number'];
    $client_number = $_POST['number'];
    $address = $_POST['address'];
    $request = $_POST['request'];
    $occupation = $_POST['occupation'];
    $time_arrive = $_POST['time_arrive'];
    $office = $_POST['office'];

    // Validate the data (you can add more validation as needed)
    if (empty($name) || empty($number) || empty($request)) {
        // Handle validation errors
        echo "Error: Please fill in all required fields.";
    } else {
        // Connect to the database (replace with your database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "queuewee";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement
        $sql = "INSERT INTO review_data (name, gender, number, client_number, address, request, occupation, time_arrive, office) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssssssss", $name, $gender, $number, $client_number, $address, $request, $occupation, $time_arrive, $office);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // If the form is not submitted, return an error
    echo "Error: Form not submitted.";
}
?>
