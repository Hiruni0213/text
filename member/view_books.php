<?php
session_start();
include '../config/newConnection.php';

// Only allow members
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../authentication/login.php");
    exit;
}

$result = $conn->query("SELECT * FROM books ORDER BY title ASC");
?>
<!DOCTYPE html>
<html>
<head>
<title>View Books</title>
<style>
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
th { background: #357ABD; color: white; }
</style>
</head>
<body>
<h2>Available Books</h2>
<table>
<tr>
    <th>Title</th>
    <th>Author</th>
    <th>Publisher</th>
    <th>Year</th>
    <th>Copies</th>
</tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['title']); ?></td>
    <td><?php echo htmlspecialchars($row['author']); ?></td>
    <td><?php echo htmlspecialchars($row['publisher']); ?></td>
    <td><?php echo htmlspecialchars($row['year']); ?></td>
    <td><?php echo htmlspecialchars($row['copies']); ?></td>
</tr>
<?php endwhile; ?>
</table>
<a href="member_dashboard.php">⬅ Back to Dashboard</a>
</body>
</html>
