<?php
include 'session_manager.php';
include 'Datastore.php';
include 'header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_SESSION['complaint_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    // ✅ Query me 4 columns daal diye (created_at bhi include karenge)
    $stmt = $con->prepare("INSERT INTO appointments (complaint_id, appointment_date, appointment_time, created_at) VALUES (?, ?, ?, NOW())");
    
    // ✅ 1 int (complaint_id), 2 strings (date, time)
    $stmt->bind_param("iss", $complaint_id, $date, $time);

    if ($stmt->execute()) {
        unset($_SESSION['complaint_id']); 
        header("Location: ThankYou.php");
        exit;
    } else {
        $message = "❌ Error booking appointment: " . $con->error;
    }
}
?>

<div class="container">
    <h2>Book Appointment</h2>
    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="POST">
        <label>Select Date:</label>
        <input type="date" name="appointment_date" required>

        <label>Select Time:</label>
        <input type="time" name="appointment_time" required>

        <button type="submit">Confirm Appointment</button>
    </form>
</div>

<?php include 'footer.php'; ?>
