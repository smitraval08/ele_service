<?php
include 'session_manager.php';
include 'Datastore.php';
include 'header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $complaint_text = $_POST['complaint_text'];
    $address = $_POST['address'];
    $status = 'Pending';

    if ($user_id) {
        $stmt = $con->prepare("INSERT INTO complaints (user_id, complaint_text, address, status, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isss", $user_id, $complaint_text, $address, $status);

        if ($stmt->execute()) {
            $_SESSION['complaint_id'] = $stmt->insert_id; 
            header("Location: AppointmentPage.php");
            exit;
        } else {
            $message = "❌ Error: " . $con->error;
        }
    } else {
        $message = "⚠️ Please login first.";
    }
}
?>

<div class="container">
    <h2>Register Complaint</h2>
    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="POST">
        <label>Complaint:</label>
        <textarea name="complaint_text" required></textarea>

        <label>Address:</label>
        <textarea name="address" required></textarea>

        <button type="submit">Submit</button>
    </form>
</div>

<?php include 'footer.php'; ?>
