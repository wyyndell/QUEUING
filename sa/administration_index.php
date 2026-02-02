<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/administration_style.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>PUP Queue</title>
</head>
<style>
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
            padding: 20px;
            position: relative; /* Position relative for z-index */
        }
        .gallery-item {
            position: relative;
        }
        .gallery-item img, .gallery-item video {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 5px;
        }
        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

        /* Style for modal */
        .modal {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Center the modal */
            z-index: 1000; /* Ensure modal is displayed in front */
            background-color: rgba(0, 0, 0, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow */
        }

        .modal-content {
            display: block;
            max-width: 100%;
            max-height: 80vh; /* Limit height */
            margin: auto;
        }

        .close {
            color: #fff;
            font-size: 2rem;
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }
    </style>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">CodingLab</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="administration_index.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>

                <li><a href="administration_monitoring.php">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="link-name">Monitoring</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <img src="images/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Offices</span>
                </div>

                <div class="boxes" id="office-container">
                    <?php include 'administration_offices.php'?>
                </div>
            </div>


            <hr style="margin: 30px;">
                <div class="activity"><div class="gallery">
                    <h2>Add new</h2>
                    <form action="administration_upload_image.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload" name="submit">
                    </form> 
                </div>
               
                <h2 style="margin: 20px;">You've been announced</h2>

                <div class="activity-data">
                    <div class="gallery">
                    <?php
                    // Directory containing images and videos
                    $dir = 'slider';
                    
                    // Get all files in the directory
                    $files = scandir($dir);
                    
                    // Remove . and .. from the array
                    $files = array_diff($files, array('.', '..'));
                    
                    // Loop through each file and display as a gallery item
                    foreach ($files as $file) {
                        echo '<div class="gallery-item" onclick="openModal(\'' . $dir . '/' . $file . '\')">';
                        
                        // Display images
                        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
                            echo '<img src="' . $dir . '/' . $file . '" alt="' . $file . '">';
                        }
                        // Display videos
                        elseif (preg_match('/\.(mp4|avi|mov|wmv|mkv)$/i', $file)) {
                            echo '<video controls><source src="' . $dir . '/' . $file . '" type="video/mp4">Your browser does not support the video tag.</video>';
                        }
                        
                        echo '<button class="delete-button" onclick="deleteFile(\'' . $dir . '/' . $file . '\')">X</button>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <!-- Modal -->
                <div id="galleryModal" class="modal">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <img id="modalContent" class="modal-content">
                </div>
                <!-- End Modal -->


                <script>
                    function deleteFile(filePath) {
                        if (confirm('Are you sure you want to delete this file?')) {
                            window.location.href = 'administration_delete_image.php?file=' + encodeURIComponent(filePath);
                        }
                    }

                    function openModal(filePath) {
                        var modal = document.getElementById("galleryModal");
                        var modalContent = document.getElementById("modalContent");
                        modal.style.display = "block";
                        modalContent.src = filePath; // Set the src attribute to display the image
                    }

                    function closeModal() {
                        var modal = document.getElementById("galleryModal");
                        modal.style.display = "none";
                    }



                    // fetching online offices and its data
                    // Function to fetch and update data from PHP script
                    function updateData() {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("office-container").innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "online_offices.php", true);
                        xmlhttp.send();
                    }

                    // Call the updateData function every 1 second
                    setInterval(updateData, 1000);
                </script>

                </div>
            </div>
        </div>
    </section>

    <script src="js/administration_script.js"></script>
</body>
</html>