<?php
session_start();
include '../config/newConnection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'librarian') {
    header("Location: ../authentication/login.php");
    exit;
}

$msg = '';

// Fetch borrowed books that are not returned yet
$borrowed = $conn->query("
    SELECT bh.id, m.name AS member_name, b.title AS book_title, bh.borrow_date 
    FROM borrow_history bh
    JOIN users m ON bh.user_id = m.id
    JOIN books b ON bh.book_id = b.id
    WHERE bh.return_date IS NULL
    ORDER BY bh.borrow_date ASC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrow_id = intval($_POST['borrow_id']);

    // Get borrow record info
    $stmt = $conn->prepare("SELECT book_id FROM borrow_history WHERE id = ? AND return_date IS NULL");
    $stmt->bind_param("i", $borrow_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $record = $result->fetch_assoc();
        $book_id = $record['book_id'];

        // Update return_date
        $update = $conn->prepare("UPDATE borrow_history SET return_date = NOW() WHERE id = ?");
        $update->bind_param("i", $borrow_id);

        if ($update->execute()) {
            // Increase book copies
            $inc = $conn->prepare("UPDATE books SET copies = copies + 1 WHERE id = ?");
            $inc->bind_param("i", $book_id);
            $inc->execute();

            $msg = "Book returned successfully.";
        } else {
            $msg = "Error updating return.";
        }
    } else {
        $msg = "Invalid borrow record selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Return Book - Library Management</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f4f8;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 500px;
        margin: 50px auto;
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
        text-align: center;
        color: #0b63b8;
        margin-bottom: 25px;
    }
    select, button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 16px;
    }
    button {
        background-color: #0b63b8;
        color: white;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }
    button:hover {
        background-color: #084b8a;
    }
    p.msg {
        background-color: #e1f0ff;
        color: #084b8a;
        padding: 10px;
        border-left: 5px solid #0b63b8;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    a {
        display: inline-block;
        margin-top: 10px;
        text-decoration: none;
        color: #0b63b8;
        transition: color 0.3s;
    }
    a:hover {
        color: #084b8a;
    }
    label {
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Return Book</h2>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <?php if ($borrowed->num_rows > 0): ?>
        <form method="POST">
            <label>Select Borrowed Book to Return:</label>
            <select name="borrow_id" required>
                <option value="">-- Select --</option>
                <?php while ($row = $borrowed->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['book_title']) ?> borrowed by <?= htmlspecialchars($row['member_name']) ?> on <?= $row['borrow_date'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Return Book</button>
        </form>
    <?php else: ?>
        <p>No borrowed books pending return.</p>
    <?php endif; ?>

    <a href="librarian_dashboard.php">&larr; Back to Dashboard</a>
</div>
</body>
</html>
