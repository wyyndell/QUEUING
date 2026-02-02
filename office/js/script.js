let previousTotalWaiting = 0;
let notificationEnabled = false; // Track notification state
let soundEnabled = false; // Track sound state
let muteEnabled = true; // Track mute state
let previousNotificationEnabled = false; // Save previous notification state
let previousSoundEnabled = false; // Save previous sound state
let pendingClients = []; // Array to hold pending clients
let currentClientIndex = 0; // Index of the current client being served

document.addEventListener('DOMContentLoaded', function() {
    // Fetch initial client data
    fetchClientData();

    // Fetch data every 0.1 second
    setInterval(fetchClientData, 100);

    // Toggle notification on/off on button click
    const notifyButton = document.getElementById('notifyButton');
    updateNotifyButton();
    notifyButton.addEventListener('click', function() {
        if (!muteEnabled) {
            notificationEnabled = !notificationEnabled; // Toggle state
            updateNotifyButton();

            // Optional: If enabling notifications, show the initial permission request
            if (notificationEnabled) {
                showDesktopNotification(true); // Pass true to force permission request if not granted
            }
        }
    });

    function updateNotifyButton() {
        notifyButton.innerHTML = notificationEnabled
            ? '<i class="fa-solid fa-bell" style="color: #FFD43B;"></i>'
            : '<i class="fa-solid fa-bell-slash"></i>';
    }

    // Toggle sound on/off on button click
    const soundToggleButton = document.getElementById('soundToggleButton');
    updateSoundButton();
    soundToggleButton.addEventListener('click', function() {
        if (!muteEnabled) {
            soundEnabled = !soundEnabled;
            updateSoundButton();
        }
    });

    function updateSoundButton() {
        soundToggleButton.innerHTML = soundEnabled
            ? '<i class="fa-solid fa-phone-volume" style="color: #FFD43B;"></i>'
            : '<i class="fa-solid fa-phone-slash"></i>';
    }

    // Toggle mute on/off on button click
    const muteButton = document.getElementById('mute');
    updateMuteButton();
    muteButton.addEventListener('click', function() {
        muteEnabled = !muteEnabled; // Toggle mute state
        updateMuteButton();
        if (muteEnabled) {
            // Save previous states
            previousNotificationEnabled = notificationEnabled;
            previousSoundEnabled = soundEnabled;
            notificationEnabled = false;
            soundEnabled = false;
        } else {
            // Restore previous states
            notificationEnabled = previousNotificationEnabled;
            soundEnabled = previousSoundEnabled;
        }
        updateNotifyButton();
        updateSoundButton();
    });

    function updateMuteButton() {
        muteButton.innerHTML = muteEnabled
            ? '<i class="fa-solid fa-volume-mute" style="color: #FFD43B;"></i>'
            : '<i class="fa-solid fa-volume-up"></i>';
    }

    // Handle the "Next" button click
    const nextButton = document.getElementById('next');
    nextButton.addEventListener('click', showNextClient);

    // Handle the "Recall" button click
    const recallButton = document.getElementById('recall');
    recallButton.addEventListener('click', recallCurrentClient);

    // Handle the "Skipped" button click
    const skippedButton = document.getElementById('skipped');
    skippedButton.addEventListener('click', function() {
        if (confirm('Are you sure you want to mark this client as skipped?')) {
            const clientId = document.getElementById('id').innerText.trim(); // Assuming you have an element with id="id" for client ID

            const now = new Date();
            const arriveTimestamp = now.toISOString(); // Convert to ISO 8601 format

            // Update status to 'waiting' and send arrive timestamp
            updateClientStatus(clientId, 'waiting', arriveTimestamp);
        }
    });

    const settingButton = document.getElementById('settingButton');
    const notificationArea = document.getElementById('notificationArea');

    // Toggle visibility of notification area when setting button is clicked
    settingButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevents the click event from bubbling up
        notificationArea.classList.toggle('visible');
    });

    // Close the notification area if user clicks outside of it
    document.addEventListener('click', function(event) {
        const targetElement = event.target;
        if (!notificationArea.contains(targetElement) && !settingButton.contains(targetElement)) {
            notificationArea.classList.remove('visible');
        }
    });

    // Fetch done client data and update the UI
    fetchDoneClient(); // Fetch initial done client data

    // Fetch data every 0.1 second
    setInterval(fetchDoneClient, 100);

    document.getElementById('logout').addEventListener('click', function() {
        window.location.href = 'office_logout.php';
    });
});


