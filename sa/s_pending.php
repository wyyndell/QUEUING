<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap');
        :root {
            --primary-clr: rgb(151, 49, 49, 1);
            --secondary-clr: #9B4444;
            --blck: rgb(34, 40, 49);
            --black-coral: hsla(220, 12%, 43%, 1);
            --black: #0C0C0C;
            --subtle--: #E9EBF0;
            --white--: #FEFBF6;
            --background-clr: #F7F7F7;
            --red--: #E72929;
            --ff-manrope: 'Inter', sans-serif;
            --ff1-montserrat: 'Montserrat', sans-serif;
            --ff2--urbanist: 'Urbanist', sans-serif;
            --section-padding: 90px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--ff-manrope);
            margin: 0;
            padding: 12px;
            background-color: var(--background-clr);
        }

        .container {
            max-width: 1190px;
            margin-inline: auto;
            padding-block: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            border-radius: 4px;
            overflow: hidden;
            border: 2px solid rgba(0, 0, 0, 0.1);
        }

        th, td {
            background-color: rgba(255, 255, 255, 1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.2);
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-container {
            text-align: right;
            margin-top: 20px;
        }

        .view-all-btn {
            background-color: rgb(233, 235, 240);
            color: #0C0C0C;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .view-all-btn:hover {
            background-color: rgb(233, 235, 240, 0.5);
        }

        .table {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="#" method="post" id="office">
            <select name="selected_personnel" onchange="this.form.submit()">
                <option value="">Select an office</option>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "kiosk";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT office, fname, lname FROM admin WHERE accessibility != 'disable'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $office = $row["office"];
                        $fname = $row["fname"];
                        $lname = $row["lname"];
                        $selected = (isset($_POST['selected_personnel']) && $_POST['selected_personnel'] == $office) ? 'selected' : '';
                        echo "<option value='$office' $selected>$office - $fname $lname</option>";
                    }
                } else {
                    echo "<option disabled>No active personnel found</option>";
                }

                $result->close();
                $conn->close();
                ?>
            </select>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_personnel'])) {
            $selectedOffice = $_POST['selected_personnel'];
            echo "<input type='hidden' name='selected_office' value='$selectedOffice'>";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT fname, clientnumber, gender, address, email, purpose, clienttype, arrive,
                    TIMESTAMPDIFF(HOUR, arrive, NOW()) AS hours_waiting,
                    TIMESTAMPDIFF(MINUTE, arrive, NOW()) % 60 AS minutes_waiting
                    FROM client_info WHERE office = ? AND status NOT IN ('done', 'DONE', 'Done')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $selectedOffice);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
            <table>
                <div class="table">
                    <div class="table-title">
                        <h1>Client List</h1>
                    </div>
                    <div class="button-container">
                        <button class="view-all-btn">View All</button>
                    </div>
                </div>
                <tr>
                    <th>#</th>
                    <th>Client number</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Waiting time</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $counter . '</td>';
                        echo '<td>' . $row['clientnumber'] . '</td>';
                        echo '<td>' . $row['fname'] . '</td>';
                        echo '<td>' . $row['gender'] . '</td>';
                        echo '<td>' . $row['hours_waiting'] . ' hours ' . $row['minutes_waiting'] . ' minutes waiting</td>';
                        echo '</tr>';
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found.</td></tr>";
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "<tr><td colspan='5'>Please select an office.</td></tr>";
            }
            ?>
            </table>
        <?php
        
        ?>
    </div>
</body>
</html>
