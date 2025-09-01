<?php
session_start();
include '../config/newConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Plain text password check
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect to role-specific dashboard
            if ($user['role'] === 'admin') {
                header("Location: ../admin/admin_dashboard.php");
            } elseif ($user['role'] === 'librarian') {
                header("Location: ../librarian/librarian_dashboard.php");
            } else {
                header("Location: ../member/member_dashboard.php");
            }
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Login - Library Management System</title>
<style>
/* Reset & basics */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
body {
    height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;

    /* Background image */
    background-image: url('../images/Library.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

/* Semi-transparent overlay container */
.login-container {
    background: rgba(255, 255, 255, 0.95); /* slightly transparent white */
    padding: 40px 30px;
    border-radius: 12px;
    width: 360px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
}

/* Headings */
h2 {
    margin-bottom: 24px;
    color: #333;
    font-weight: 700;
}

/* Labels & Inputs */
form label {
    display: block;
    text-align: left;
    margin-bottom: 6px;
    font-weight: 600;
    color: #555;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 20px;
    border: 1.5px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    transition: border-color 0.3s ease;
}

input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #357ABD;
    outline: none;
}

/* Submit Button */
input[type="submit"] {
    width: 100%;
    background-color: #357ABD;
    color: white;
    padding: 14px 0;
    border: none;
    border-radius: 6px;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
input[type="submit"]:hover {
    background-color: #2a5d8c;
}

/* Back to Home Button */
.back-home {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #f0f0f0;
    color: #333;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease;
}
.back-home:hover {
    background-color: #357ABD;
    color: white;
}

/* Error Message */
.error-message {
    background-color: #f8d7da;
    color: #721c24;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 20px;
    font-weight: 600;
}
</style>
</head>
<body>

<div class="login-container">
  <h2>Login</h2>

  <?php if (isset($error)): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" placeholder="you@example.com" required autofocus>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>

    <input type="submit" value="Login">
  </form>

  <!-- Back to Home Button -->
  <a class="back-home" href="../index.php">← Back to Home</a>
</div>

</body>
</html>
