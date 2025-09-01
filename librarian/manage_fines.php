<?php
session_start();
include '../config/newConnection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'librarian') {
    header("Location: ../authentication/login.php");
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $amount = floatval($_POST['amount']);
    $description = trim($_POST['description']);
    $paid = 0; // Default unpaid

    $stmt = $conn->prepare("INSERT INTO fines (user_id, amount, description, paid, date_assessed) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("idsi", $user_id, $amount, $description, $paid);

    if ($stmt->execute()) {
        $msg = "Fine recorded successfully.";
    } else {
        $msg = "Error recording fine: " . $conn->error;
    }
}

$result = $conn->query("
    SELECT f.id, u.name, f.amount, f.description, f.paid, f.date_assessed
    FROM fines f
    JOIN users u ON f.user_id = u.id
    ORDER BY f.date_assessed DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Fines</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #007bff;
        margin-bottom: 15px;
    }
    .card {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        width: 350px;
        margin-left: auto;
        margin-right: auto;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 4px;
    }
    .form-group input {
        width: 100%;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }
    button {
        background: #007bff;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    button:hover {
        background: #0069d9;
    }
    .msg {
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }
    th {
        background: #007bff;
        color: white;
    }
    tr:hover {
        background: #f1f1f1;
    }
</style>
</head>
<body>

<h1>Manage Fines</h1>

<?php if (!empty($msg)) echo "<p class='msg' style='color:" . (strpos($msg, 'successfully') !== false ? 'green' : 'red') . ";'>$msg</p>"; ?>

<div class="card">
    <h2 style="margin-bottom: 10px; color: #007bff; font-size: 16px;">Add / Record Fine</h2>
    <form method="POST">
        <div class="form-group">
            <label>User ID</label>
            <input type="number" name="user_id" required>
        </div>
        <div class="form-group">
            <label>Amount (Rs.)</label>
            <input type="number" step="0.01" name="amount" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" required>
        </div>
        <button type="submit">Save Fine</button>
    </form>
</div>

<h2 style="text-align:center; color:#007bff; font-size:16px;">Fine Records</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Member Name</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Paid</th>
        <th>Date Assessed</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['amount'] ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= $row['paid'] ? 'Yes' : 'No' ?></td>
            <td><?= $row['date_assessed'] ?></td>
        </tr>
    <?php } ?>
</table>
<br>
<a href="librarian_dashboard.php" class="back">&larr; Back to Dashboard</a>

</body>
</html>

