<?php
session_start();

// Check if user is logged in and is librarian
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'librarian') {
    header("Location: ../authentication/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Librarian Dashboard - Library Management System</title>
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
  .content {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }
</style>
</head>
<body>

<header>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (Librarian)</h1>
  
</header>

<nav>
  <a href="manage_books.php">Manage Books</a>
  <a href="manage_members.php">Manage Members</a>
  <a href="manage_fines.php">Manage Fines</a>
  <a href="issue_books.php">Issue Book</a>
  <a href="return_book.php">Return Book</a>
  
</nav>

<div class="content">
  <h2>Librarian Dashboard</h2>
  <p>From here, you can manage books, issue and return books, manage library members, and handle fines.</p>
  <!-- Add more librarian-specific content here -->
</div>

<br>
<a href="../authentication/logout.php" class="logout">Logout</a>

</body>
</html>
