$(document).ready(function() {
    var lastPendingCount = 0; // Variable to store the last count of pending clients

    // Function to fetch pending clients data
    function fetchPendingClients() {
        $.ajax({
            url: 'get_pending_clients.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                updateSidebar(data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching pending clients:', error);
            }
        });
    }

    // Function to update the sidebar with new data
    function updateSidebar(data) {
        var currentPendingCount = data.length;

        // Check if there are new pending clients
        if (currentPendingCount > lastPendingCount) {
            // Play notification sound
            var audio = new Audio('sound/notification.mp3');
            audio.play();
        }

        lastPendingCount = currentPendingCount;

        // Clear existing content
        $('#pending-clients').empty();

        if (data.length > 0) {
            // Update client count
            $('#pending-count').text(data.length);

            // Update pending clients list
            $.each(data, function(index, client) {
                var clientHTML = '<div class="box">';
                clientHTML += '<span class="clientNum">' + client.client_number + '</span>';
                clientHTML += '<div class="body-text">';
                clientHTML += '<h4>' + client.name + '</h4>';
                clientHTML += '<p>' + client.request + '</p>';
                clientHTML += '<span class="clientTimeArrive">' + client.time_arrive + '</span>';
                clientHTML += '</div>';
                clientHTML += '</div>';

                $('#pending-clients').append(clientHTML);
            });
        } else {
            // No pending clients
            $('#pending-count').text('0');
            $('#pending-clients').append('<p>No clients found</p>');
        }
    }

    // Fetch pending clients data initially and every 1 second
    fetchPendingClients();
    setInterval(fetchPendingClients, 1000); // Adjust interval as needed
});


// getting offices
document.addEventListener('DOMContentLoaded', function() {
    var officesSelect = document.getElementById('officesSelect');

    // Fetch office data from get_offices.php using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var offices = JSON.parse(this.responseText);

            // Clear existing options
            officesSelect.innerHTML = '';

            // Populate the select element with fetched office data
            offices.forEach(function(office) {
                var option = document.createElement('option');
                option.textContent = office;
                officesSelect.appendChild(option);
            });
        }
    };
    xhttp.open("GET", "get_offices.php", true);
    xhttp.send();
});