function fetchClientData() {
    fetch('office_fetch_clients.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            const newTotalWaiting = data.total_waiting;

            // Check if the count of waiting clients has increased
            if (newTotalWaiting > previousTotalWaiting && notificationEnabled) {
                // Play notification sound for new client arrival
                playNotificationSound();
            }

            previousTotalWaiting = newTotalWaiting;

            // Update waiting clients count
            document.getElementById('total_waiting').innerText = `Waiting ${newTotalWaiting} clients`;

            // Update the list of pending clients
            pendingClients = data.clients;
            currentClientIndex = 0; // Reset current client index

            // Update client list
            const clientList = document.getElementById('client_list');
            clientList.innerHTML = '';

            if (data.clients.length === 0) {
                // Display message if no clients are currently waiting
                const noClientsMessage = document.createElement('div');
                noClientsMessage.classList.add('no-clients-message');
                noClientsMessage.innerHTML = `
                    <div class="empty">
                        <div>
                            <p>Clients are on their way</p>
                            <img src="img/empty.gif" alt="clip" class="empty" style="height: auto; width: 250px; border-radius: 5px; margin-top: 20px;">
                        </div>
                    </div>
                `;
                clientList.appendChild(noClientsMessage);
            } else {
                data.clients.forEach(client => {
                    const clientDiv = document.createElement('div');
                    clientDiv.classList.add('pending');

                    const timeLabel = client.time_difference === 'Just Now' ? 'Just Now' : `${client.time_difference} waiting`;

                    clientDiv.innerHTML = `
                        <div class="details pending">
                            <div class="item clientnumber">
                                <h1 class="info" id="clientnumber">${client.clientnumber}</h1>
                            </div>
                            <div class="item details">
                                <p class="info" id="id" style="display: none;">${client.id}</p>
                                <h2 class="info" id="name">${client.name}</h2>
                                <p class="info" id="purpose" style="display: none;">${client.purpose}</p>
                                <p class="info" id="email" style="display: none;">${client.email}</p>
                                <p class="info" id="arrive" style="display: none;"><i class="fa-regular fa-clock"></i> ${client.arrive}</p>
                                ${client.transferred ? `
                                <h5 class="info t" id="transferred">
                                    From ${client.transferred}'s Office
                                    <span class="right-aligned">
                                        <i class="fa-regular fa-clock"></i> ${timeLabel}
                                    </span>
                                </h5>
                                ` : `
                                <h5 class="info t" id="transferred">
                                    <span class="left-aligned">
                                        <i class="fa-regular fa-clock"></i> ${timeLabel}
                                    </span>
                                </h5>
                                `}
                                <h5 class="info" id="time_difference" style="display: none;"><i class="fa-regular fa-clock"></i> ${timeLabel}</h5>
                            </div>
                        </div>
                    `;
                    clientList.appendChild(clientDiv);
                });
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}


// Function to show the next client
// Function to show the next client with confirmation
function showNextClient() {
    // Display a confirmation dialog
    if (confirm('Are you sure to call the next client? Don\'t forget to share or transfer it to the next office if needed')) {
        if (currentClientIndex < pendingClients.length) {
            const client = pendingClients[currentClientIndex];

            // Update "Now Serving" section with the current client's details
            document.getElementById('clientnumber').innerText = client.clientnumber;
            document.getElementById('id').innerText = client.id;
            document.getElementById('name').innerText = client.name;
            document.getElementById('purpose').innerText = client.purpose;
            document.getElementById('email').innerText = client.email;
            document.getElementById('arrive').innerText = client.arrive;

            // Check if client.transferred has data before updating
            if (client.transferred) {
                document.getElementById('transferred').innerText = `Transferred by ${client.transferred}'s Office`;
            } else {
                // Hide or clear the transferred element if client.transferred is empty
                document.getElementById('transferred').innerText = ''; // Or hide the element
            }

            // Play the custom announcement if sound is enabled
            if (soundEnabled) {
                playCustomAnnouncement(client.clientnumber);
            }

            // Update status to "done" in the database
            updateClientStatus(client.id, 'done'); // Update status to 'done'

            currentClientIndex++; // Move to the next client
        } else {
            alert('No more clients in the queue.');
        }
    }
}



// Function to update client status
function updateClientStatus(clientId, status, arriveTimestamp) {
    const formData = new FormData();
    formData.append('client_id', clientId);
    formData.append('status', status); // Update status to 'done' or 'waiting'
    formData.append('arrive', arriveTimestamp); // Include arrive timestamp

    fetch('office_update_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(`Client status updated to "${status}" successfully:`, data);
    })
    .catch(error => {
        console.error('Error updating client status:', error);
    });
}

function recallCurrentClient() {
    const clientNumber = document.getElementById('clientnumber').innerText;
    if (clientNumber !== '-') {
        // Play the custom recall announcement if sound is enabled
        if (soundEnabled) {
            playCustomRecall(clientNumber);
        }
    } else {
        alert('No client is currently being served.');
    }
}

function playCustomAnnouncement(clientNumber) {
    const beforeSound = new Audio('sound/before.mp3');
    const afterSound = new Audio('sound/after.mp3');

    beforeSound.play();

    beforeSound.addEventListener('ended', function() {
        const message = new SpeechSynthesisUtterance(`Client Number ${clientNumber}, please come in.`);
        speechSynthesis.speak(message);

        message.onend = function() {
            afterSound.play();
        };
    });
}

function playCustomRecall(clientNumber) {
    const beforeSound = new Audio('sound/before.mp3');
    const afterSound = new Audio('sound/after.mp3');

    beforeSound.play();

    beforeSound.addEventListener('ended', function() {
        const message = new SpeechSynthesisUtterance(`Once again, client Number ${clientNumber}, please come in.`);
        speechSynthesis.speak(message);

        message.onend = function() {
            afterSound.play();
        };
    });
}

function playNotificationSound() {
    var notificationSound = document.getElementById('notificationSound');
    if (notificationSound) {
        notificationSound.currentTime = 0; // Rewind to start
        notificationSound.play();
    }
}

function showDesktopNotification(forceRequest = false) {
    if (Notification.permission === 'granted') {
        if (forceRequest || !notificationEnabled) {
            new Notification('Notifications Enabled', {
                body: 'You will now receive notifications for new clients.',
                icon: 'img/sitting.png' // Replace with your icon path
            });
        }
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                showDesktopNotification(true);
            }
        });
    }
}

