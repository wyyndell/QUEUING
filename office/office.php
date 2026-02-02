<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: office_login_form.html");
    exit;
}

// Fetch admin details from session
$full_name = htmlspecialchars($_SESSION['full_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8');
$office = htmlspecialchars($_SESSION['office'] ?? 'Office Admin', ENT_QUOTES, 'UTF-8');
$shareto = htmlspecialchars($_SESSION['shareto'] ?? '', ENT_QUOTES, 'UTF-8');
$image = $_SESSION['image'] ? 'data:image/jpeg;base64,' . htmlspecialchars($_SESSION['image'], ENT_QUOTES, 'UTF-8') : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/cssoffice.css">
    <link rel="stylesheet" href="css/services.css">
    <link rel="shortcut icon" href="img/sitting.png" type="image/x-icon">
    <title>Office</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap');
        * { font-family: 'Quicksand', sans-serif; font-weight: 500; }
        a { text-decoration: none; color: #fff; font-weight: 500; margin-top: 10px;}
    </style>
</head>
<body>
    <!-- Admin Info -->
    <div class="admin-infos">
        <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
        <img src="img/plogo.png" class="imgnav" style="height: 55px; width: 55px; margin-right: 20px;">
        <h1>Hello, <?php echo $full_name; ?></h1>
    </div>

        <div class="setting">
            <button id="custom-services" class="services-btn">Services</button>
            <button class="setting-container" id="settingButton" aria-label="Settings"><img src="<?php echo $image; ?>" alt="Admin Image" style="width: 50px; height: 50px; border-radius: 50px; margin-top: 10px;"></button>
        </div>
    </div>
    
    <div class="notify" id="notificationArea">
        <?php if (!empty($image)): ?>
            <img src="<?php echo $image; ?>" alt="Admin Image" style="width: 50px; height: 50px; border-radius: 50px; margin-top: 10px;">
        <?php else: ?>
            <i class="fa-solid fa-circle-user" style="font-size: 40px;"></i>
        <?php endif; ?>
        <h3><?php echo $full_name; ?></h3>
        <h5><?php echo $office; ?></h5>
        <details id="settingDetails">
            <summary><i class="fa-solid fa-gear"></i> Sound Setting</summary>
            <div class="soundbutton">
                <button id="notifyButton" class="sound">Notify Me</button>
                <button id="soundToggleButton" class="sound">Enable Sound</button>
                <button id="mute" class="sound">Mute</button>
            </div>
        </details>
        <button id="logout" class="logout" aria-label="Logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
    </div>

    <div class="serving-container">
        <div class="content serving">
            <button id="share" class="share"><i class="fa-solid fa-share-nodes"></i></button>
            <h1>Now Serving</h1>
            <div class="details client">
                <h1 class="info" id="clientnumber">-</h1>
                <p class="info" id="id" style="display: none;">-</p>
                <h2 class="info" id="name">-</h2>
                <p style="margin: 5px 0;" id="purpose">-</p>
                <p style="margin: 5px 0;" id="transferred">-</p>
                <p style="margin: 5px 0;" id="email">-</p>
                <p style="display: none; margin: 5px 0;" id="arrive">-</p>
                
            </div>
            <div class="buttons">
                <button class="btn" aria-label="Next" id="next">
                    <i class="fa-solid fa-circle-chevron-right" style="color: var(--primary-clr);"></i>
                    <br><p style="font-size: 17px;">Call Next</p>
                </button>
                
                <button class="btn" aria-label="ReCall" id="recall">
                    <i class="fa-solid fa-phone-volume" style="color: var(--primary-clr);"></i>
                    <br><p style="font-size: 17px;">Recall</p>
                </button>

                <button class="btn" aria-label="Skipped" id="skipped">
                    <i class="fa-solid fa-forward" style="color: var(--primary-clr);"></i>
                    <br><p style="font-size: 17px;">Skipped</p>
                </button>

                <!-- <button id="share" class="btn" aria-label="share"><i class="fa-brands fa-telegram"></i>
                    <br><p style="font-size: 17px;">Transfer</p>
                </button> -->

                <button id="transfer" class="btn" aria-label="transfer"><i class="fa-brands fa-telegram"></i>
                    <br><p style="font-size: 17px;"><?php echo $shareto; ?></p>
                </button>
            </div>
        </div>
        <div class="content waiting">
            <h3 id="total_waiting" class="total_waiting">Waiting clients</h3>
            <div id="client_list"></div>
            <audio id="notificationSound" preload="auto">
                <source src="sound/notification.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            <div class="pending done">
                <div class="details client done">
                    <p class="info" id="donename">Nothing's Done</p>
                    <p class="info" id="donepurpose" style="text-align: right;">-</p>
                    <p class="info" id="donearrive" style="display: none;">-</p>
                    <p class="info" id="doneended" style="display: none;">-</p>
                    <p class="info" id="timetaken">-</p>
                    <p class="info done-earlier" id="done-earlier" style="text-align: right;">Done Earlier</p>
                    <a href="">See All</a>
                </div>
            </div>
        </div>
    </div>
    <div class="stand">
        <!-- <img src="img/standing.png" alt="clip" class="standing"> -->
         <!-- <h6>Help</h6> -->
    </div>

    <!-- Modal for sharing-->
    <div class="modal-container" id="modalContainer">
        <div class="modal-items">
            <button class="close-button" id="closeModal" aria-label="Close">&times;</button>
            <h4>Admin Details</h4>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="admin-name">Admin Name</h4>
                    <button class="forward-button" id="admin-forward" aria-label="Send"><i class="fa-solid fa-paper-plane"></i> Send</button>
                </div>
                <p id="admin-office">Office</p>
            </div>
        </div>
    </div>

    <!-- Modal for services -->
    <div class="custom-modal-container" id="custom-modalContainer">
        <div class="custom-modal-items">
            <button class="custom-modal-close-button" id="custom-modalClose" aria-label="Close">&times;</button>
            <h4><?php echo $office; ?>s' Services</h4>
            <div class="custom-modal-content" id="custom-modalContent">
                <!-- Services will be dynamically inserted here -->
                <div class="custom-add-services" id="custom-addServices">
                    <button id="custom-addButton" class="button"><i class="fa-solid fa-circle-plus" style="color: #fcfcfc;"></i></button>
                    <button id="submitServicesButton" class="button">Submit</button>
                </div>
            </div>
        </div>
    </div>


<!-- Add jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- JavaScript/jQuery code -->
<script>
$(document).ready(function() {
    // Function to handle Transfer button click
    $('#transfer').on('click', function() {
        var transferButton = $(this); // Cache the button element

        // Confirm with user before proceeding
        if (confirm('Are you sure you want to transfer this client?')) {
            // Fetch client ID and office to transfer to
            var client_id = $('#id').text().trim(); // Assuming you have an element with id 'id' displaying client ID
            var new_office = '<?php echo $shareto; ?>'; // Office to transfer to from PHP session

            // AJAX request to office_share.php
            $.ajax({
                type: 'POST',
                url: 'office_share.php',
                data: { client_id: client_id, office: new_office },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Change button text to "Transferred" for 2 seconds
                        transferButton.html('<i class="fa-brands fa-telegram"></i><br><p style="font-size: 17px;">Transferred</p>');
                        
                        // Reset button text after 2 seconds
                        setTimeout(function() {
                            transferButton.html('<i class="fa-brands fa-telegram"></i><br><p style="font-size: 17px;"><?php echo $shareto; ?></p>');
                        }, 2000);

                        // Handle any other UI updates or redirects as needed
                    } else {
                        alert('Error transferring client: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error transferring client: ' + error);
                }
            });
        }
    });
});
</script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/recall.js"></script>
    <script src="js/add_services.js"></script>
</body>
</html>
