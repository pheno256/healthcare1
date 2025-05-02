<?php
require_once 'includes/db.php';

$type = $_GET['type'] ?? '';

if (!in_array($type, ['users', 'doctors', 'appointments'])) {
    die('Invalid export type.');
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="' . $type . '_export.csv"');

$output = fopen('php://output', 'w');

if ($type === 'users') {
    fputcsv($output, ['ID', 'Name', 'Email', 'Created At']);
    $rows = $conn->query("SELECT id, name, email, created_at FROM users");
} elseif ($type === 'doctors') {
    fputcsv($output, ['ID', 'Name', 'Specialty', 'Location']);
    $rows = $conn->query("SELECT id, name, specialty, location FROM doctors");
} else {
    fputcsv($output, ['ID', 'Patient', 'Doctor', 'Appointment Date']);
    $rows = $conn->query("
        SELECT a.id, u.name AS patient, d.name AS doctor, a.appointment_date
        FROM appointments a
        JOIN users u ON a.user_id = u.id
        JOIN doctors d ON a.doctor_id = d.id
    ");
}

while ($row = $rows->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
?>