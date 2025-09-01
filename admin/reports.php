<?php
session_start();
include '../config/newConnection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}


$userCount = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$bookCount = $conn->query("SELECT COUNT(*) as total FROM books")->fetch_assoc()['total'];
$transactionCount = $conn->query("SELECT COUNT(*) as total FROM transactions")->fetch_assoc()['total'];
$issuedCount = $conn->query("SELECT COUNT(*) as total FROM transactions WHERE status = 'issued'")->fetch_assoc()['total'];
$returnedCount = $conn->query("SELECT COUNT(*) as total FROM transactions WHERE status = 'returned'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Reports - Library Management System</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0; padding: 0;
        background-color: #f4f6f9;
    }
    header {
        background-color: #357ABD;
        color: white;
        padding: 15px 25px;
        text-align: center;
    }
    h2 {
        margin: 0;
    }
    .container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 30px;
    }
    .card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card h3 {
        margin: 0;
        font-size: 18px;
        color: #555;
    }
    .card p {
        font-size: 28px;
        margin: 10px 0 0;
        color: #357ABD;
        font-weight: bold;
    }
    .back-btn {
        display: block;
        width: max-content;
        margin: 30px auto;
        padding: 10px 20px;
        background: #357ABD;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        transition: 0.3s;
    }
    .back-btn:hover {
        background: #285f91;
    }
</style>
</head>
<body>

<header>
    <h2> Library Reports</h2>
</header>

<div class="container">
    <div class="card">
        <h3>Total Users</h3>
        <p><?php echo $userCount; ?></p>
    </div>
    <div class="card">
        <h3>Total Books</h3>
        <p><?php echo $bookCount; ?></p>
    </div>
    <div class="card">
        <h3>Total Transactions</h3>
        <p><?php echo $transactionCount; ?></p>
    </div>
    <div class="card">
        <h3>Books Currently Issued</h3>
        <p><?php echo $issuedCount; ?></p>
    </div>
    <div class="card">
        <h3>Books Returned</h3>
        <p><?php echo $returnedCount; ?></p>
    </div>
</div>

<a href="admin_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
