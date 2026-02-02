<?php
// Include database connection
$db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

// Check if the request method is POST and if the new names parameters are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_fname']) && isset($_POST['new_lname']) && isset($_POST['username'])) {
    // Get the new names and username from the POST data
    $newFname = $_POST['new_fname'];
    $newLname = $_POST['new_lname'];
    $username = $_POST['username']; // Assuming you're passing username from the frontend

    // Prepare the SQL statement to update the record with the given username
    $query = 'UPDATE admin SET fname = :new_fname, lname = :new_lname WHERE username = :username';
    $stmt = $db->prepare($query);
    // Bind the parameters
    $stmt->bindParam(':new_fname', $newFname);
    $stmt->bindParam(':new_lname', $newLname);
    $stmt->bindParam(':username', $username); // Bind the username parameter
    // Execute the statement
    $success = $stmt->execute();

    // Optionally, you can send a response back to the client
    // For example, you can echo a success message
    if ($success) {
        echo 'Personnel updated successfully.';
    } else {
        echo 'Failed to update personnel.';
        print_r($stmt->errorInfo()); // Print any errors
    }
    exit; // Exit to prevent further execution
}
?>
