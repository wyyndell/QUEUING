<?php
// Check if the form is submitted
if (isset($_POST['disable'])) {
    // Get the selected office to update
    $office = $_POST['office'];

    // Database connection
    $db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

    // Begin a transaction
    $db->beginTransaction();

    try {
        // Update admin table to set accessibility to 'disable' for the specified office
        $queryAdmin = 'UPDATE admin SET accessibility = "disable" WHERE office = :office';
        $stmtAdmin = $db->prepare($queryAdmin);
        $stmtAdmin->bindParam(':office', $office);
        $stmtAdmin->execute();

        // Update services table to set accessibility to 'disable' for the specified office
        $queryServices = 'UPDATE services SET accessibility = "disable" WHERE office = :office';
        $stmtServices = $db->prepare($queryServices);
        $stmtServices->bindParam(':office', $office);
        $stmtServices->execute();

        // Commit the transaction
        $db->commit();

        // Office and corresponding services updated successfully
        echo '<script>alert("Office and corresponding services updated successfully."); window.location = "administration_management.php";</script>';
    } catch (PDOException $e) {
        // Rollback the transaction if an error occurred
        $db->rollBack();

        // Error occurred while updating
        echo '<script>alert("Error: Unable to update office and corresponding services."); window.location = "administration_management.php";</script>';
    }
}
?>
