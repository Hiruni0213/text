<?php
session_start();
include '../config/newConnection.php';

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}

// Get user ID from query
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_users.php");
    exit;
}

$user_id = intval($_GET['id']);
$error = "";
$success = "";

// Fetch existing user details
$stmt = $conn->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manage_users.php");
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role  = $_POST['role'];

    if (empty($name) || empty($email) || empty($role)) {
        $error = "All fields are required.";
    } else {
        // Prevent changing own role from admin to non-admin
        if ($user_id === (int)$_SESSION['user_id'] && $role !== 'admin') {
            $error = "You cannot change your own role.";
        } else {
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $email, $role, $user_id);
            if ($stmt->execute()) {
                $success = "User updated successfully!";
                // Refresh data
                $user['name']  = $name;
                $user['email'] = $email;
                $user['role']  = $role;
            } else {
                $error = "Error updating user: " . $conn->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit User - Library Management System</title>
<style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { color: #357ABD; }
    form { max-width: 400px; margin-top: 20px; }
    label { display: block; margin-bottom: 6px; font-weight: bold; }
    input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
    button { padding: 10px 15px; background: #357ABD; color: white; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #285a8e; }
    .error-message { background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
    .success-message { background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
    .back-link { text-decoration: none; color: #357ABD; font-weight: bold; }
</style>
</head>
<body>

<h2>Edit User</h2>

<?php if ($error): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

    <label>Role:</label>
    <select name="role" required>
        <option value="admin" <?php if ($user['role'] === 'admin') echo "selected"; ?>>Admin</option>
        <option value="librarian" <?php if ($user['role'] === 'librarian') echo "selected"; ?>>Librarian</option>
        <option value="member" <?php if ($user['role'] === 'member') echo "selected"; ?>>Member</option>
    </select>

    <button type="submit">Update User</button>
</form>

<p><a href="manage_users.php" class="back-link">&larr; Back to Manage Users</a></p>

</body>
</html>
