<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "queuewee"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize status message
$status_message = "";

// Update status column in admin table for the logged-in user
$user_id = $_SESSION['user_id']; // Assuming 'user_id' is the session variable storing the user ID
$sql_update_status = "UPDATE admin SET status = 'Active' WHERE ID = $user_id";
if ($conn->query($sql_update_status) === TRUE) {
    $status_message = "Status updated successfully";
} else {
    $status_message = "Error updating status: " . $conn->error;
}

// Fetch data from the admin table
$sql = "SELECT DISTINCT office FROM admin WHERE accessibility != 'disable'";    // Using DISTINCT to get unique office names
                                                                                // Using DISTINCT to get unique office names
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Initialize an empty array to store the offices
    $offices = array();

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $offices[] = $row["office"];
    }

    // Encode the array as JSON
    $offices_json = json_encode($offices);
} else {
    // No offices found
    $offices_json = json_encode(array("message" => "No offices found"));
}

// Close database connection
$conn->close();
// Output the status message and JSON-encoded offices array, separated by a newline
//echo $status_message . "<br>"; ito ay e-a-uncomment lang if gagamitin elsewhere in the code
//echo $offices_json;
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Office</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Cascading Style -->
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/office_style.css" />
    <!-- Web Logo -->
    <link rel="icon" type="image/svg+xml" href="/vite.svg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/fetch.js"></script>

</head>

<style>
    .re_insert_cash,
    .re_insert_acc {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }
    .re_insert_cash.show,
    .re_insert_acc.show {
        max-height: 200px; /* Adjust the value as needed */
    }
</style>

