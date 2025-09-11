<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// don't require DB here; pages will include config before using DB if needed
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Service</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <div class="nav-left">
        <img src="electric-service.png" alt="logo" class="logo-small">
        <span class="site-name">E-Service</span>
    </div>
    <div class="nav-center">
        <a href="index.php">Dashboard</a>
        <a href="ProblemPage.php">Problem</a>
        <a href="AppointmentPage.php">Appointment</a>
        <a href="Feedback.php">Feedback</a>
    </div>
    <div class="nav-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="welcome-txt">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)</span>
            <a href="logout.php" class="logout-link">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</nav>

