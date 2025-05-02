<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id);

    if ($stmt->execute()) {
        echo "<p class='success'>Profile updated successfully.</p>";
    } else {
        echo "<p class='error'>Error updating profile.</p>";
    }

    $stmt->close();
}
?>