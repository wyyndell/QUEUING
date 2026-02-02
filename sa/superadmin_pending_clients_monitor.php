<!---- superadmin_pending_clients_monitor.php ---->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Office Report</title>
    <link rel="stylesheet" type="text/css" href="css/history.css">
</head>
<body>
	 <h1 style="text-align: center;">Office and its Pending Clients</h1>
<section class="timeline-section">

	<div class="timeline-items">
        <form action="#" method="post" id="office">
            <select name='selected_personnel' onchange='this.form.submit()'>
                <option value=''>Select an office</option>
                <?php
                // Establish database connection
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

                // Query to retrieve name of office and name of personnel from admin table
                $sql = "SELECT office, fname, lname FROM admin WHERE accessibility != 'disable'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Counter variable to keep track of the number
                    $counter = 1;

                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        $office = $row["office"];
                        $fname = $row["fname"];
                        $lname = $row["lname"];
                        $selected = isset($_POST['selected_personnel']) && $_POST['selected_personnel'] == $office ? 'selected' : '';

                        echo "<option value='$office' $selected>$office - $fname $lname</option>";

                        // Increment the counter for the next item
                        $counter++;
                    }
                } else {
                    echo "<option disabled>No active personnel found</option>";
                }

                // Close the first query
                $result->close();

                // Close the database connection
                $conn->close();
                ?>
            </select>
        </form>




        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the selected office value from the form
            if (isset($_POST['selected_personnel'])) {
                $selectedOffice = $_POST['selected_personnel'];

                // Display the selected office
                echo "<input type='hidden' name='selected_office' value='$selectedOffice'>";

                // Establish database connection (replace these with your actual database credentials)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "kiosk";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to retrieve services based on the selected office
                $sql = "SELECT fname, clientnumber, address, email, purpose, clienttype, arrive,
                        TIMESTAMPDIFF(HOUR, arrive, NOW()) AS hours_waiting,
                        TIMESTAMPDIFF(MINUTE, arrive, NOW()) % 60 AS minutes_waiting
                        FROM client_info WHERE office = '$selectedOffice' AND status NOT IN ('done', 'DONE', 'Done')";
                $result = $conn->query($sql);

                // Check if there are results
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="timeline-item">';

                        echo '    <div class="timeline-dot"></div>';
                        echo '    <div class="timeline-date">';
                        echo '        <p>' . $row['hours_waiting'] . ' hours ' . $row['minutes_waiting'] . ' minutes waiting</p>';
                        echo '    </div>';
                        echo '    <div class="timeline-content">';
                        echo '        <h3>' . $row['fname'] . '</h3>';
                        echo '        <h3> CN: ' . $row['clientnumber'] . '</h3>';
                        echo '        <p>Address: ' . $row['address'] . '</p>';
                        echo '        <p>Email: ' . $row['email'] . '</p>';
                        echo '        <p>Request: ' . $row['purpose'] . '</p>';
                        echo '        <p>Client Type: ' . $row['clienttype'] . '</p>';
                        echo '        <p>Time Started: ' . $row['arrive'] . '</p>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    // No records found
                    echo "No records found.";
                }

                // Close the database connection
                $conn->close();
            } else {
                echo "Please select an office.";
            }
        }
        ?>

    </div>
</section>

</body>
</html>
