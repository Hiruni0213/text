<?php
session_start();
include '../config/newConnection.php';

// Check if user is logged in and is librarian
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'librarian') {
    header("Location: ../authentication/login.php");
    exit;
}

$msg = '';

// Add new member
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, 'user', 'active')");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $msg = "Member added successfully.";
    } else {
        $msg = "Error adding member: " . $conn->error;
    }
}

// Activate / Deactivate member
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $res = $conn->query("SELECT status FROM users WHERE id=$id AND role='user'");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $newStatus = ($row['status'] === 'active') ? 'inactive' : 'active';
        $conn->query("UPDATE users SET status='$newStatus' WHERE id=$id AND role='user'");
        $msg = "Member status changed to " . ucfirst($newStatus) . ".";
    }
}

// Fetch all members
$members = $conn->query("SELECT id, name, email, status FROM users WHERE role='user' ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Members</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 20px; }
    h2, h3, h4 { color: #357ABD; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 8px; text-align: left; }
    input, button { padding: 8px; margin-top: 6px; width: 100%; border-radius: 4px; border: 1px solid #ccc; }
    button { background: #357ABD; color: white; border: none; cursor: pointer; }
    button:hover { background: #285a8d; }
    .msg { font-weight: bold; margin-bottom: 15px; color: green; }
    .actions a { margin-right: 10px; text-decoration: none; padding: 5px 8px; border-radius: 4px; }
    .activate { background: #28a745; color: white; }
    .deactivate { background: #dc3545; color: white; }
    .actions a:hover { opacity: 0.8; }
    .container { background: #fff; padding: 15px; border: 1px solid #ccc; border-radius: 6px; }
</style>
</head>
<body>

<h2>Manage Members</h2>

<?php if ($msg): ?>
    <p class="msg"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<div class="container">

    <!-- Add Member Form -->
    <form method="POST" style="margin-bottom:20px;">
        <h4>Add New Member</h4>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add_member">Add Member</button>
    </form>

    <!-- Existing Members Table -->
    <h4>Existing Members</h4>
    <table>
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php if ($members && $members->num_rows > 0): ?>
                <?php while ($row = $members->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td class="actions">
                        <?php if ($row['status'] === 'active'): ?>
                            <a href="?toggle=<?= $row['id'] ?>" class="deactivate" onclick="return confirm('Deactivate this member?');">Deactivate</a>
                        <?php else: ?>
                            <a href="?toggle=<?= $row['id'] ?>" class="activate" onclick="return confirm('Activate this member?');">Activate</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No members found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<br><br>
<a href="librarian_dashboard.php" class="back">&larr; Back to Dashboard</a>

</body>
</html>
