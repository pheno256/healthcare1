<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'Admin') {
    echo "<p class='error'>Access denied.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_POST['type'];
    $id = intval($_POST['id']);

    if ($type === "delete_user") {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    } elseif ($type === "delete_doctor") {
        $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
    } elseif ($type === "edit_doctor") {
        $name = $_POST['name'];
        $specialty = $_POST['specialty'];
        $location = $_POST['location'];
        $stmt = $conn->prepare("UPDATE doctors SET name = ?, specialty = ?, location = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $specialty, $location, $id);
        if ($stmt->execute()) {
            header("Location: admin_dashboard.php");
            exit;
        }
    }

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    header("Location: admin_dashboard.php");
}
?>