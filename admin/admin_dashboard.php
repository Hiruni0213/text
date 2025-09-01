<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../config/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Dashboard - Library Management System</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f8;
    margin: 0;
    padding: 20px;
  }
  header {
    background-color: #357ABD;
    color: white;
    padding: 15px 30px;
    border-radius: 6px;
    margin-bottom: 30px;
  }
  h1 {
    margin: 0;
  }
  nav {
    margin-bottom: 40px;
  }
  nav a {
    display: inline-block;
    margin-right: 20px;
    text-decoration: none;
    color: #357ABD;
    font-weight: 600;
  }
  nav a:hover {
    text-decoration: underline;
  }
  .content {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }
  .logout {
    float: right;
    background: #f44336;
    color: white;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
  }
  .logout:hover {
    background: #d32f2f;
  }
</style>
</head>
<body>

<header>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (Admin)</h1>
  
</header>

<nav>
  <a href="manage_users.php">Manage Users</a>
  <a href="manage_transactions.php">Manage Transactions</a>
  <a href="reports.php">Reports</a>
</nav>

<div class="content">
  <h2>Admin Dashboard</h2>
  <p>This is your dashboard where you can manage users, books, transactions, and generate reports.</p>
  <!-- Add more admin functionalities here -->
</div>

<br>

<a href="../authentication/logout.php" class="logout">Logout</a>

</body>
</html>
