<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Monitor</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/announcement.css">
</head>
<style>
    body {
        background-color: #fff;
    }
</style>
<body>
    <div class="text">
        <div class="announcement">
            <!-- Bootstrap Carousel -->
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
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
                            echo '<video class="d-block w-100" autoplay muted onended="nextSlide()">';
                            echo '<source src="' . $dir . '/' . $file . '" type="video/' . $fileType . '">';
                            echo 'Your browser does not support the video tag.';
                            echo '</video>';
                        }
                        
                        echo '</div>';
                        $counter++;
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="now_serving">
            <div id="clients" class="clients"></div>
        </div>
    </div>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize an object to keep track of announced clients and their latest creation times
            var announcedClients = {};
            // Initialize a queue for speech synthesis
            var speechQueue = [];

            setInterval(function() {
                $.ajax({
                    url: 'fetch_monitor.php',
                    type: 'GET',
                    success: function(response) {
                        var data = JSON.parse(response);
                        var clientsHtml = '';

                        // Get the current time
                        var currentTime = new Date();

                        for (var i = 0; i < data.length; i++) {
                            var clientKey = data[i].office + data[i].client_number; // Unique key for each client

                            clientsHtml += '<div class="office" style="display: flex; align-items: center;">' +
                                                '<div style="font-size: 20px; background-color: #3498db; color: white; padding: 10px 20px; border-top-left-radius: 10px; border-bottom-left-radius: 10px; min-width: 50px">'+ data[i].client_number +'</div>' +
                                                '<h2 style="font-size: 20px; margin-right: 10px;">'+ data[i].office + "'s Office</h2>" +
                                            '</div>';

                            // Check if client number exists and is not empty or null
                            if (data[i].client_number && data[i].client_number.trim() !== '') {
                                // clientsHtml += '<h1 style="font-size: 40px;">' + data[i].client_number+'</h1>';
                                // clientsHtml += '<p>' + data[i].name + '</p>';
                                clientsHtml += '<p style="display: none;">' + data[i].created_at + '</p>';

                                // Convert created_at to a Date object
                                var createdAt = new Date(data[i].created_at);
                                // Calculate the creation time in seconds
                                var createdTimeSeconds = createdAt.getTime() / 1000;
                                // Check if the client was announced before and if it has a different creation time
                                if (announcedClients.hasOwnProperty(clientKey) && announcedClients[clientKey] !== createdTimeSeconds) {
                                    // Add the announcement to the speech queue if it's the same client but with a different creation time
                                    speechQueue.push("Once again, Client Number " + data[i].client_number + ", please proceed to " + data[i].office + "'s Office.");
                                } else if (!announcedClients.hasOwnProperty(clientKey)) {
                                    // Add the announcement to the speech queue if it's a different client
                                    speechQueue.push("Client Number " + data[i].client_number + ", please proceed to " + data[i].office + "'s Office.");
                                }
                            }
                        }
                        $('#clients').html(clientsHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

                // Process the speech queue
                while (speechQueue.length > 0) {
                    speak(speechQueue.shift());
                }
            }, 1000); // 1 second interval

            // // Function to speak the announcement
            // function speak(text) {
            //     if ('speechSynthesis' in window) {
            //         var utterance = new SpeechSynthesisUtterance(text);
            //         speechSynthesis.speak(utterance);
            //     } else {
            //         console.error('SpeechSynthesis API is not supported.');
            //     }
            // }
        });
    </script>
</body>
</html>
