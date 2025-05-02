<?php
session_start();
define('ADMIN_PASSWORD', 'admin123'); // Change to a strong password

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['user_name'] = 'Admin';
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <form class="glass-form" method="POST" action="">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <div class="form-group">
            <input type="password" name="password" placeholder="Enter admin password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
