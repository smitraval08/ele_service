<?php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php"); exit;
}

$res = $con->query("SELECT COUNT(*) AS total FROM complaints");
$total = $res ? (int)$res->fetch_assoc()['total'] : 0;

$recent = $con->query("SELECT c.id, e.full_name AS customer, c.complaint_text, c.status, c.created_at FROM complaints c JOIN eservice e ON c.user_id=e.id ORDER BY c.created_at DESC LIMIT 10");
?>
<?php include 'header.php'; ?>
<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Total complaints: <strong><?= $total ?></strong></p>

    <h3>Recent</h3>
    <?php if ($recent && $recent->num_rows > 0): ?>
        <table>
            <tr><th>ID</th><th>Customer</th><th>Complaint</th><th>Status</th><th>Date</th></tr>
            <?php while ($r = $recent->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['customer']) ?></td>
                    <td><?= htmlspecialchars($r['complaint_text']) ?></td>
                    <td><?= htmlspecialchars($r['status']) ?></td>
                    <td><?= htmlspecialchars($r['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No recent complaints.</p>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
