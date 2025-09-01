<?php
session_start();
include '../config/newConnection.php';  // Your DB connection file

// Only allow admin access
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'librarian') {
    header("Location: ../authentication/login.php");
    exit;
}

// Add book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $year = intval($_POST['year']);
    $copies = intval($_POST['copies']);

    if ($title === '') {
        $error = "Title is required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO books (title, author, publisher, year, copies) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $title, $author, $publisher, $year, $copies);
        $stmt->execute();
        header("Location: manage_books.php");
        exit;
    }
}

// Delete book
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $del_id);
    $stmt->execute();
    header("Location: manage_books.php");
    exit;
}

// Fetch all books
$result = $conn->query("SELECT * FROM books ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Books - Library Management System</title>
<style>
  body { font-family: Arial, sans-serif; padding: 20px; }
  h2 { color: #357ABD; }
  form { margin-bottom: 30px; }
  input[type=text], input[type=number] {
    padding: 6px; margin-right: 10px; width: 180px;
  }
  input[type=submit] {
    padding: 8px 16px; background: #357ABD; color: white;
    border: none; border-radius: 6px; cursor: pointer;
  }
  table {
    border-collapse: collapse; width: 100%;
  }
  th, td {
    border: 1px solid #ddd; padding: 12px; text-align: left;
  }
  th {
    background-color: #357ABD; color: white;
  }
  a.delete {
    color: red; text-decoration: none; font-weight: bold;
  }
  a.delete:hover {
    text-decoration: underline;
  }
  .error {
    background-color: #f8d7da; color: #721c24;
    padding: 10px; border-radius: 5px; margin-bottom: 20px;
  }
  a.back {
    display: inline-block; margin-top: 20px;
    color: #357ABD; text-decoration: none; font-weight: 600;
  }
  a.back:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<h2>Manage Books</h2>

<?php if (isset($error)): ?>
  <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="">
  <input type="text" name="title" placeholder="Title *" required>
  <input type="text" name="author" placeholder="Author">
  <input type="text" name="publisher" placeholder="Publisher">
  <input type="number" name="year" placeholder="Year" min="1000" max="2100">
  <input type="number" name="copies" placeholder="Copies" min="1" value="1" required>
  <input type="submit" value="Add Book">
</form>

<table>
  <thead>
    <tr>
      <th>ID</th><th>Title</th><th>Author</th><th>Publisher</th><th>Year</th><th>Copies</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($book = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $book['id']; ?></td>
        <td><?php echo htmlspecialchars($book['title']); ?></td>
        <td><?php echo htmlspecialchars($book['author']); ?></td>
        <td><?php echo htmlspecialchars($book['publisher']); ?></td>
        <td><?php echo $book['year']; ?></td>
        <td><?php echo $book['copies']; ?></td>
        <td>
          <a href="manage_books.php?delete=<?php echo $book['id']; ?>" class="delete" onclick="return confirm('Delete this book?');">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="7">No books found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<a href="librarian_dashboard.php" class="back">&larr; Back to Dashboard</a>

</body>
</html>
