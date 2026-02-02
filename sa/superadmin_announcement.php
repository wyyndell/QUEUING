<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/superadmin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>SuperAdmin</title>
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
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="superadmin_index.php" class="brand"><i class='bx bxs-smile icon'></i>PUP Queue</a>
        <ul class="side-menu">
            <li><a href="superadmin_index.php" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
            <li class="divider" data-text="main">Main</li>
            <li>
                <a href="#"><i class='bx bxs-inbox icon' ></i> Control <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="operation.php">Operation</a></li>
                    <li><a href="superadmin_history.php">Report</a></li>
                    <li><a href="superadmin_monitoring.php">Client Monitoring</a></li>
                    <li><a href="superadmin_announcement.php">Announcement</a></li>
                    <li><a href="superadmin_pending_clients_monitor.php">Pending Clients</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu toggle-sidebar' ></i>
            <form action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon' ></i>
                </div>
            </form>
            <a href="#" class="nav-link">
                <i class='bx bxs-bell icon' ></i>
                <span class="badge">5</span>
            </a>
            <span class="divider"></span>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
                <ul class="profile-link">
                    <li><a href="#"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
                    <li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li>
                    <li><a href="#"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
                </ul>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Dashboard</h1>
            <ul class="breadcrumbs">
                <li><a href="superadmin_index.php">Home</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Announcement</a></li>
            </ul>
            
            <div class="gallery">
                <h2>Add new</h2>
                <form action="upload_image.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload" name="submit">
                </form> 
            </div>
            <hr style="margin: 20px;">
            <h2 style="margin: 20px;">You've been announced</h2>
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
                        window.location.href = 'delete_image.php?file=' + encodeURIComponent(filePath);
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
            </script>


		    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
		    <script src="js/superadmin_script.js"></script>
    


</body>
</html>
