<?php
require_once 'includes/db.php';

$events = [];

$result = $conn->query("
    SELECT a.id, a.appointment_date, u.name AS patient, d.name AS doctor
    FROM appointments a
    JOIN users u ON a.user_id = u.id
    JOIN doctors d ON a.doctor_id = d.id
");

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['patient'] . ' with ' . $row['doctor'],
        'start' => $row['appointment_date']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>