function fetchDoneClient() {
    fetch('office_done_earlier.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            const client = data.client;
            if (client) {
                // Update the HTML with the fetched client's details
                document.getElementById('donename').innerText = client.name;
                document.getElementById('donepurpose').innerText = client.purpose;
                document.getElementById('donearrive').innerText = client.arrive;
                document.getElementById('doneended').innerText = client.ended;

                // Calculate and display the time taken
                const arriveTime = new Date(client.arrive);
                const endTime = new Date(client.ended);
                const timeTaken = calculateTimeDifference(arriveTime, endTime);

                // Update #timetaken with FontAwesome icon and time taken text
                document.getElementById('timetaken').innerHTML = `<i class="fa-regular fa-clock"></i> ${timeTaken} taken`;
            } else {
                // If no client found, clear the fields or show a message
                document.getElementById('donename').innerText = '-';
                document.getElementById('donepurpose').innerText = '-';
                document.getElementById('donearrive').innerText = '-';
                document.getElementById('doneended').innerText = '-';

                // Reset #timetaken if no client is found
                document.getElementById('timetaken').innerHTML = `<i class="fa-regular fa-clock"></i>`;
            }
        })
        .catch(error => console.error('Error fetching done client:', error));
}

// Function to calculate time difference and format it
function calculateTimeDifference(start, end) {
    const difference = Math.abs(end - start);
    const seconds = Math.floor(difference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);

    // Format the time taken
    if (hours > 0) {
        return `${hours} hr${hours > 1 ? 's' : ''}, ${minutes % 60} min${minutes % 60 !== 1 ? 's' : ''}`;
    } else if (minutes > 0) {
        return `${minutes} min${minutes !== 1 ? 's' : ''}`;
    } else {
        return `${seconds} second${seconds !== 1 ? 's' : ''}`;
    }
}

