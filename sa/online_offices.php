<?php
// PHP code to fetch and display online offices data
// Make sure this file outputs the desired HTML content

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Assuming there's no password set
$database = "kiosk";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the admin table
$sql = "SELECT fname, lname, office, status FROM admin WHERE accessibility != 'disable'";
$result = mysqli_query($connection, $sql);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Store values in variables
        $fname = $row['fname'];
        $lname = $row['lname'];
        $office = $row['office'];
        $status = $row['status'];

        // Count pending clients for this office
        $pending_sql = "SELECT COUNT(*) AS pending_count FROM client_info WHERE office = '$office' AND status NOT IN ('done', 'DONE', 'Done')";
        $pending_result = mysqli_query($connection, $pending_sql);
        $pending_row = mysqli_fetch_assoc($pending_result);
        $pending_clients_count = $pending_row['pending_count'];
?>

<div class="card">
    <div class="head">
        <div>
            <h2><?php echo $office . "'s Office"; ?></h2>
            <p><?php echo $fname . ' ' . $lname; ?></p>
        </div>
        <i class='bx icon'><?php echo $status; ?></i>
    </div>
    <span class="progress" data-value="<?php echo $pending_clients_count; ?>"></span>
    <span class="label"><?php echo $pending_clients_count; ?> pending client(s)</span>
</div>

<?php
    }
} else {
    echo "No data found";
}

// Close the database connection
mysqli_close($connection);
?>
