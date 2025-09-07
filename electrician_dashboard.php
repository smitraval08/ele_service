<?php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'electrician') {
    header("Location: login.php"); exit;
}

$stmt = $con->prepare("
    SELECT c.id, e.full_name AS customer_name, c.complaint_text, c.address, c.status, c.created_at
    FROM complaints c
    JOIN eservice e ON c.user_id = e.id
    ORDER BY c.created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include 'header.php'; ?>
<div class="container">
    <h2>Electrician Dashboard</h2>
    <h3>Assigned / Pending Complaints</h3>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr><th>ID</th><th>Customer</th><th>Complaint</th><th>Address</th><th>Status</th><th>Date</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['complaint_text']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No complaints found.</p>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