// Modal
$(document).ready(function() {
    function fetchAdminDetails() {
        $.ajax({
            url: 'office_fetch_modal.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    if (response.length > 0) {
                        displayAdmins(response);
                        $('#modalContainer').css('display', 'flex');
                    } else {
                        alert('No admins found for this office.');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + ' - ' + error);
                alert('Error fetching data.');
            }
        });
    }

    function displayAdmins(admins) {
        var modalContent = $('.modal-content');
        modalContent.empty();

        admins.forEach(function(admin) {
            var adminDetails = `
                <div class="admin-item">
                    <div class="modal-header">
                        <div class="admin-info">
                            <img src="${admin.image}" alt="Admin Image" class="admin-image">
                            <div class="admin-details">
                                <h4>${admin.fname} ${admin.lname}</h4>
                                <p>${admin.office}</p>
                            </div>
                        </div>
                        <button class="forward-button" Style="color: #973131;" data-admin='${JSON.stringify(admin)}'><i class="fa-solid fa-paper-plane"  Style="color: #973131;"></i> Send</button>
                    </div>
                    <?php echo $office; ?>
                </div>
            `;
            modalContent.append(adminDetails);
        });
    }

    $('#share').click(function() {
        fetchAdminDetails();
    });

    $('#closeModal').click(function() {
        $('#modalContainer').css('display', 'none');
    });

    $(window).click(function(event) {
        if (event.target === document.getElementById('modalContainer')) {
            $('#modalContainer').css('display', 'none');
        }
    });

    $(document).on('click', '.forward-button', function() {
        var adminData = $(this).data('admin');
        var clientId = $('#id').text().trim();
        var newOffice = adminData.office;

        reinsertClientWithNewOffice(clientId, newOffice, $(this));
    });

    function reinsertClientWithNewOffice(clientId, newOffice, buttonElement) {
        const formData = new FormData();
        formData.append('client_id', clientId);
        formData.append('office', newOffice);

        fetch('office_reinsert_client.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Client re-inserted with new office successfully:', data);
            buttonElement.html('<i class="fa-solid fa-paper-plane" style="color: grey;"> Sent</i> ');

            setTimeout(function() {
                buttonElement.html('<i class="fa-solid fa-paper-plane"></i> Send');
            }, 5000);
        })
        .catch(error => {
            console.error('Error re-inserting client with new office:', error);
            alert('Error re-inserting client with new office. Please try again.');
            buttonElement.html('<i class="fa-solid fa-paper-plane"></i> Send');
        });
    }
});
// Setting animation
document.addEventListener('DOMContentLoaded', function() {
    var summary = document.querySelector('summary');
    var icon = summary.querySelector('i.fa-solid');

    summary.addEventListener('click', function() {
        icon.classList.toggle('rotate-360');
    });
});


