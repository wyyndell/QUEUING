<?php
// Database connection
$db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

// Retrieve disabled offices and their corresponding services
$query = "SELECT a.fname, a.lname, a.office, s.services 
          FROM admin AS a
          INNER JOIN services AS s ON a.office = s.office 
          WHERE a.accessibility = 'disable' AND s.accessibility = 'disable'";
$stmt = $db->prepare($query);
$stmt->execute();
$disabled_offices_services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the retrieved data
echo "<h2>Disabled Office(s)</h2>";
echo "<table>";
echo "<thead><tr><th>First Name</th><th>Last Name</th><th>Office</th><th>Action</th></tr></thead>";
echo "<tbody>";
foreach ($disabled_offices_services as $row) {
    echo "<tr>";
    echo "<td>" . $row['fname'] . "</td>";
    echo "<td>" . $row['lname'] . "</td>";
    echo "<td>" . $row['office'] . "</td>";
    // echo "<td>" . $row['services'] . "</td>";
    echo '<td>
            <form action="enable_office_service.php" method="post">
                <input type="hidden" name="office" value="' . $row['office'] . '">
                <input type="submit" value="Enable" name="enable">
            </form>
          </td>';
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>
