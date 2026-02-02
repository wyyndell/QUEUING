// Function to update time, date, and AM/PM
function updateTime() {
    const now = new Date();

    // Get hours and adjust for AM/PM format
    let hours = now.getHours();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12; // Convert hours to 12-hour format
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();

    // Update time display
    document.getElementById('time').textContent = `0${hours} : ${padNumber(minutes)}`;
    // document.getElementById('time').textContent = `${hours}:${padNumber(minutes)}:${padNumber(seconds)}`;

    // Update AM/PM display
    document.getElementById('pm-am').textContent = ampm;

    // Update date display
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'Asia/Manila' // Set the timezone to Asia/Manila
    };
    document.getElementById('date').textContent = now.toLocaleDateString('en-US', options);
}

// Helper function to pad numbers with leading zeros
function padNumber(number) {
    return number < 10 ? `0${number}` : number;
}

// Update time initially and then every second
updateTime(); // Update immediately when script runs
setInterval(updateTime, 1000); // Update time every second

$(document).ready(function() {
    var previousData = {};
    var timeoutId = null;
    var notificationSound = document.getElementById('notificationSound');
    var afterSound = new Audio('sound/after.mp3'); // Adjust path to after.mp3

    // Retrieve processed clients from localStorage
    var processedClients = new Set(JSON.parse(localStorage.getItem('processedClients')) || []);

    // Function to update modal content
    function updateModalContent() {
        $.getJSON('office_fetch_monitor.php', function(data) {
            if ($.isEmptyObject(data)) {
                $('#modalContainer').empty().text('No data available');
            } else {
                var newDataToShow = [];

                // Check for new data
                $.each(data, function(index, client) {
                    var office = client.office;
                    var clientKey = `${client.clientnumber}-${client.fname}-${client.mname}-${client.lname}-${client.filter}-${client.office}`;

                    if (!previousData[office]) {
                        previousData[office] = [];
                    }

                    // Check if the client is already in the last two fetched data and if the client details have been processed
                    if (!previousData[office].some(item => item.clientKey === clientKey) && !processedClients.has(clientKey)) {
                        newDataToShow.push(client);
                    }
                });

                if (newDataToShow.length > 0) {
                    // Play notification sound
                    notificationSound.play();

                    // Speak notification
                    speakNotification(newDataToShow);

                    // Remove existing items for the same office
                    newDataToShow.forEach(function(client) {
                        var office = client.office;
                        $(`#modalContainer .modal-items[data-office="${office}"]`).remove();
                    });

                    // Append new data
                    newDataToShow.forEach(function(client) {
                        var modalItem = `
                            <div class="modal-items" data-office="${client.office}" data-clientnumber="${client.clientnumber}">
                                <h2 style="margin-bottom: 20px; margin-top: 20px; font-size: 30px; font-weight:900;">Now serving</h2>
                                <div class="cnumber">
                                    <h1 style="font-weight:900;">${client.clientnumber}</h1>
                                </div>
                                <div class="office">
                                    <h2 style="text-transform: uppercase; font-weight:900; font-size: 39px;">${client.office}'s</h2>
                                    <p style="font-size: 20px;">Office</p>
                                    <p style="display: none;">${client.fname} ${client.mname} ${client.lname}</p>
                                    <p style="display: none;">${client.filter}</p>
                                </div>
                            </div>
                        `;

                        $('#modalContainer').append(modalItem);

                        // Update previousData for the office
                        var clientKey = `${client.clientnumber}-${client.fname}-${client.mname}-${client.lname}-${client.filter}-${client.office}`;
                        previousData[client.office] = [{ clientKey, client }];
                        processedClients.add(clientKey); // Mark client details as processed
                    });

                    // Store processed clients in localStorage
                    localStorage.setItem('processedClients', JSON.stringify(Array.from(processedClients)));

                    // Set modalContainer to display flex
                    $('#modalContainer').css('display', 'flex');

                    // Clear previous timeout if exists
                    if (timeoutId !== null) {
                        clearTimeout(timeoutId);
                    }

                    // Set timeout to clear modal content after 20 seconds
                    timeoutId = setTimeout(function() {
                        $('#modalContainer .modal-items').fadeOut(500, function() {
                            $(this).remove();
                            // After fading out, reset display to none if no items remain
                            if ($('#modalContainer .modal-items').length === 0) {
                                $('#modalContainer').css('display', 'none');
                            }
                        });
                    }, 20000); // 20 seconds in milliseconds
                }
            }
        }).fail(function() {
            $('#modalContainer').empty().text('Error fetching data');
        });
    }

    // Function to speak notification
    function speakNotification(newDataToShow) {
        newDataToShow.forEach(function(client, index) {
            var office = client.office;
            var clientNumber = client.clientnumber;
            var msg = new SpeechSynthesisUtterance(`To ${office}'s office, client number ${clientNumber}`);
            
            // Event listener for end of speech
            msg.onend = function(event) {
                // Play after sound after speech ends
                if (index === newDataToShow.length - 1) {
                    afterSound.play();
                }
            };

            window.speechSynthesis.speak(msg);
        });
    }

    // Initial call to update content
    updateModalContent();

    // Refresh content every 1 second (adjust as necessary)
    setInterval(updateModalContent, 1000);
});
