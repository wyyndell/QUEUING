<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the selected office to delete
    $office = $_POST['office'];

    // Database connection
    $db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

    // Begin a transaction
    $db->beginTransaction();

    try {
        // Delete office from admin table
        $queryAdmin = 'DELETE FROM admin WHERE office = :office';
        $stmtAdmin = $db->prepare($queryAdmin);
        $stmtAdmin->bindParam(':office', $office);
        $stmtAdmin->execute();

        // Delete corresponding services from services table
        $queryServices = 'DELETE FROM services WHERE office = :office';
        $stmtServices = $db->prepare($queryServices);
        $stmtServices->bindParam(':office', $office);
        $stmtServices->execute();

        // Commit the transaction
        $db->commit();

        // Office and corresponding services deleted successfully
        echo '<script>alert("Office and corresponding services deleted successfully."); window.location = "operation.php";</script>';
    } catch (PDOException $e) {
        // Rollback the transaction if an error occurred
        $db->rollBack();

        // Error occurred while deleting
        echo '<script>alert("Error: Unable to delete office and corresponding services."); window.location = "operation.php";</script>';
    }
}
?>
