<?php
// Include database connection
$db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

// Check if the request method is POST and if the ID parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    // Get the ID parameter value
    $id = $_POST['delete_id'];

    // Prepare the SQL statement to delete the record with the given ID
    $query = 'DELETE FROM services WHERE id = :id';
    $stmt = $db->prepare($query);
    // Bind the ID parameter
    $stmt->bindParam(':id', $id);
    // Execute the statement
    $success = $stmt->execute();

    // Optionally, you can send a response back to the client
    // For example, you can echo a success message
    if ($success) {
        echo 'Service deleted successfully.';
    } else {
        echo 'Failed to delete service.';
        print_r($stmt->errorInfo()); // Print any errors
    }
    exit; // Exit to prevent further execution
} else {
    // If the request method is not POST or if the ID parameter is not set, return an error
    echo 'Invalid request.';
}
?>
