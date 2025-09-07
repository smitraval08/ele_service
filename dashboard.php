<?php
// dashboard.php (final version with date & time)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';

// Consistent session handling
$user_name = $_SESSION['user_name'] ?? $_SESSION['name'] ?? 'User';
$role = $_SESSION['role'] ?? '';

// If user not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - E-Service</title>
    <style>
        .datetime {
            margin: 20px 0;
            padding: 10px;
            font-size: 18px;
            text-align: center;
            background: #f0f0f0;
            border-radius: 8px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($user_name); ?> 👋</h2>
    <p>You are logged in as <strong><?php echo htmlspecialchars(ucfirst($role)); ?></strong></p>

    <!-- Date & Time Block -->
    <div class="datetime">
        <?php
            date_default_timezone_set("Asia/Kolkata"); // India timezone
            echo "📅 " . date("d M Y") . " | ⏰ " . date("h:i A");
        ?>
    </div>

    <!-- Role based links -->
    <?php if ($role === 'customer'): ?>
        <p>
            <a href="ProblemPage.php">Report a problem</a> | 
            <a href="AppointmentPage.php">Appointments</a> | 
            <a href="Feedback.php">Feedback</a>
        </p>
    <?php elseif ($role === 'electrician'): ?>
        <p><a href="electrician_dashboard.php">View complaints</a></p>
    <?php elseif ($role === 'admin'): ?>
        <p><a href="admin_dashboard.php">Admin panel</a></p>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
