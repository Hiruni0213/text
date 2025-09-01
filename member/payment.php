<?php
session_start();
include '../config/newConnection.php';

// Check if logged in as member
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../authentication/login.php");
    exit;
}

$member_id = $_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount      = floatval($_POST['amount']);
    $description = trim($_POST['description']);
    $card_number = trim($_POST['card_number']);
    $card_expiry = trim($_POST['card_expiry']);
    $card_cvv    = trim($_POST['card_cvv']);

    // Basic validations
    if ($amount > 0 && !empty($description) && !empty($card_number) && !empty($card_expiry) && !empty($card_cvv)) {
        // For security: never store CVV or sensitive card data in production without PCI compliance!
        $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, description, status) VALUES (?, ?, ?, 'paid')");
        $stmt->bind_param("ids", $member_id, $amount, $description);
        if ($stmt->execute()) {
            $msg = "Payment of Rs. $amount recorded successfully.";
        } else {
            $msg = "Error recording payment. Please try again.";
        }
    } else {
        $msg = "Please enter all required payment details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Make Payment</title>
<style>
  body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 20px; }
  form { background: white; padding: 20px; border-radius: 8px; max-width: 400px; }
  label { font-weight: bold; margin-top: 10px; display: block; }
  input[type="number"], input[type="text"], input[type="month"], input[type="password"] {
    width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 6px;
  }
  button { background: #357ABD; color: white; padding: 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
  button:hover { background: #2a5d8c; }
  .message { margin-bottom: 15px; color: green; font-weight: bold; }
  .error { color: red; }
  a { display: inline-block; margin-top: 20px; color: #357ABD; font-weight: bold; text-decoration: none; }
  a:hover { text-decoration: underline; }
</style>
</head>
<body>

<h2>Make a Payment</h2>

<?php if ($msg): ?>
    <div class="message"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<form method="post" action="">
    <label for="amount">Amount (Rs.):</label>
    <input type="number" name="amount" id="amount" step="0.01" min="0.01" required>

    <label for="description">Description:</label>
    <input type="text" name="description" id="description" placeholder="e.g., Overdue Fine" required>

    <label for="card_number">Card Number:</label>
    <input type="text" name="card_number" id="card_number" maxlength="16" pattern="\d{16}" placeholder="16-digit number" required>

    <label for="card_expiry">Expiry Date:</label>
    <input type="month" name="card_expiry" id="card_expiry" required>

    <label for="card_cvv">CVV:</label>
    <input type="password" name="card_cvv" id="card_cvv" maxlength="3" pattern="\d{3}" placeholder="3-digit CVV" required>

    <button type="submit">Pay Now</button>
</form>

<a href="member_dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