<body>
    <div id="myModal" class="modal">
      <div class="modal-content">
        <i class="fa-solid fa-check"></i><p>Submitted</p>
      </div>
    </div>


    <div class="wrapper">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <img src="image\Polytechnic_University_of_the_Philippines_Unisan_Logo.svg.png" alt="CampusQue">
                    <span>CampusQue</span>
                </div>
                <a href="#"><i class="fas fa-home"></i>Dashboard</a>
                <a href="office_history.php"><i class="fas fa-history"></i>History</a>
                <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>

            </div>
        </nav>

        <div class="main-body">
            <div class="header">
                <?php include 'admin_info.php'; ?>
                <h1>Dashboard</h1>
            </div>

            <ul class="upload">
                <li class="serves"  style="padding: 80px; height: 100%;">
                    <span class="text">
                        <h4 id="status">Now Serving</h4>
                        <h1 id="client-number">-</h1>
                        <h2 id="client-name">-</h2>
                        <p id="client-email">-</p>
                        <p id="client-request">-</p>
                        <p id="client-time-arrive">-</p>
                        <div style="display: none;">
                            <p id="client-gender">-</p>
                            <p id="client-number-info">-</p>
                            <p id="client-address">-</p>
                            <p id="client-occupation">-</p>
                            <p id="client-office">-</p>
                        </div>
                    </span>

                    <!-- Command Button-->
                  <div class="buttons-container">
                    <button id="call-next-btn" onclick="callNext()">
                        <i class="fa-solid fa-phone-volume"></i>
                        Call Next
                    </button>

                    <button onclick="recallLastMessage()">
                        <i class="fa-solid fa-rotate"></i>
                        Recall
                    </button>

                    <button onclick="skip()">
                        <i class="fa-solid fa-book"></i>
                        Skip
                    </button>

                    <div>
                        <div>
                            <!-- Select office dropdown -->
                            <form id="officeForm">
                                <label for="offices">Select Office</label>
                                <select name="offices" id="officesSelect">
                                    <option value="">Loading</option>
                                    <!-- Add other office options here -->
                                </select>
                                <button type="submit">Transfer</button>
                            </form>

                        <div>
                    <div>
                </li>
              </ul>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar content -->
            <div class="item-link">
                <a href="#" class="active">Client Pending (<span id="pending-count">0</span>)</a>
            </div>
            <!-- Display pending clients -->
            <div class="comment" id="pending-clients">
                <!-- Content will be dynamically updated here -->
            </div>
        </div>
    </div>


    <script>

        // Function to call the next pending item
        function callNext() {
            // Get the first pending item
            var firstPendingItem = document.querySelector('.comment .box');

            if (firstPendingItem) {
                // Get the details of the pending item
                var clientNumber = firstPendingItem.querySelector('.clientNum').innerText;
                var clientName = firstPendingItem.querySelector('h4').innerText;
                var clientRequest = firstPendingItem.querySelector('p').innerText;
                var clientTimeArrive = firstPendingItem.querySelector('.clientTimeArrive').innerText; // Selecting by class

                // Fetch additional information from the database using AJAX
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var additionalInfo = JSON.parse(this.responseText);
                        var clientGender = additionalInfo.gender;
                        var clientNumberInfo = additionalInfo.number;
                        var clientAddress = additionalInfo.address;
                        var clientOccupation = additionalInfo.occupation;
                        var clientEmail = additionalInfo.email;
                        var clientOffice = additionalInfo.office; // New line to retrieve office information

                        // Update the status of the currently served client to "served" in the database
                        updateClientStatus(clientNumber, clientOffice);

                        // Update the "Now Serving" section with the details of the pending item
                        document.getElementById('status').innerText = "Now Serving";
                        document.getElementById('client-name').innerText = clientName;
                        document.getElementById('client-number').innerText = clientNumber;
                        document.getElementById('client-request').innerText = clientRequest;
                        document.getElementById('client-time-arrive').innerText = clientTimeArrive;
                        document.getElementById('client-gender').innerText = clientGender;
                        document.getElementById('client-number-info').innerText = clientNumberInfo;
                        document.getElementById('client-address').innerText = clientAddress;
                        document.getElementById('client-occupation').innerText = clientOccupation;
                        document.getElementById('client-email').innerText = clientEmail;
                        document.getElementById('client-office').innerText = clientOffice; // New line to display office information

                        // Play notification sound after updating client info
                        var notificationSound = new Audio('sound/before.mp3'); // Replace 'sound/before.mp3' with the path to your sound file
                        notificationSound.onended = function() {
                            // Speak out the name, client number, and office after the notification sound is played
                            var msg = new SpeechSynthesisUtterance();
                            msg.text = "Client Number " + clientNumber + ", to " + clientOffice + " Office, please proceed"; // Updated to include office information
                            msg.rate = 1; // Adjust speech rate to make it slower
                            msg.onend = function() {
                                // Play closing notification sound after speaking the message
                                var closingNotificationSound = new Audio('sound/after.mp3'); // Replace 'sound/after.mp3' with the path to your sound file
                                closingNotificationSound.play();
                            };
                            window.speechSynthesis.speak(msg);

                            // Store the last spoken message
                            lastSpokenMessage = msg.text;

                            // Remove the pending item from the sidebar after speaking
                            firstPendingItem.remove();

                            // Decrement the pending count display
                            decrementPendingCount();
                        };

                        notificationSound.play();
                    }
                };
                xhttp.open("GET", "get_additional_info.php?client_number=" + clientNumber, true); // Replace with your server-side script to fetch additional information
                xhttp.send();
            } else {
                // If there are no pending items
                document.getElementById('status').innerText = "Available for Clients";
                // Clear the client information
                document.getElementById('client-name').innerText = "-";
                document.getElementById('client-number').innerText = "-";
                document.getElementById('client-request').innerText = "-";
                document.getElementById('client-time-arrive').innerText = "-";
                document.getElementById('client-gender').innerText = "-";
                document.getElementById('client-number-info').innerText = "-";
                document.getElementById('client-address').innerText = "-";
                document.getElementById('client-occupation').innerText = "-";
                document.getElementById('client-office').innerText = "-"; // New line to clear office information
                
                // Prompt user with a confirmation dialog
                var confirmation = confirm('No pending items. Do you want to serve the next client from the previous office?');

                // Inside the callNext function
                if (confirmation) {
                    // Get the previous office from the dashboard
                    var previousOffice = document.getElementById('client-office').innerText;
                    console.log(previousOffice); // Debugging

                    // Send AJAX request to insert the office into the serving database
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            if (this.status == 200) {
                                console.log('Office inserted into serving database.');
                            } else {
                                console.error('Error inserting office into serving database. Status: ' + this.status);
                            }
                        }
                    };
                    xhttp.open("POST", "clear_serving.php", true); // Replace "insert_serving.php" with your server-side script
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("office=" + previousOffice);
                }


                    }
                }

        // Function to update the status of the client to "served" in the database
        function updateClientStatus(clientNumber, clientOffice) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            };
            xhttp.open("POST", "office_dashboard_update.php", true); // Replace with the path to your server-side script to update client status
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("client_number=" + clientNumber + "&office=" + clientOffice); // Send client number and office information to the server
        }


        // Function to decrement the pending count display
        function decrementPendingCount() {
            var countDisplay = document.querySelector('.addclient');
            var currentCount = parseInt(countDisplay.innerText);

            if (!isNaN(currentCount) && currentCount > 0) {
                countDisplay.innerText = currentCount - 1;
            }
        }


        
        // Function to recall the last spoken message
        function recallLastMessage() {
            // Get the details of the current client being served
            var clientNumber = document.getElementById('client-number').innerText;
            var clientName = document.getElementById('client-name').innerText;
            var clientOffice = document.getElementById('client-office').innerText; // Retrieve the office information

            // Check if there's a client being served currently
            if (clientNumber !== "-" && clientName !== "-" && clientOffice !== "-") {
                // Play notification sound before recalling the message
                var notificationSound = new Audio('sound/before.mp3'); // Replace 'sound/before.mp3' with the path to your sound file
                notificationSound.onended = function() {
                    // Speak out the message with "Once again" and the client details
                    var recallMsg = new SpeechSynthesisUtterance();
                    recallMsg.text = "Once again, Client Number " + clientNumber + ", to " + clientOffice + " office please proceed"; // Include office information
                    recallMsg.rate = 1; // Adjust speech rate to make it slower

                    // Get all available voices
                    var voices = window.speechSynthesis.getVoices();

                    // Find a female voice if available
                    var femaleVoice = voices.find(voice => voice.name.toLowerCase().includes('female'));

                    // Set the voice to the female voice if available, otherwise, use the default voice
                    recallMsg.voice = femaleVoice || voices[0]; // If no female voice is found, use the default voice

                    // Use the selected voice for speech synthesis to recall the message
                    window.speechSynthesis.speak(recallMsg);

                    // Play closing notification sound after the recall message is done speaking
                    recallMsg.onend = function() {
                        var closingNotificationSound = new Audio('sound/after.mp3'); // Replace 'sound/after.mp3' with the path to your sound file
                        closingNotificationSound.play();

                        // Update the server to indicate that the message was recalled
                        updateRecallStatus(clientNumber, clientOffice);
                    };
                };

                notificationSound.play();
            } else {
                alert('No client currently being served.');
            }
        }

        // Function to update the recall status of the client in the database
        function updateRecallStatus(clientNumber, clientOffice) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText); // Log the response from the server
                }
            };
            xhttp.open("POST", "recall_update.php", true); // Replace with the path to your server-side script to update recall status
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("client_number=" + clientNumber + "&office=" + clientOffice); // Send client number and office information to the server
        }


        function skip() {
            // Get the client number from the dashboard
            var clientNumber = document.getElementById('client-number').innerText;

            // Confirm if the user wants to skip the current client
            var confirmation = confirm("Are you sure you want to skip this client?");

            if (confirmation) {
                // Send AJAX request to update the client status to 'skipped'
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Response from the server after updating the status
                        console.log(this.responseText);

                        // Display a message or perform any other action after skipping the client
                        console.log("Client skipped successfully.");
                    }
                };
                xhttp.open("POST", "skipped_dashboard.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("client_number=" + clientNumber);
            } else {
                // Action if the user cancels skipping the client
                console.log("Skipping cancelled.");
            }
        }


        // Function to fetch pending clients from the server and update the UI
        function fetchPendingClients() {
            // Send AJAX request to fetch pending clients
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Parse JSON response
                    var pendingClients = JSON.parse(this.responseText);

                    // Update the UI with pending clients
                    renderPendingClients(pendingClients);
                }
            };
            xhttp.open("GET", "fetch_pending_clients.php", true);
            xhttp.send();
        }

        // Function to handle form submission
        document.getElementById('officeForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission behavior

            // Retrieve data/values of the "Now Serving" client
            var clientName = document.getElementById('client-name').innerText;
            var clientNumber = document.getElementById('client-number').innerText; // Represents the client number displayed
            var clientGender = document.getElementById('client-gender').innerText;
            var clientNumberInfo = document.getElementById('client-number-info').innerText; // Represents additional client number info
            var clientAddress = document.getElementById('client-address').innerText;
            var clientRequest = document.getElementById('client-request').innerText;
            var clientOccupation = document.getElementById('client-occupation').innerText;
            var clientTimeArrive = document.getElementById('client-time-arrive').innerText;
            var clientOffice = document.getElementById('officesSelect').value; // Retrieve selected office value

            // Display confirmation dialog
            var confirmation = confirm("Are you sure you want to transfer this client?");

            // Check user's choice
            if (confirmation) {
                // If user confirms, proceed with transfer
                // Send AJAX request to insert data into the database
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Handle response if needed
                        console.log('Data inserted successfully.');
                        // Optionally, you can display a success message or perform other actions
                    }
                };
                xhttp.open("POST", "insert_data.php", true); // Replace "insert_data.php" with your server-side script
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("name=" + clientName + "&gender=" + clientGender + "&number=" + clientNumber + "&client_number=" + clientNumberInfo + "&address=" + clientAddress + "&request=" + clientRequest + "&occupation=" + clientOccupation + "&time_arrive=" + clientTimeArrive + "&office=" + clientOffice); // Send data to the server
            } else {
                // If user cancels, do nothing
                alert("Transfer cancelled.");
            }
        });

    </script>





</body>
</html>
