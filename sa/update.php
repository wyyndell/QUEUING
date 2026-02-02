<?php
// Include database connection
$db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

// Check if the request method is POST and if the ID and new service name parameters are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id']) && isset($_POST['new_service_name'])) {
    // Get the ID and new service name from the POST data
    $id = $_POST['update_id'];
    $newServiceName = $_POST['new_service_name'];

    // Prepare the SQL statement to update the record with the given ID
    $query = 'UPDATE services SET services = :new_service_name WHERE id = :id';
    $stmt = $db->prepare($query);
    // Bind the parameters
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':new_service_name', $newServiceName);
    // Execute the statement
    $success = $stmt->execute();

    // Optionally, you can send a response back to the client
    // For example, you can echo a success message
    if ($success) {
        echo 'Service updated successfully.';
    } else {
        echo 'Failed to update service.';
        print_r($stmt->errorInfo()); // Print any errors
    }
    exit; // Exit to prevent further execution
}
?>
