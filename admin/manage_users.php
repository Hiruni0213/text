<?php
session_start();
include '../config/newConnection.php';

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);

    // Prevent admin from deleting their own account
    if ($del_id === (int)$_SESSION['user_id']) {
        $error = "You cannot delete your own account.";
    } else {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $del_id);
        $stmt->execute();
        header("Location: manage_users.php");
        exit;
    }
}

// Fetch all users
$result = $conn->query("SELECT id, name, email, role FROM users ORDER BY id ASC");
if (!$result) {
    die("Error fetching users: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Users - Library Management System</title>
<style>
  body {
    font-family: Arial, sans-serif;
    padding: 20px;
  }
  h2 {
    color: #357ABD;
  }
  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
  }
  th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
  }
  th {
    background-color: #357ABD;
    color: white;
  }
  a.delete {
    color: red;
    text-decoration: none;
    font-weight: bold;
  }
  a.delete:hover {
    text-decoration: underline;
  }
  a.edit {
    color: #357ABD;
    text-decoration: none;
    font-weight: bold;
  }
  a.edit:hover {
    text-decoration: underline;
  }
  .error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-weight: 600;
  }
  .back-link {
    margin-top: 20px;
    display: inline-block;
    color: #357ABD;
    text-decoration: none;
    font-weight: 600;
  }
  .back-link:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<h2>Manage Users</h2>

<?php if (isset($error)): ?>
  <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<table>
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($user = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $user['id']; ?></td>
          <td><?php echo htmlspecialchars($user['name']); ?></td>
          <td><?php echo htmlspecialchars($user['email']); ?></td>
          <td><?php echo $user['role']; ?></td>
          <td>
            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit">Edit</a> |
            <a href="manage_users.php?delete=<?php echo $user['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">No users found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<a href="admin_dashboard.php" class="back-link">&larr; Back to Dashboard</a>

</body>
</html>
