<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
            padding: 20px;
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
    </style>
</head>
<body>
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
            echo '<div class="gallery-item">';
            
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

    <script>
        function deleteFile(filePath) {
            if (confirm('Are you sure you want to delete this file?')) {
                window.location.href = 'delete_image.php?file=' + encodeURIComponent(filePath);
            }
        }
    </script>
</body>
</html>
