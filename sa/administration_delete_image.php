<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (file_exists($file)) {
        unlink($file);
        echo "<script>alert('File deleted successfully.'); window.location.href = 'administration_index.php';</script>";
    } else {
        echo "<script>alert('File not found.'); window.location.href = 'administration_index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'administration_index.php';</script>";
}
?>
