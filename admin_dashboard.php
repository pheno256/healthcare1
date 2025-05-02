<?php
session_start();
require_once 'includes/db.php';

// Optional: Add basic admin access control
if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'Admin') {
    echo "<p class='error'>Access denied. Admins only.</p>";
    exit;
}

function fetchAll($conn, $query) {
    $result = $conn->query($query);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

$users = fetchAll($conn, "SELECT id, name, email, created_at FROM users");
$doctors = fetchAll($conn, "SELECT id, name, specialty, location FROM doctors");
$appointments = fetchAll($conn, "
    SELECT a.id, u.name AS patient, d.name AS doctor, a.appointment_date
    FROM appointments a
    JOIN users u ON a.user_id = u.id
    JOIN doctors d ON a.doctor_id = d.id
    ORDER BY a.appointment_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - HealthCare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="home.html" class="logo">HealthCare Admin</a>
    <ul>
        <li><a href="home.html">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <div class="glass-form">
        <h2>All Users</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user['name']) ?> - <?= $user['email'] ?> (<?= $user['created_at'] ?>)
                <form action="admin_edit.php" method="POST" onsubmit="return confirm('Delete user?');" style="display:inline;">
                    <input type="hidden" name="type" value="delete_user">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <button type="submit">Delete</button>
                </form></li>
                <li><?= htmlspecialchars($user['name']) ?> - <?= $user['email'] ?> (<?= $user['created_at'] ?>)</li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="glass-form">
        <h2>All Doctors</h2>
        <ul>
            <?php foreach ($doctors as $doc): ?>
                <form action="admin_edit.php" method="POST" style="margin-bottom:10px;">
                    <input type="hidden" name="type" value="edit_doctor">
                    <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                    <input type="text" name="name" value="<?= htmlspecialchars($doc['name']) ?>" required>
                    <input type="text" name="specialty" value="<?= htmlspecialchars($doc['specialty']) ?>" required>
                    <input type="text" name="location" value="<?= htmlspecialchars($doc['location']) ?>" required>
                    <button type="submit">Update</button>
                </form>
                <form action="admin_edit.php" method="POST" onsubmit="return confirm('Delete doctor?');">
                    <input type="hidden" name="type" value="delete_doctor">
                    <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
                <li><?= htmlspecialchars($doc['name']) ?> - <?= $doc['specialty'] ?> - <?= $doc['location'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="glass-form">
        <h2>Appointments</h2>
        <ul>
            <?php foreach ($appointments as $appt): ?>
                <li><?= htmlspecialchars($appt['patient']) ?> with <?= htmlspecialchars($appt['doctor']) ?> on <?= $appt['appointment_date'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
</body>
</html>
