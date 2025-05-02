<?php
session_start();

$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
    $fileName = basename($_FILES['profile_photo']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFilePath)) {
        echo "<p class='success'>Photo uploaded successfully: $fileName</p>";
    } else {
        echo "<p class='error'>Error uploading file.</p>";
    }
} else {
    echo "<p class='error'>No file uploaded.</p>";
}
?>