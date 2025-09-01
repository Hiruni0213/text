<?php
session_start();
include '../config/newConnection.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'librarian')) {
    header("Location: ../authentication/login.php");
    exit;
}

// Mark transaction returned
if (isset($_GET['return'])) {
    $trans_id = intval($_GET['return']);
    $return_date = date('Y-m-d');
    $status = 'returned';
    $stmt = $conn->prepare("UPDATE transactions SET return_date = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssi", $return_date, $status, $trans_id);
    $stmt->execute();
    header("Location: manage_transactions.php");
    exit;
}

$sql = "SELECT t.id, u.name AS user_name, b.title AS book_title, t.issue_date, t.return_date, t.status
        FROM transactions t
        JOIN users u ON t.user_id = u.id
        JOIN books b ON t.book_id = b.id
        ORDER BY t.issue_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Transactions</title>
<style>
  table { border-collapse: collapse; width: 100%; }
  th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
  th { background-color: #357ABD; color: white; }
  a.returned { color: green; text-decoration: none; font-weight: 600; }
</style>
</head>
<body>
<h2>Manage Transactions</h2>

<table>
  <tr>
    <th>ID</th><th>User</th><th>Book</th><th>Issue Date</th><th>Return Date</th><th>Status</th><th>Actions</th>
  </tr>
  <?php while ($trans = $result->fetch_assoc()): ?>
  <tr>
    <td><?php echo $trans['id']; ?></td>
    <td><?php echo htmlspecialchars($trans['user_name']); ?></td>
    <td><?php echo htmlspecialchars($trans['book_title']); ?></td>
    <td><?php echo $trans['issue_date']; ?></td>
    <td><?php echo $trans['return_date'] ?? '-'; ?></td>
    <td><?php echo ucfirst($trans['status']); ?></td>
    <td>
      <?php if ($trans['status'] !== 'returned'): ?>
      <a href="manage_transactions.php?return=<?php echo $trans['id']; ?>" class="returned" onclick="return confirm('Mark as returned?')">Mark Returned</a>
      <?php else: ?>
      -
      <?php endif; ?>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

<a href="admin_dashboard.php" class="back-link">&larr; Back to Dashboard</a>
</body>
</html>
