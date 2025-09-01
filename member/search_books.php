<?php
session_start();
include '../config/newConnection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../authentication/login.php");
    exit;
}

$search = '';
$results = [];

if (isset($_GET['q'])) {
    $search = trim($_GET['q']);
    if ($search !== '') {
        $like = "%$search%";
        $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR publisher LIKE ? ORDER BY title ASC");
        $stmt->bind_param("sss", $like, $like, $like);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Search Books</title>
<style>
  body { font-family: Arial, sans-serif; padding: 20px; background: #f4f6f8; }
  form { margin-bottom: 20px; }
  input[type="text"] { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 6px; }
  button { padding: 8px 16px; background: #357ABD; color: white; border: none; border-radius: 6px; cursor: pointer; }
  button:hover { background: #2a5d8c; }
  table { border-collapse: collapse; width: 100%; background: white; }
  th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
  th { background: #357ABD; color: white; }
  a { color: #357ABD; font-weight: bold; text-decoration: none; }
  a:hover { text-decoration: underline; }
</style>
</head>
<body>

<h2>Search Books</h2>

<form method="get" action="">
    <input type="text" name="q" placeholder="Enter title, author, or publisher" value="<?php echo htmlspecialchars($search); ?>" required>
    <button type="submit">Search</button>
</form>

<?php if ($search !== ''): ?>
    <h3>Search results for "<?php echo htmlspecialchars($search); ?>"</h3>

    <?php if (count($results) > 0): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Year</th>
                <th>Copies</th>
            </tr>
            <?php foreach ($results as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo htmlspecialchars($book['publisher']); ?></td>
                <td><?php echo htmlspecialchars($book['year']); ?></td>
                <td><?php echo htmlspecialchars($book['copies']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No books found matching your search.</p>
    <?php endif; ?>
<?php endif; ?>

<a href="member_dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
