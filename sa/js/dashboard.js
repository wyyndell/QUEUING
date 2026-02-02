// Function to handle form submission
    document.getElementById('officeForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission behavior

        // Retrieve data/values of the "Now Serving" client
        var clientName = document.getElementById('client-name').innerText;
        var clientGender = document.getElementById('client-gender').innerText;
        var clientNumber = document.getElementById('client-number-info').innerText;
        var clientAddress = document.getElementById('client-address').innerText;
        var clientRequest = document.getElementById('client-request').innerText;
        var clientOccupation = document.getElementById('client-occupation').innerText;
        var clientTimeArrive = document.getElementById('client-time-arrive').innerText;
        var clientOffice = document.getElementById('officesSelect').value; // Retrieve selected office value

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
        xhttp.send("name=" + clientName + "&gender=" + clientGender + "&number=" + clientNumber + "&address=" + clientAddress + "&request=" + clientRequest + "&occupation=" + clientOccupation + "&time_arrive=" + clientTimeArrive + "&office=" + clientOffice); // Send data to the server
    });
