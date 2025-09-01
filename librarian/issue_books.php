<?php
session_start();
include '../config/newConnection.php';

// Check if user is logged in and is a librarian
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'librarian') {
    header("Location: ../authentication/login.php");
    exit;
}

$msg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);   // Using user_id
    $book_id = intval($_POST['book_id']);

    // Check if the book exists and has copies
    $stmt = $conn->prepare("SELECT copies FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book && $book['copies'] > 0) {
        // Insert borrow record
        $stmt = $conn->prepare("INSERT INTO borrow_history (user_id, book_id, borrow_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $user_id, $book_id);
        if ($stmt->execute()) {
            // Decrease book copies
            $update = $conn->prepare("UPDATE books SET copies = copies - 1 WHERE id = ?");
            $update->bind_param("i", $book_id);
            $update->execute();

            $msg = "Book issued successfully.";
        } else {
            $msg = "Failed to issue book.";
        }
    } else {
        $msg = "No copies available or book not found.";
    }
}

// Fetch members and books for the dropdown
$members = $conn->query("SELECT id, name FROM users WHERE role = 'member' ORDER BY name");
$books = $conn->query("SELECT id, title FROM books ORDER BY title");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Issue Book - Library Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f8fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 450px;
            background: #fff;
            padding: 30px 35px;
            margin: 60px auto;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
        }
        p {
            text-align: center;
            font-weight: bold;
            color: #333;
        }
        label {
            font-weight: bold;
            color: #004080;
            display: block;
            margin-bottom: 6px;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .back-link {
            text-align: center;
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Issue Book</h2>
    <?php if ($msg) echo "<p>$msg</p>"; ?>

    <form method="POST">
        <label>Member:</label>
        <select name="user_id" required>
            <option value="">Select Member</option>
            <?php while($row = $members->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>Book:</label>
        <select name="book_id" required>
            <option value="">Select Book</option>
            <?php while($row = $books->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Issue Book</button>
    </form>

    <a class="back-link" href="librarian_dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
