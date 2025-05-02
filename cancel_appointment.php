<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $appointment_id, $user_id);

    if ($stmt->execute()) {
        echo "<p class='success'>Appointment cancelled successfully.</p>";
    } else {
        echo "<p class='error'>Error cancelling appointment.</p>";
    }

    $stmt->close();
}
?>