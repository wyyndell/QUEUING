<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/monitor_style.css">
    <!-- Include Bootstrap CSS -->
    <!-- Bootstrap CSS for Carousel -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Monitor</title>
</head>
<body>

<div class="header containers">
    <img src="img/plogo.png" class="imgnav">
    <h1 class="text">Polytechnic University of the Philippines <br> Unisan Campus</h1>
</div>

<div class="monitor-container  containers">
    <div class="announcement">
        <div class="announcements">
            <!-- Bootstrap Carousel -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    // Directory containing images and videos
                    $dir = 'slider';

                    // Get all files in the directory
                    $files = scandir($dir);

                    // Remove . and .. from the array
                    $files = array_diff($files, array('.', '..'));

                    // Counter for setting active class
                    $counter = 0;

                    // Loop through each file and display as a carousel item
                    foreach ($files as $file) {
                        // Check if the file is an image or video
                        $fileType = pathinfo($file, PATHINFO_EXTENSION);
                        $validImageTypes = array('jpg', 'jpeg', 'png', 'gif');
                        $validVideoTypes = array('mp4', 'avi', 'mov', 'wmv', 'mkv');

                        echo '<div class="carousel-item ';
                        echo ($counter == 0) ? 'active' : '';
                        echo '">';

                        if (in_array($fileType, $validImageTypes)) {
                            // If it's an image
                            echo '<img src="' . $dir . '/' . $file . '" class="d-block w-100" alt="Slider Image">';
                        } elseif (in_array($fileType, $validVideoTypes)) {
                            // If it's a video
                            echo '<video class="d-block w-100" autoplay muted>';
                            echo '<source src="' . $dir . '/' . $file . '" type="video/' . $fileType . '">';
                            echo 'Your browser does not support the video tag.';
                            echo '</video>';
                        }

                        echo '</div>';
                        $counter++;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="datetime">
            <br>
            <h1>Schedule</h1>
            <p>Monday - Dental Operation</p>
            <p>08:00 AM to 05:00 PM</p>
            <br>
            <p>Monday - Dental Operation</p>
            <p>08:00 AM to 05:00 PM</p>
            <br>
            <div class="card" style="outline: none; border: none; border-radius: 15px; height: 200px; width: 300px;">
                <div class="container" style="background: none;">
                    <div class="cloud front" style="background: none; margin-left: 55%;">
                        <span class="left-front"></span>
                        <span class="right-front"></span>
                    </div>
                    <span class="sun sunshine" style="margin-left: 40%;"></span>
                    <span class="sun" style="margin-left: 40%;"></span>
                    <div class="cloud back" style="margin-left: 75%;">
                        <span class="left-back"></span>
                        <span class="right-back"></span>
                    </div>
                </div>

                <div class="card-header" style="background: none; outline: none; border: none;yyy">
                    <span>Philippines<br>Quezon Province</span>
                    <span id="date">Date</span>
                </div>

                <span class="temp" id="time">Time</span>

                <div class="temp-scale">
                    <span id="pm-am">PM</span>
                </div>
            </div>
        </div>
    </div>
    <div class="reminder">
        <!-- <div class="note-image">
            <img src="image/3d-casual-life-young-man-holding-laptop-and-pointing-up.png" alt="">
        </div> -->
        <div class="note">
            <span class="note-title">Reminder</span>
            <span class="note-description"><b>Your Client Number will appear if it's your turn<b></span>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal-container" id="modalContainer">
    <div class="modal-items" style="display: none;">
        <div class="cnumber">
            <h1 id="clientnumber">12</h1>
        </div>
        <div class="office">
            <h2 id="office">Office</h2>
            <p id="name">Full Name</p>
            <p id="filter">Filter</p>
        </div>
    </div>
    <img src="img/confetti.gif" alt="confetti" class="confetti">
</div>

<!-- Positioning images at the bottom left and right -->
<div class="stand">
    <img src="img/wait.png" alt="chair" class="right" >
</div>

<!-- Add audio element for notification sound -->
<audio id="notificationSound" src="sound/sparkle.mp3" preload="auto"></audio>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/monitor.js"></script>

<script>
    // Function to handle the sliding behavior based on the type of content
    function handleSlide() {
        var currentItem = $('.carousel-item.active');
        var videoElement = currentItem.find('video').get(0);

        // Check if the current item is a video
        if (videoElement) {
            // If it's a video, play it and wait for it to finish before sliding to the next
            videoElement.play();
            setTimeout(function() {
                $('#carouselExampleIndicators').carousel('next');
            }, videoElement.duration * 1000); // Wait for the video duration before sliding to the next
        } else {
            // If it's an image, set a timeout to advance to the next slide after 6 seconds
            setTimeout(function() {
                $('#carouselExampleIndicators').carousel('next');
            }, 6000); // 6 seconds interval
        }
    }

    // Listen for slide event to handle each slide
    $('#carouselExampleIndicators').on('slide.bs.carousel', function() {
        handleSlide();
    });

    // Initialize the carousel and handle the first slide
    $(document).ready(function() {
        $('#carouselExampleIndicators').carousel({
            interval: 6000, // Set interval to 6 seconds (6000 milliseconds)
            pause: 'hover' // Optional: Pause on hover
        });
        handleSlide(); // Handle the first slide
    });
</script>

</body>
</html>
