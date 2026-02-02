

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PUP Kiosk</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="header">
        <div class="img-container">
            <img src="img/Header.jpg" alt="header-image">
        </div>
            <div class="header-nav">
                <h1 class="company-name">Polytechnic University of the Philippines <br>Unisan Campus</h1>
                <div class="datetime">
                    <div class="date-time">
                        <span class="date"></span>
                        <span class="year"></span>
                    </div>
                    <div class="time-day">
                        <span class="time"></span>
                        <span class="day"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Section

        <div class="welcome" id="command">
            <h1>Welcome to Unisan Campus</h1>
            <p>To start click <span style="color: var(--blck); font-weight: 500;">'Continue'</span> below</p>
            <div class="btn">
                <button id="proceedButton">Continue</button>
            </div>
        </div>-->
    </div>

    <div class="container">
        <!-- Step 1: Select Office -->
        <div class="step active" id="step1">
            <!-- Form for selecting office -->
            <form action="#" method="post" id="office">
                <?php
                // Establish database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "queuewee";

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

                    // Check if the current office has been submitted
                    $submittedClass = isset($_POST['selected_personnel']) && $_POST['selected_personnel'] == $office ? 'submitted' : '';

                    echo "<div class='btn_office'>
                                <button type='submit' name='selected_personnel' value='$office' class='$submittedClass'>
                                    <div class='info'>
                                        <div id='registrar'><b style='font-size: 150px; margin: 10px;'>W$counter</b></div>
                                        <div id='name' style='line-height: 1px; margin-top: 50px;'><b>$office</b><br><p style='font-size: 40px;'>$fname $lname</p></div>
                                    </div>
                                </button>
                              </div>";

                    // Increment the counter for the next item
                    $counter++;
                }

                } else {
                    echo "<p>No active personnel found</p>";
                }

                // Close the first query
                $result->close();

                // Close the database connection
                $conn->close();
                ?>
            </form>
            <div class="buttons">
                <button id="next1" style='width: 100%;'>Next</button>
            </div>
        </div>

        <!-- Step 2: Select Services -->
        <div class="step" id="step2">
            <!-- Form for selecting services -->
            <form action="data_insert.php" method="post" id="dataForm">
            <h1 style="font-size: 60px; line-height: 1px; margin: none;">Services</h1>
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
                        $dbname = "queuewee";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query to retrieve services based on the selected office
                        $sql = "SELECT services FROM services WHERE office = '$selectedOffice' AND accessibility != 'disable'";
                        $result = $conn->query($sql);

                        // Output the fetched services
                        if ($result->num_rows > 0) {
                            echo "<h1 style='font-size: 40px;'>$selectedOffice's Services</h1>";
                            echo "<ul style='text-decoration: none; list-style-type: none;'>";

                            while ($row = $result->fetch_assoc()) {
                                $service = $row["services"];
                                // Display custom-styled checkboxes and labels
                                echo "<li>";
                                echo "<label class='custom-checkbox'>";
                                echo "<input type='checkbox' name='services[]' value='$service'>";
                                echo "<span class='checkmark'></span>";
                                echo "<span style='font-size: 50px; line-height: 2rem;'>$service</span>";
                                echo "</label>";
                                echo "</li>";
                            }

                            echo "</ul>";
                        } else {
                            echo "No services found for $selectedOffice";
                        }

                        // Close the database connection
                        $conn->close();
                    } else {
                        echo "Please select an office.";
                    }
                }
                ?>



            <div class="buttons">
                <button id="prev2" class="prev">Previous</button>
                <button id="next2">Next</button>
            </div>
        </div>

        <!-- Step 3: Basic Information -->
        <div class="step" id="step3">
            <!-- Form for basic information -->
            <h1>Basic Information</h1>

                <label for="uname">Name:</label>
                <input type="text" id="uname" name="uname" required><br><br>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select><br><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="phone">Cellphone Number:</label>
                <input type="text" id="phone" name="number" required><br><br>

            <div class="buttons">
                <button id="prev3" class="prev">Previous</button>
                <button id="next3">Next</button>
            </div>
        </div>

        <!-- Step 4: Client Number and User Type -->
                <div class="step" id="step4">
                    <h1>Client Number</h1>
                    <!-- Form for client number and user type -->
                    <label for="client_number">Client Number:</label>
                    <input type="text" id="client_number" name="client_number" required><br><br>

                    <div class="custom-checkbox">
                        <input type="checkbox" id="student" name="usertype[]" value="student">
                        <label for="student" class="checkmark"></label>
                        <label for="student">Student</label><br>

                        <input type="checkbox" id="alumni" name="usertype[]" value="alumni">
                        <label for="alumni" class="checkmark"></label>
                        <label for="alumni">Alumni</label><br>

                        <input type="checkbox" id="visitor" name="usertype[]" value="visitor">
                        <label for="visitor" class="checkmark"></label>
                        <label for="visitor">Visitor</label><br>

                        <input type="checkbox" id="parent" name="usertype[]" value="parent">
                        <label for="parent" class="checkmark"></label>
                        <label for="parent">Parent</label><br><br>
                    </div>

                    <div class="buttons">
                        <button id="prev4" class="prev">Previous</button>
                        <button type="button" onclick="openModal()">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <h1>Are you sure you want to submit?</h1>
            <!-- Display user input -->
            <div id="reviewData">
                <!-- User inputted data will be displayed here -->
            </div>
            <div class="modal-btn">
                <button onclick="submitForm()">Yes</button>
                <button onclick="closeModal()">No</button>
            </div>
        </div>
    </div>

    <script src="js/client.js"></script>

    <script>
        // JavaScript
        const steps = document.querySelectorAll('.step');
        let currentStep = 0;

        function showStep(stepNumber) {
            steps.forEach((step, index) => {
                if (index === stepNumber) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });
        }

        function nextStep() {
            currentStep++;
            if (currentStep >= steps.length) {
                currentStep = steps.length - 1;
            }
            showStep(currentStep);
        }

        function prevStep() {
            currentStep--;
            if (currentStep < 0) {
                currentStep = 0;
            }
            showStep(currentStep);
        }

        // Button event listeners
        document.getElementById('next1').addEventListener('click', nextStep);
        document.getElementById('next2').addEventListener('click', nextStep);
        document.getElementById('next3').addEventListener('click', nextStep);
        document.getElementById('prev2').addEventListener('click', prevStep);
        document.getElementById('prev3').addEventListener('click', prevStep);
        document.getElementById('prev4').addEventListener('click', prevStep);


        //show container currently disableeeeeeeeeeeeeeeee
        document.getElementById('proceedButton').addEventListener('click', function() {
            // Find the container and welcome elements
            var container = document.querySelector('.container');
            var welcomeSection = document.querySelector('.welcome');

            // Change the display property of the container to "block"
            container.style.display = 'block';

            // Hide the welcome section by setting its display property to "none"
            welcomeSection.style.display = 'none';
        });

    </script>
</body>
</html>
