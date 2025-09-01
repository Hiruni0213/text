<?php
session_start();
include '../config/newConnection.php';

// Check if user is logged in and is a member
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../authentication/login.php");
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = intval($_POST['book_id']);
    $member_id = $_SESSION['user_id'];

    // Check if the book exists and has available copies
    $stmt = $conn->prepare("SELECT copies FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
        if ($book['copies'] > 0) {
            // Record borrowing into borrow_history
            $borrow_stmt = $conn->prepare("INSERT INTO borrow_history (user_id, book_id, borrow_date) VALUES (?, ?, NOW())");
            $borrow_stmt->bind_param("ii", $member_id, $book_id);
            $borrow_stmt->execute();

            // Update copies count
            $update_stmt = $conn->prepare("UPDATE books SET copies = copies - 1 WHERE id = ?");
            $update_stmt->bind_param("i", $book_id);
            $update_stmt->execute();

            $msg = "Book borrowed successfully!";
        } else {
            $msg = "No copies available.";
        }
    } else {
        $msg = "Book not found.";
    }
}

// Fetch available books
$books = $conn->query("SELECT id, title FROM books WHERE copies > 0 ORDER BY title ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Borrow Books</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f8;
        padding: 30px;
    }
    .container {
        background: white;
        padding: 20px;
        max-width: 450px;
        margin: 0 auto;
        border-radius: 8px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
    h2 {
        text-align: center;
        color: #357ABD;
        margin-bottom: 20px;
    }
    select, button {
        width: 100%;
        padding: 12px;
        margin-top: 12px;
        font-size: 16px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    button {
        background-color: #357ABD;
        color: white;
        border: none;
        cursor: pointer;
    }
    button:hover {
        background-color: #285a8d;
    }
    .message {
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }
    .success {
        color: green;
    }
    .error {
        color: red;
    }
    .back-button {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 18px;
        background-color: #357ABD;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
    }
    .back-button:hover {
        background-color: #285a8d;
    }
</style>
</head>
<body>

<div class="container">
    <a href="member_dashboard.php" class="back-button">&#8592; Back to Dashboard</a>

    <h2>Borrow a Book</h2>

    <?php if ($msg): ?>
        <div class="message <?= (strpos(strtolower($msg), 'successfully') !== false) ? 'success' : 'error' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="book_id">Select Book</label>
        <select name="book_id" id="book_id" required>
            <option value="">-- Select a Book --</option>
            <?php while ($row = $books->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Borrow</button>
    </form>
</div>

</body>
</html>
