<?php
session_start();

// Check if user is logged in and is member
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../authentication/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Member Dashboard - Library Management System</title>
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
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (Member)</h1>
  
</header>

<nav>
  <a href="view_books.php">View Books</a>
  <a href="search_books.php">Search Books</a>
  <a href="receive_books.php">Reserve Books</a>
  <a href="payment.php">Payments</a>
</nav>

<div class="content">
  <h2>Member Dashboard</h2>
  <p>Welcome to your dashboard. From here you can browse books, borrow items, search the catalog, and make payments.</p>
  <!-- Add more member-specific content here -->
</div>

<br>
<a href="../authentication/logout.php" class="logout">Logout</a>

</body>
</html>
