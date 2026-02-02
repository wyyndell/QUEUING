<?php
// Check if the form is submitted
if (isset($_POST['enable'])) {
    // Get the selected office to enable
    $office = $_POST['office'];

    // Database connection
    $db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

    // Begin a transaction
    $db->beginTransaction();

    try {
        // Update admin table to set accessibility to 'enable' for the specified office
        $queryAdmin = 'UPDATE admin SET accessibility = "enable" WHERE office = :office';
        $stmtAdmin = $db->prepare($queryAdmin);
        $stmtAdmin->bindParam(':office', $office);
        $stmtAdmin->execute();

        // Update services table to set accessibility to 'enable' for the specified office
        $queryServices = 'UPDATE services SET accessibility = "enable" WHERE office = :office';
        $stmtServices = $db->prepare($queryServices);
        $stmtServices->bindParam(':office', $office);
        $stmtServices->execute();

        // Commit the transaction
        $db->commit();

        // Office and corresponding services enabled successfully
        echo '<script>alert("Office and corresponding services enabled successfully."); window.location = "operation.php";</script>';
    } catch (PDOException $e) {
        // Rollback the transaction if an error occurred
        $db->rollBack();

        // Error occurred while enabling
        echo '<script>alert("Error: Unable to enable office and corresponding services."); window.location = "operation.php";</script>';
    }
}
?>
