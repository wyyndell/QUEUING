<?php
// Include database connection
$db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

// Check if the request method is POST and if the ID parameter is set for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    // Code for service deletion
    // This part remains unchanged from your original code
}

// Check if the request method is POST and if the ID parameter is set for update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
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

// Get the selected office from the POST data
$selected_office = $_POST['selected_office'];

// Prepare the SQL query with a placeholder for the office
$query = 'SELECT admin.id, admin.username,admin.fname, admin.lname, admin.office, services.services, services.id
          FROM admin
          INNER JOIN services ON admin.office = services.office
          WHERE admin.office = :selected_office';

// Prepare and execute the statement
$stmt = $db->prepare($query);
$stmt->execute(array(':selected_office' => $selected_office));
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Output the records table name of assigned personnel
echo '<table>';
echo '<tr>';
echo '<th>Assigned Personnel</th>';
echo '<th></th>';
echo '<th></th>';
echo '</tr>';

$uniquePersonnel = []; // Array to store unique personnel names

foreach ($records as $record) {
    $fullName = $record['fname'] . ' ' . $record['lname'];
    // Check if the personnel has already been outputted
    if (!in_array($fullName, $uniquePersonnel)) {
        echo '<tr>';
        echo '<td>' . $fullName . '</td>';
        echo '<td style="display: none;">' . $record['username'] . '</td>'; // Accessing username from $record array
        echo '<td>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <button class="update-admin-btn" data-username="' . $record['username'] . '" style="border: none; background: none;"><i class="fa-regular fa-pen-to-square"></i></button>
              </td>'; // Pass ID as data attribute
        echo '</tr>';
        // Add the personnel to the list of unique personnel
        $uniquePersonnel[] = $fullName;
    }
}
echo '</table>';



// records
echo '<form id="serviceForm" method="post">'; // Form encapsulating the table
echo '<table class="table">';
echo '<thead class="thead-dark">';
echo '<th>Services</th>';
echo '<th style="display: none;">ID</th>';
echo '<th></th>';
echo '</thead>';
echo '<tbody>';
foreach ($records as $record) {
    echo '<tr>';
    echo '<td>' . $record['services'] . '</td>';
    echo '<td style="display: none;">' . $record['id'] . '</td>';
    echo '<td>
            <button class="delete-btn" data-id="' . $record['id'] . '">Delete</button>
            <button class="update-btn" data-id="' . $record['id'] . '">Update</button>
          </td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</form>'; // Close the form

?>

<script src="js/delete.js">

</script>
