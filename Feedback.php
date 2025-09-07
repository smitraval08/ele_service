<?php
include 'session_manager.php';
include 'Datastore.php';
include 'header.php';

$message = '';
$user_id = $_SESSION['user_id'];

// Fetch only complaints of this user
$complaints_stmt = $con->prepare("SELECT id, complaint_text FROM complaints WHERE user_id=?");
$complaints_stmt->bind_param("i", $user_id);
$complaints_stmt->execute();
$complaints_result = $complaints_stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_POST['complaint_id']; // must be from dropdown
    $rating = (int)$_POST['rating'];
    $comments = trim($_POST['comments']);

    $stmt = $con->prepare("INSERT INTO feedback (user_id, complaint_id, rating, comments, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiis", $user_id, $complaint_id, $rating, $comments);

    if ($stmt->execute()) {
        $message = "✅ Feedback submitted successfully!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }
}
?>

<div class="container">
    <h2>Give Feedback</h2>
    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="POST">
        <label for="complaint_id">Select Complaint:</label>
        <select name="complaint_id" required>
            <?php while($row = $complaints_result->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['complaint_text']) ?></option>
            <?php } ?>
        </select>

        <label for="rating">Rating (1 to 5):</label>
        <select name="rating" required>
            <option value="1">1 - Very Poor</option>
            <option value="2">2 - Poor</option>
            <option value="3">3 - Average</option>
            <option value="4">4 - Good</option>
            <option value="5">5 - Excellent</option>
        </select>

        <label for="comments">Comments:</label>
        <textarea name="comments" required></textarea>

        <button type="submit">Submit Feedback</button>
    </form>
</div>

<?php include 'footer.php'; ?>
