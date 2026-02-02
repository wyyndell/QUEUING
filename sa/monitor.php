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
        font-family: Arial, sans-serif;
/*         background-image: url('img/bgcover.png'); */
/*         background-size: cover; */
/*         background-repeat: no-repeat; */
        background-color: #fff;
    }

    
</style>
<body>
    <div class="headings">
        <img src="img/puplogo.png" style="height: 50px; width: 50px;">
        <h2  style="margin-left: 10px;">Polytechnic University of the Philippines Unisan Campus</h2>
    </div>
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

            <script>
                // Function to handle the sliding behavior based on the type of content
                function handleSlide() {
                    var currentItem = $('.carousel-item.active');
                    var videoElement = currentItem.find('video').get(0);

                    // Pause the carousel
                    $('#carouselExampleIndicators').carousel('pause');

                    // Check if the current item is a video
                    if (videoElement) {
                        // If it's a video, play it and wait for it to finish before sliding to the next
                        videoElement.play();
                        setTimeout(function() {
                            $('#carouselExampleIndicators').carousel('next');
                        }, videoElement.duration * 1000); // Wait for the video duration before sliding to the next
                    } else {
                        // If it's an image, set a timeout to advance to the next slide after 5 seconds
                        setTimeout(function() {
                            $('#carouselExampleIndicators').carousel('next');
                        }, 5000); // 5 seconds interval
                    }
                }

                // Listen for slide event to handle each slide
                $('#carouselExampleIndicators').on('slide.bs.carousel', function() {
                    handleSlide();
                });

                // Initialize the carousel and handle the first slide
                $(document).ready(function() {
                    $('#carouselExampleIndicators').carousel({
                        interval: false, // Disable default interval
                        pause: 'hover'
                    });
                    handleSlide(); // Handle the first slide
                });
            </script>




            <!-- End Bootstrap Carousel -->
        </div>
        <div class="now_serving">
            <h2><i class="fa-solid fa-bullhorn"></i> Now Serving</h2>
            <div id="clients" class="clients"></div>
        </div>
    </div>
    <div class="news-ticker-container">
        <div class="time-container">
            <span id="current-time"></span>
        </div>
        <div class="news-ticker">
            <span>Important:</span>
            <span>Be Attentive</span>
            <span>Stay Tuned</span>
            <span>Observe Silence</span>
            <span>Beware of Interruptions, contact iTPrenuer for Technical Assistance | 09355539509 - 09103230836</span>
        </div>
    </div>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    
    
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script>

        const slider = document.querySelector('.slider');
        let isTransitioning = false;

        function slide() {
            if (!isTransitioning) {
                isTransitioning = true;
                setTimeout(() => {
                    const firstSlide = slider.children[0];
                    slider.appendChild(firstSlide);
                    slider.style.transform = 'translateX(-100%)';
                }, 100);
                setTimeout(() => {
                    slider.style.transition = 'none';
                    slider.style.transform = 'translateX(0)';
                    setTimeout(() => {
                        slider.style.transition = 'transform 0.5s ease-in-out';
                        isTransitioning = false;
                    }, 100);
                }, 600);
            }
        }

        setInterval(slide, 2000);


        
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
                                    '<div style="font-size: 35px; background-color: #3498db; color: white; padding: 10px 20px; border-top-left-radius: 10px; border-bottom-left-radius: 10px; min-width: 90px">'+ data[i].client_number +'</div>' +
                                    '<h2 style="font-size: 25px; margin-right: 10px;">'+ data[i].office + "'s Office</h2>" +
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
                clientsHtml += '</div>';
                // Update the announcedClients object with the new creation time
                announcedClients[clientKey] = createdTimeSeconds;
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
});



// Function to speak the announcement
        function speak(text) {
            if ('speechSynthesis' in window) {
                var utterance = new SpeechSynthesisUtterance(text);
                speechSynthesis.speak(utterance);
            } else {
                console.error('SpeechSynthesis API is not supported.');
            }
        }

        // Event listener for the button click to trigger speech synthesis
        document.getElementById('speakButton').addEventListener('click', function() {
            // Modify the text here to match your announcement
            var announcementText = text;
            speak(announcementText);
        });



function updateTime() {
  const currentTime = new Date();
  let hours = currentTime.getHours();
  let minutes = currentTime.getMinutes();
  const ampm = hours >= 12 ? 'PM' : 'AM';

  // Convert to 12-hour format
  hours = hours % 12;
  hours = hours ? hours : 12; // 12 should be displayed as 12, not 0
  minutes = minutes < 10 ? '0' + minutes : minutes; // Add leading zero if needed

  const formattedTime = `${hours}:${minutes} ${ampm}`;
  document.getElementById('current-time').textContent = formattedTime;
}

// Update time every minute
setInterval(updateTime, 1000);

// Initial update
updateTime();


</script>
</body>
</html>
