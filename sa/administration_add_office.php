<?php
    // Initialize variables for alert messages
    $successMessage = '';
    $errorMessage = '';

    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=queuewee', 'root', '');

    // Check if the user has submitted the form
    if (isset($_POST['submit'])) {
        // Get the user credentials
        $username = $_POST['username'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $office = $_POST['office'];

        // Insert the data into the database
        $query = 'INSERT INTO admin (username, fname, lname, office, password) VALUES (:username, :fname, :lname, :office, :password)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':office', $office);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            // Set success message
            echo '<script>alert("Office Added"); window.location = "administration_management.php";</script>';
        } else {
            // Set error message
            $errorMessage = 'Error: Unable to insert record.';
        }
    }
    ?>
