<?php
include 'session_manager.php';
include 'Datastore.php';
include 'header.php';

$message = '';
$messageType = 'error'; // 'success' or 'error'

// CSRF token creation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $complaint_text = trim($_POST['complaint_text'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $status = 'Pending';

    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $message = "⚠️ Invalid form submission.";
    } elseif ($user_id && $complaint_text && $address) {
        $stmt = $con->prepare(
            "INSERT INTO complaints (user_id, complaint_text, address, status, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param("isss", $user_id, $complaint_text, $address, $status);

        if ($stmt->execute()) {
            $_SESSION['complaint_id'] = $stmt->insert_id;
            header("Location: AppointmentPage.php");
            exit;
        } else {
            $message = "❌ Error: " . htmlspecialchars($con->error);
        }
    } else {
        $message = "⚠️ Please login first.";
    }
}
?>

<div class="container">
    <h2>📢 Register Complaint</h2>

    <?php if ($message): ?>
        <div class="alert <?= $messageType === 'success' ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="complaint-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <label for="complaint_text">Complaint:</label>
        <textarea id="complaint_text" name="complaint_text" placeholder="Describe your issue..." required></textarea>

        <label for="address">Address:</label>
        <textarea id="address" name="address" placeholder="Enter your address..." required></textarea>

        <button type="submit" class="btn-submit">Submit Complaint</button>
    </form>
</div>

<style>
.container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
label {
    font-weight: bold;
    margin-top: 10px;
    display: block;
}
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: vertical;
    min-height: 80px;
}
.btn-submit {
    margin-top: 15px;
    background: #28a745;
    color: #fff;
    border: none;
    padding: 12px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    border-radius: 5px;
}
.btn-submit:hover {
    background: #218838;
}
.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}
.alert-success {
    background: #d4edda;
    color: #155724;
}
.alert-danger {
    background: #f8d7da;
    color: #721c24;
}
</style>

<?php include 'footer.php'; ?>
