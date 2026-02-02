<?php
// Establish database connection (adjust credentials as necessary)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiosk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch latest client info for each office based on filter (timestamp)
$sql = "SELECT id, fname, mname, lname, clientnumber, office, filter
        FROM client_info ci
        WHERE status = 'done'
        AND filter = (
            SELECT MAX(filter) 
            FROM client_info 
            WHERE office = ci.office
            AND status = 'done'
        )
        ORDER BY office"; // Order by office to maintain consistent order if needed

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data
    $clientInfos = array();
    while ($row = $result->fetch_assoc()) {
        $clientInfo = array(
            'clientnumber' => $row['clientnumber'],
            'office' => $row['office'],
            'fname' => $row['fname'],
            'mname' => $row['mname'],
            'lname' => $row['lname'],
            'filter' => $row['filter']
        );
        $clientInfos[] = $clientInfo;
    }
    echo json_encode($clientInfos);
} else {
    echo json_encode(array()); // Return empty array if no data found
}

$conn->close();
?>
