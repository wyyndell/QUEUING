<?php
$target_dir = "slider/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is an image or video
if(isset($_POST["submit"])) {
    $check = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
    if (strpos($check, 'image') === false && strpos($check, 'video') === false) {
        echo "<script>alert('File is not an image or video.'); window.location.href = 'administration_index.php';</script>";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "<script>alert('Sorry, file already exists.'); window.location.href = 'administration_index.php';</script>";
    $uploadOk = 0;
}

// Allow certain file formats (image and video)
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "mp4") {
    echo "<script>alert('Sorry, only JPG, JPEG, PNG, GIF, and MP4 files are allowed.'); window.location.href = 'administration_index.php';</script>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.'); window.location.href = 'administration_index.php';</script>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<script>alert('The file ". htmlspecialchars( basename( $_FILES['fileToUpload']['name'])). " has been uploaded.'); window.location.href = 'administration_index.php';</script>";
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href = 'administration_index.php';</script>";
    }
}
?>
